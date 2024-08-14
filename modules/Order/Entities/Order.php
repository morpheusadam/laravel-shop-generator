<?php

namespace Modules\Order\Entities;

use Modules\Cart\CartTax;
use Modules\Cart\CartItem;
use Modules\Support\Money;
use Modules\Support\State;
use Modules\Support\Country;
use Modules\Media\Entities\File;
use Modules\Tax\Entities\TaxRate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Modules\Order\OrderCollection;
use Modules\Coupon\Entities\Coupon;
use Modules\Order\Admin\OrderTable;
use Modules\Support\Eloquent\Model;
use Modules\Payment\Facades\Gateway;
use Modules\Payment\HasTransactionReference;
use Modules\Shipping\Facades\ShippingMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Transaction\Entities\Transaction;

class Order extends Model
{
    use SoftDeletes;

    const CANCELED = 'canceled';
    const COMPLETED = 'completed';
    const ON_HOLD = 'on_hold';
    const PENDING = 'pending';
    const PENDING_PAYMENT = 'pending_payment';
    const PROCESSING = 'processing';
    const REFUNDED = 'refunded';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public static function totalSales()
    {
        return Money::inDefaultCurrency(self::withoutCanceledOrders()->sum('total'));
    }


    public function status()
    {
        return trans("order::statuses.{$this->status}");
    }


    public function hasShippingMethod()
    {
        return !is_null($this->shipping_method);
    }


    public function hasCoupon()
    {
        return !is_null($this->coupon);
    }


    public function totalTax()
    {
        $total = 0;

        if ($this->hasTax()) {
            $this->taxes()
                ->get()
                ->each(function ($tax) use (&$total) {
                    $total += $tax->order_tax->amount->amount();
                });
        }

        return Money::inDefaultCurrency($total);
    }


    public function hasTax()
    {
        return $this->taxes->isNotEmpty();
    }


    public function taxes()
    {
        return $this->belongsToMany(TaxRate::class, 'order_taxes')
            ->using(OrderTax::class)
            ->as('order_tax')
            ->withPivot('amount')
            ->withTrashed();
    }


    public function salesAnalytics()
    {
        return $this->normalizeOrders($this->ordersByWeekDay())->mapWithKeys(function ($orders, $weekDay) {
            return [$weekDay => $this->dataForChart($orders)];
        });
    }


    public function coupon()
    {
        return $this->belongsTo(Coupon::class)->withTrashed();
    }


    public function getSubTotalAttribute($subTotal)
    {
        return Money::inDefaultCurrency($subTotal);
    }


    public function getShippingCostAttribute($shippingCost)
    {
        return Money::inDefaultCurrency($shippingCost);
    }


    public function getDiscountAttribute($discount)
    {
        return Money::inDefaultCurrency($discount);
    }


    public function getTaxAttribute($tax)
    {
        return Money::inDefaultCurrency($tax);
    }


    public function getTotalAttribute($total)
    {
        return Money::inDefaultCurrency($total);
    }


    /**
     * Get the order's shipping method.
     *
     * @param string $shippingMethod
     *
     * @return string
     */
    public function getShippingMethodAttribute($shippingMethod)
    {
        return ShippingMethod::get($shippingMethod)->label ?? null;
    }


    /**
     * Get the order's payment method.
     *
     * @param string $paymentMethod
     *
     * @return string
     */
    public function getPaymentMethodAttribute($paymentMethod)
    {
        return Gateway::get($paymentMethod)->label ?? '';
    }


    public function getCustomerFullNameAttribute()
    {
        return "{$this->customer_first_name} {$this->customer_last_name}";
    }


    public function getBillingFullNameAttribute()
    {
        return "{$this->billing_first_name} {$this->billing_last_name}";
    }


    public function getShippingFullNameAttribute()
    {
        return "{$this->shipping_first_name} {$this->shipping_last_name}";
    }


    public function getBillingCountryNameAttribute()
    {
        return Country::name($this->billing_country);
    }


    public function getShippingCountryNameAttribute()
    {
        return Country::name($this->shipping_country);
    }


    public function getBillingStateNameAttribute()
    {
        return State::name($this->billing_country, $this->billing_state);
    }


    public function getShippingStateNameAttribute()
    {
        return State::name($this->shipping_country, $this->shipping_state);
    }


    public function scopeWithoutCanceledOrders($query)
    {
        return $query->whereNotIn('status', [self::CANCELED, self::REFUNDED]);
    }


    public function storeProducts(CartItem $cartItem)
    {
        $orderProduct = $this->products()->create([
            'product_id' => $cartItem->product->id,
            'product_variant_id' => $cartItem->variant?->id,
            'unit_price' => $cartItem->unitPrice()->amount(),
            'qty' => $cartItem->qty,
            'line_total' => $cartItem->totalPrice()->amount(),
        ]);

        $orderProduct->storeVariations($cartItem->variations);
        $orderProduct->storeOptions($cartItem->options);
    }


    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }


    public function storeDownloads(CartItem $cartItem)
    {
        $cartItem->product->downloads->each(function (File $file) {
            $this->downloads()->create(['file_id' => $file->id]);
        });
    }


    public function downloads()
    {
        return $this->hasMany(OrderDownload::class);
    }


    public function attachTax(CartTax $cartTax)
    {
        $this->taxes()->attach($cartTax->id(), ['amount' => $cartTax->amount()->amount()]);
    }


    public function storeTransaction($response)
    {
        if (!$response instanceof HasTransactionReference) {
            return;
        }

        $this->transaction()->create([
            'transaction_id' => $response->getTransactionReference(),
            'payment_method' => $this->attributes['payment_method'],
        ]);
    }


    public function transaction()
    {
        return $this->hasOne(Transaction::class)->withTrashed();
    }


    /**
     * Get table data for the resource
     *
     * @return JsonResponse
     */
    public function table()
    {
        $query = $this->newQuery()->select(['id', 'customer_first_name', 'customer_last_name', 'customer_email', 'currency', 'total', 'status', 'created_at']);

        return new OrderTable($query);
    }


    private function normalizeOrders($orders)
    {
        return Collection::times(7)->map(function ($dayOfWeek) use ($orders) {
            return new OrderCollection($orders[$dayOfWeek] ?? []);
        });
    }


    private function ordersByWeekDay()
    {
        return self::select('total', 'created_at')
            ->withoutCanceledOrders()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->reduce(function ($ordersByWeekDay, $order) {
                $ordersByWeekDay[$order->created_at->weekday()][] = $order;

                return $ordersByWeekDay;
            });
    }


    private function dataForChart(OrderCollection $orders)
    {
        return [
            'total' => $orders->sumTotal(),
            'total_orders' => $orders->count(),
        ];
    }
}

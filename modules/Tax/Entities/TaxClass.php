<?php

namespace Modules\Tax\Entities;

use Modules\Admin\Ui\AdminTable;
use Modules\Address\StoreAddress;
use Modules\Support\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Product\Entities\Product;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxClass extends Model
{
    use Translatable, SoftDeletes;

    const SHIPPING_ADDRESS = 'shipping_address';
    const BILLING_ADDRESS = 'billing_address';
    const STORE_ADDRESS = 'store_address';
    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['label'];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['based_on'];


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


    /**
     * Get tag list.
     *
     * @return Collection
     */
    public static function list()
    {
        return Cache::tags('tax_classes')->rememberForever(md5('tax_classes.list:' . locale()), function () {
            return self::all()->sortBy('label')->pluck('label', 'id');
        });
    }


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($taxClass) {
            $taxClass->saveRates(request('rates', []));
        });
    }


    public function saveRates($rates = [])
    {
        $ids = $this->getDeleteCandidates($rates);

        if ($ids->isNotEmpty()) {
            $this->taxRates()->whereIn('id', $ids)->delete();
        }

        foreach (array_reset_index($rates) as $index => $rate) {
            $this->taxRates()->updateOrCreate(
                ['id' => $rate['id']],
                $rate + ['position' => $index]
            );
        }
    }


    public function taxRates()
    {
        return $this->hasMany(TaxRate::class)->orderBy('position');
    }


    public function findTaxRate($billing_address, $shipping_address)
    {
        $store_address = (new StoreAddress())->toArray();
        $address = $this->determineAddress(
            $billing_address,
            $shipping_address,
            $store_address
        );

        return $this->taxRates()
            ->findByAddress($address)
            ->first();
    }


    private function determineAddress($billing_address, $shipping_address, $store_address)
    {
        return match (true) {
            $this->based_on === self::SHIPPING_ADDRESS => $shipping_address ?? [],
            $this->based_on === self::BILLING_ADDRESS => $billing_address ?? [],
            $this->based_on === self::STORE_ADDRESS => $store_address ?? [],
            default => []
        };
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function table()
    {
        return new AdminTable($this->newQuery());
    }


    private function getDeleteCandidates($rates = [])
    {
        return $this->taxRates()
            ->pluck('id')
            ->diff(array_pluck($rates, 'id'));
    }
}

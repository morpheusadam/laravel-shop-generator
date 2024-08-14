<?php

namespace Modules\Coupon\Admin;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Exceptions\Exception;

class CouponTable extends AdminTable
{
    /**
     * Make table response for the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('discount', function ($coupon) {
                return $coupon->is_percent
                    ? "{$coupon->value}%"
                    : $coupon->value->format();
            });
    }
}

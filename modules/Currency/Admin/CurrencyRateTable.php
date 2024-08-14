<?php

namespace Modules\Currency\Admin;

use Modules\Currency\Currency;
use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;

class CurrencyRateTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected array $rawColumns = ['rate', 'updated_at'];


    /**
     * Make table response for the resource.
     *
     * @return JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->editColumn('currency_name', function ($currencyRate) {
                return Currency::name($currencyRate->currency);
            })
            ->editColumn('updated_at', function ($currencyRate) {
                return view('admin::partials.table.date')->with('date', $currencyRate->updated_at);
            });
    }
}

<?php

namespace Modules\Variation\Admin;

use Modules\Admin\Ui\AdminTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Exceptions\Exception;

class VariationTable extends AdminTable
{
    /**
     * Make table response for the resource.
     *
     * @return EloquentDataTable
     * @throws Exception
     */
    public function make(): EloquentDataTable
    {
        return $this->newTable()
            ->editColumn('type', function ($variation) {
                return trans("variation::variations.form.variation_types.{$variation->type}");
            })
            ->removeColumn('values');
    }
}

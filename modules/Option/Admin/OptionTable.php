<?php

namespace Modules\Option\Admin;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;

class OptionTable extends AdminTable
{
    /**
     * Make table response for the resource.
     *
     * @return JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->editColumn('type', function ($option) {
                return trans("option::options.form.option_types.{$option->type}");
            })
            ->removeColumn('values');
    }
}

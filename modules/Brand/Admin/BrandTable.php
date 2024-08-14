<?php

namespace Modules\Brand\Admin;

use Modules\Admin\Ui\AdminTable;
use Modules\Brand\Entities\Brand;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Exceptions\Exception;

class BrandTable extends AdminTable
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
            ->addColumn('logo', function (Brand $brand) {
                return view('admin::partials.table.image', [
                    'file' => $brand->logo,
                ]);
            });
    }
}

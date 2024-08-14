<?php

namespace Modules\Blog\Admin;

use Modules\Admin\Ui\AdminTable;
use Yajra\DataTables\Exceptions\Exception;

class BlogTagTable extends AdminTable
{
    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('name', function ($blogTag) {
                return $blogTag->name;
            });
    }
}

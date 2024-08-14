<?php

namespace Modules\Media\Admin;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Exceptions\Exception;

class MediaTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected array $rawColumns = ['action'];


    /**
     * Make table response for the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function make()
    {
        return $this->newTable()
            ->editColumn('thumbnail', function ($file) {
                return view('media::admin.media.partials.table.thumbnail', compact('file'));
            })
            ->addColumn('action', function ($file) {
                return view('media::admin.media.partials.table.action', compact('file'));
            });
    }
}

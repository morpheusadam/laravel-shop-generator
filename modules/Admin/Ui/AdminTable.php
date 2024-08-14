<?php

namespace Modules\Admin\Ui;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Exceptions\Exception;
use Illuminate\Contracts\Support\Responsable;

class AdminTable implements Responsable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected array $rawColumns = [];

    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected array $defaultRawColumns = [
        'checkbox', 'thumbnail', 'status', 'created', 'updated',
    ];

    /**
     * Source of the table.
     *
     * @var Builder
     */
    protected $source;


    /**
     * Create a new table instance.
     *
     * @param Builder $source
     *
     * @return void
     */
    public function __construct($source = null)
    {
        $this->source = $source;
    }


    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function toResponse($request)
    {
        return $this->make()->toJson();
    }


    /**
     * Make table response for the resource.
     *
     * @param mixed $source
     *
     * @return JsonResponse
     */
    public function make()
    {
        return $this->newTable();
    }


    /**
     * Create a new datatable instance;
     *
     * @return DataTables
     * @throws Exception
     */
    public function newTable()
    {
        return datatables($this->source)
            ->addColumn('checkbox', function ($entity) {
                return view('admin::partials.table.checkbox', compact('entity'));
            })
            ->editColumn('status', function ($entity) {
                return $entity->is_active
                    ? '<span class="badge badge-success">' . trans('admin::admin.table.active') . '</span>'
                    : '<span class="badge badge-danger">' . trans('admin::admin.table.inactive') . '</span>';
            }) 
            ->editColumn('created', function ($entity) {
                return view('admin::partials.table.date')->with('date', $entity->created_at);
            })
            ->editColumn('updated', function ($entity) {
                return view('admin::partials.table.date')->with('date', $entity->updated_at);
            })
            ->rawColumns(array_merge($this->defaultRawColumns, $this->rawColumns))
            ->removeColumn('translations');
    }
}

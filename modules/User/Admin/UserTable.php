<?php

namespace Modules\User\Admin;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class UserTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected array $rawColumns = ['last_login'];


    /**
     * Make table response for the resource.
     *
     * @return JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->editColumn('last_login', function ($user) {
                $last_login = $user->last_login;

                if (is_string($last_login)){
                    $last_login = Carbon::parse($last_login);
                }

                return view('admin::partials.table.date')->with('date', $last_login);
            });
    }
}

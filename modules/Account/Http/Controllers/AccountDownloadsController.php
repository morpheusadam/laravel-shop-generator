<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Order\Entities\Order;

class AccountDownloadsController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('storefront::public.account.downloads.index', [
            'downloads' => $this->getDownloads(),
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $file = $this->getDownloads()->firstWhere('id', decrypt($id));

        if (is_null($file) || !file_exists($file->realPath())) {
            return back()->with('error', trans('storefront::account.downloads.no_file_found'));
        }

        return response()->download($file->realPath(), $file->filename);
    }


    private function getDownloads()
    {
        return auth()->user()
            ->orders()
            ->with('downloads')
            ->where('status', Order::COMPLETED)
            ->latest()
            ->get()
            ->pluck('downloads.*.file')
            ->flatten()
            ->unique('id');
    }
}

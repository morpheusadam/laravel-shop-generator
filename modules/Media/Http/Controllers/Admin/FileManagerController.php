<?php

namespace Modules\Media\Http\Controllers\Admin;

use Illuminate\Http\Response;

class FileManagerController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $type = request('type');

        return view('media::admin.file_manager.index', compact('type'));
    }
}

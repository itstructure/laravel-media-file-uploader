<?php

namespace Itstructure\MFU\Http\Controllers\Managers;

use Illuminate\Http\Request;
use Itstructure\MFU\Http\Controllers\BaseController;

/**
 * Class FileUploadManagerController
 * @package Itstructure\MFU\Http\Controllers\Managers
 */
class FileUploadManagerController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('uploader::managers.file-upload', [
            'manager' => 'file_upload',
            'referer' => url()->previous(),
            'fromFileSetter' => !empty($request->get('from_file_setter'))
        ]);
    }
}

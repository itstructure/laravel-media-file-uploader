<?php

namespace Itstructure\MFU\Http\Controllers\Managers;

use Itstructure\MFU\Http\Controllers\BaseController;

/**
 * Class FileUploadManagerController
 * @package Itstructure\MFU\Http\Controllers\Managers
 */
class FileUploadManagerController extends BaseController
{
    public function index()
    {
        return view('uploader::managers.file-upload', [
            'manager' => 'file_upload'
        ]);
    }
}

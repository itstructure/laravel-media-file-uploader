<?php

namespace Itstructure\MFU\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class DownloadController
 * @package Itstructure\MFU\Http\Controllers
 */
class DownloadController extends BaseController
{
    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(int $id)
    {
        $fileModel = Mediafile::find($id);
        return Storage::disk($fileModel->disk)->download($fileModel->path, $fileModel->file_name);
    }
}

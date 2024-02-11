<?php

namespace Itstructure\MFU\Http\Controllers\Managers;

use Illuminate\Http\Request;
use Itstructure\MFU\Facades\Previewer;
use Itstructure\MFU\Http\Controllers\BaseController;
use Itstructure\MFU\Models\{OwnerMediafile, Mediafile};

/**
 * Class FileEditManagerController
 * @package Itstructure\MFU\Http\Controllers\Managers
 */
class FileEditManagerController extends BaseController
{
    public function index(int $id)
    {
        $mediaFile = Mediafile::find($id);
        return view('uploader::managers.file-edit', [
            'preview' => Previewer::getPreviewHtml($mediaFile, \Itstructure\MFU\Services\Previewer::LOCATION_FILE_INFO),
            'mediaFile' => $mediaFile,
            'manager' => 'file_edit',
            'referer' => url()->previous()
        ]);
    }
}

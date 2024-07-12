<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\AppExcelAlbum;

/**
 * Class AppExcelAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class AppExcelAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return AppExcelAlbum::class;
    }
}

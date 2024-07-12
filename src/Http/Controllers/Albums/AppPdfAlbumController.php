<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\AppPdfAlbum;

/**
 * Class AppPdfAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class AppPdfAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return AppPdfAlbum::class;
    }
}

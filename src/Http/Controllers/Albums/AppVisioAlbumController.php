<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\AppVisioAlbum;

/**
 * Class AppVisioAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class AppVisioAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return AppVisioAlbum::class;
    }
}

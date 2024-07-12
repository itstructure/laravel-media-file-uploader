<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\AppWordAlbum;

/**
 * Class AppWordAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class AppWordAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return AppWordAlbum::class;
    }
}

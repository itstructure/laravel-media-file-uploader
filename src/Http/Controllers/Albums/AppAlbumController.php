<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\AppAlbum;

/**
 * Class AppAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class AppAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return AppAlbum::class;
    }
}

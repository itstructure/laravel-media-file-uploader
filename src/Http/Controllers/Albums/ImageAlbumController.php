<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\ImageAlbum;

/**
 * Class ImageAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class ImageAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return ImageAlbum::class;
    }
}

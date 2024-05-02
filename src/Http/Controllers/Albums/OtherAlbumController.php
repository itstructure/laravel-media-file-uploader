<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\OtherAlbum;

/**
 * Class OtherAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class OtherAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return OtherAlbum::class;
    }
}

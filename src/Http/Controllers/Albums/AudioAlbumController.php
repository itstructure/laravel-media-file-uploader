<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\AudioAlbum;

/**
 * Class AudioAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class AudioAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return AudioAlbum::class;
    }
}

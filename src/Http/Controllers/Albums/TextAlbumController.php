<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\TextAlbum;

/**
 * Class TextAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class TextAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return TextAlbum::class;
    }
}

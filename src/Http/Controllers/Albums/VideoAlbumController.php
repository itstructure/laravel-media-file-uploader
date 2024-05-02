<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\VideoAlbum;

/**
 * Class VideoAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class VideoAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return VideoAlbum::class;
    }
}

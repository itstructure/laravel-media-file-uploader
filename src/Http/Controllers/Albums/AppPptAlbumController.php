<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Itstructure\MFU\Models\Albums\AppPptAlbum;

/**
 * Class AppPptAlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
class AppPptAlbumController extends AlbumController
{
    /**
     * @return string
     */
    protected function getModelClass():string
    {
        return AppPptAlbum::class;
    }
}

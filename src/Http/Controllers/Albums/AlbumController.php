<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Throwable;
use Illuminate\Http\Request;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Itstructure\MFU\Http\Controllers\BaseController;
use Itstructure\MFU\Models\Albums\Album;

/**
 * Class AlbumController
 * @package Itstructure\MFU\Http\Controllers\Albums
 */
abstract class AlbumController extends BaseController
{
    /**
     * @return string|Album
     */
    abstract protected function getModelClass(): string;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('uploader::albums.album-list', [
            'dataProvider' => new EloquentDataProvider((static::getModelClass())::query())
        ]);
    }
}

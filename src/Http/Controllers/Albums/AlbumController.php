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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('uploader::albums.album-list', [
            'dataProvider' => new EloquentDataProvider(($this->getModelClass())::query()->where('type', '=', $this->getAlbumType())),
            'title' => $this->getAlbumTitle(),
            'rowsFormAction' => route('uploader_' . $this->getAlbumType() . '_delete'),
            'filtersFormAction' => route('uploader_' . $this->getAlbumType() . '_list'),
        ]);
    }

    /**
     * @return string
     */
    protected function getAlbumTitle(): string
    {
        return ($this->getModelClass())::getAlbumTitle($this->getAlbumType());
    }

    /**
     * @return string
     */
    protected function getAlbumType(): string
    {
        return ($this->getModelClass())::getAlbumType();
    }
}

<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Throwable;
use Illuminate\Http\Request;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Itstructure\MFU\Http\Controllers\BaseController;
use Itstructure\MFU\Http\Requests\{StoreAlbum, UpdateAlbum, Delete};
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
        return view('uploader::albums.index', [
            'title' => $this->getAlbumTitle() . 's',
            'type' => $this->getAlbumType(),
            'dataProvider' => new EloquentDataProvider(($this->getModelClass())::query()->where('type', '=', $this->getAlbumType()))
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('uploader::albums.create', [
            'title' => 'Create ' . strtolower($this->getAlbumTitle()),
            'type' => $this->getAlbumType()
        ]);
    }

    /**
     * @param StoreAlbum $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAlbum $request)
    {
        ($this->getModelClass())::create($request->all());

        return redirect()->route('uploader_' . $this->getAlbumType() . '_list');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        return view('uploader::albums.edit', [
            'title' => 'Update ' . strtolower($this->getAlbumTitle()),
            'type' => $this->getAlbumType(),
            'model' => ($this->getModelClass())::findOrFail($id)
        ]);
    }

    /**
     * @param int $id
     * @param UpdateAlbum $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id, UpdateAlbum $request)
    {
        ($this->getModelClass())::findOrFail($id)->fill($request->all())->save();

        return redirect()->route('uploader_' . $this->getAlbumType() . '_view', ['id' => $id]);
    }

    /**
     * @param Delete $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Delete $request)
    {
        foreach ($request->items as $item) {

            if (!is_numeric($item)) {
                continue;
            }

            ($this->getModelClass())::destroy($item);
        }

        return redirect()->route('uploader_' . $this->getAlbumType() . '_list');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(int $id)
    {
        return view('uploader::albums.view', [
            'title' => 'View ' . strtolower($this->getAlbumTitle()),
            'type' => $this->getAlbumType(),
            'model' => ($this->getModelClass())::findOrFail($id)
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

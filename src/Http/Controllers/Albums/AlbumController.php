<?php

namespace Itstructure\MFU\Http\Controllers\Albums;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Itstructure\MFU\Http\Controllers\BaseController;
use Itstructure\MFU\Http\Requests\{StoreAlbum, UpdateAlbum, Delete};
use Itstructure\MFU\Models\Albums\Album;
use Itstructure\MFU\Models\Mediafile;

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
            'title' => $this->getAlbumTitle(true),
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
            'title' => trans('uploader::main.create') . ' ' . strtolower($this->getAlbumTitle()),
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
        $model = ($this->getModelClass())::findOrFail($id);

        return view('uploader::albums.edit', [
            'title' => trans('uploader::main.edit') . ' ' . strtolower($this->getAlbumTitle()),
            'type' => $this->getAlbumType(),
            'model' => $model,
            'mediaFiles' => $this->getMediaFiles($model)
        ]);
    }

    /**
     * @param int $id
     * @param UpdateAlbum $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id, UpdateAlbum $request)
    {
        ($this->getModelClass())::findOrFail($id)->update($request->all());

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
            'title' => trans('uploader::main.view') . ' ' . strtolower($this->getAlbumTitle()),
            'type' => $this->getAlbumType(),
            'model' => ($this->getModelClass())::findOrFail($id)
        ]);
    }

    /**
     * @param bool $plural
     * @return string
     */
    protected function getAlbumTitle(bool $plural = false): string
    {
        return ($this->getModelClass())::getAlbumTitle($this->getAlbumType(), $plural);
    }

    /**
     * @return string
     */
    protected function getAlbumType(): string
    {
        return ($this->getModelClass())::getAlbumType();
    }

    /**
     * @param Album $model
     * @return Collection|Mediafile[]
     */
    protected function getMediaFiles(Album $model): Collection
    {
        return $model->getMediaFiles(($this->getModelClass())::getFileType());
    }
}

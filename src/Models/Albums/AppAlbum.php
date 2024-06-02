<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class AppAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class AppAlbum extends Album
{
    /**
     * @var array
     */
    public $application;

    /**
     * @return Collection|Mediafile[]
     */
    public function getAppFiles(): Collection
    {
        return $this->getMediaFiles(static::getFileType());
    }

    /**
     * @return string
     */
    public static function getAlbumType(): string
    {
        return static::ALBUM_TYPE_APP;
    }

    /**
     * @return string
     */
    public function getItsName(): string
    {
        return static::getAlbumType();
    }

    /**
     * @return mixed
     */
    public function getPrimaryKey()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    protected static function getBehaviorAttributes(): array
    {
        return ['application'];
    }
}

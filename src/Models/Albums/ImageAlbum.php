<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class ImageAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class ImageAlbum extends Album
{
    /**
     * @var array
     */
    public $image;

    /**
     * @return Collection|Mediafile[]
     */
    public function getImageFiles(): Collection
    {
        return $this->getMediaFiles(static::getFileType(static::getAlbumType()));
    }

    /**
     * @return string
     */
    public static function getAlbumType(): string
    {
        return static::ALBUM_TYPE_IMAGE;
    }

    /**
     * @return array
     */
    protected static function getBehaviorAttributes(): array
    {
        return ['image'];
    }
}

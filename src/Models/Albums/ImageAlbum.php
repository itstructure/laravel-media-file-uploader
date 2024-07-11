<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Processors\SaveProcessor;

/**
 * Class ImageAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class ImageAlbum extends AlbumTyped
{
    /**
     * @return Collection
     */
    public function getImageFiles(): Collection
    {
        return $this->getMediaFiles(static::getFileType());
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
    public static function getBehaviorAttributes(): array
    {
        return [SaveProcessor::FILE_TYPE_IMAGE, SaveProcessor::FILE_TYPE_THUMB];
    }
}

<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Processors\SaveProcessor;

/**
 * Class VideoAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class VideoAlbum extends AlbumTyped
{
    /**
     * @return Collection
     */
    public function getVideoFiles(): Collection
    {
        return $this->getMediaFiles(static::getFileType());
    }

    /**
     * @return string
     */
    public static function getAlbumType(): string
    {
        return static::ALBUM_TYPE_VIDEO;
    }

    /**
     * @return array
     */
    public static function getBehaviorAttributes(): array
    {
        return [SaveProcessor::FILE_TYPE_VIDEO, SaveProcessor::FILE_TYPE_THUMB];
    }
}

<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Processors\SaveProcessor;

/**
 * Class AppVisioAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class AppVisioAlbum extends AlbumTyped
{
    /**
     * @return Collection
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
        return static::ALBUM_TYPE_APP_VISIO;
    }

    /**
     * @return array
     */
    public static function getBehaviorAttributes(): array
    {
        return [SaveProcessor::FILE_TYPE_APP_VISIO, SaveProcessor::FILE_TYPE_THUMB];
    }
}

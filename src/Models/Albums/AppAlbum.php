<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Processors\SaveProcessor;

/**
 * Class AppAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class AppAlbum extends AlbumTyped
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
        return static::ALBUM_TYPE_APP;
    }

    /**
     * @return array
     */
    public static function getBehaviorAttributes(): array
    {
        return [SaveProcessor::FILE_TYPE_APP, SaveProcessor::FILE_TYPE_THUMB];
    }
}

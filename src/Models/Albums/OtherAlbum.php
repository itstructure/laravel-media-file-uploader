<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Processors\SaveProcessor;

/**
 * Class OtherAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class OtherAlbum extends AlbumTyped
{
    /**
     * @return Collection
     */
    public function getOtherFiles(): Collection
    {
        return $this->getMediaFiles(static::getFileType());
    }

    /**
     * @return string
     */
    public static function getAlbumType(): string
    {
        return static::ALBUM_TYPE_OTHER;
    }

    /**
     * @return array
     */
    public static function getBehaviorAttributes(): array
    {
        return [SaveProcessor::FILE_TYPE_OTHER, SaveProcessor::FILE_TYPE_THUMB];
    }
}

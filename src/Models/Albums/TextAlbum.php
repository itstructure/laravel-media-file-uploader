<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Processors\SaveProcessor;

/**
 * Class TextAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class TextAlbum extends AlbumTyped
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
        return static::ALBUM_TYPE_TEXT;
    }

    /**
     * @return array
     */
    public static function getBehaviorAttributes(): array
    {
        return [SaveProcessor::FILE_TYPE_TEXT, SaveProcessor::FILE_TYPE_THUMB];
    }
}

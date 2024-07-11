<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Processors\SaveProcessor;

/**
 * Class AudioAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class AudioAlbum extends AlbumTyped
{
    /**
     * @return Collection
     */
    public function getAudioFiles(): Collection
    {
        return $this->getMediaFiles(static::getFileType());
    }

    /**
     * @return string
     */
    public static function getAlbumType(): string
    {
        return static::ALBUM_TYPE_AUDIO;
    }

    /**
     * @return array
     */
    public static function getBehaviorAttributes(): array
    {
        return [SaveProcessor::FILE_TYPE_AUDIO, SaveProcessor::FILE_TYPE_THUMB];
    }
}

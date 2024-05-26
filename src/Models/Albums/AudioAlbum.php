<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class AudioAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class AudioAlbum extends Album
{
    /**
     * @var array
     */
    public $audio;

    /**
     * @return Collection|Mediafile[]
     */
    public function getAudioFiles(): Collection
    {
        return $this->getMediaFiles(static::getFileType(static::getAlbumType()));
    }

    /**
     * @return string
     */
    public static function getAlbumType(): string
    {
        return static::ALBUM_TYPE_AUDIO;
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
        return ['audio'];
    }
}

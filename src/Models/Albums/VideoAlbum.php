<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class VideoAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class VideoAlbum extends Album
{
    /**
     * @var array
     */
    public $video;

    /**
     * @return Collection|Mediafile[]
     */
    public function getVideoFiles(): Collection
    {
        return $this->getMediaFiles(static::getFileType(static::getAlbumType()));
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
    protected static function getBehaviorAttributes(): array
    {
        return ['video'];
    }
}
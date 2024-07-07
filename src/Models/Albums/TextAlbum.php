<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class TextAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class TextAlbum extends Album
{
    /**
     * @var array
     */
    public $text;

    /**
     * @return Collection|Mediafile[]
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
     * @return string
     */
    public function getItsName(): string
    {
        return static::getAlbumType();
    }

    /**
     * @return array
     */
    protected static function getBehaviorAttributes(): array
    {
        return ['text'];
    }
}

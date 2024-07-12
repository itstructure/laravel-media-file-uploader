<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\Collection;
use Itstructure\MFU\Processors\SaveProcessor;

/**
 * Class AppExcelAlbum
 * @package Itstructure\MFU\Models\Albums
 */
class AppExcelAlbum extends AlbumTyped
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
        return static::ALBUM_TYPE_APP_EXCEL;
    }

    /**
     * @return array
     */
    public static function getBehaviorAttributes(): array
    {
        return [SaveProcessor::FILE_TYPE_APP_EXCEL, SaveProcessor::FILE_TYPE_THUMB];
    }
}

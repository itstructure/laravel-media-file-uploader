<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\{Collection, Builder as EloquentBuilder};
use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Models\Owners\OwnerMediafile;

/**
 * Class Album
 * @package Itstructure\MFU\Models\Albums
 */
abstract class AlbumTyped extends AlbumBase
{
    const ALBUM_TYPE_IMAGE = SaveProcessor::FILE_TYPE_IMAGE . '_album';
    const ALBUM_TYPE_AUDIO = SaveProcessor::FILE_TYPE_AUDIO . '_album';
    const ALBUM_TYPE_VIDEO = SaveProcessor::FILE_TYPE_VIDEO . '_album';
    const ALBUM_TYPE_APP   = SaveProcessor::FILE_TYPE_APP . '_album';
    const ALBUM_TYPE_TEXT  = SaveProcessor::FILE_TYPE_TEXT . '_album';
    const ALBUM_TYPE_OTHER = SaveProcessor::FILE_TYPE_OTHER . '_album';

    /**
     * @return string
     */
    abstract public static function getAlbumType(): string;

    /**
     * @param string $type
     * @param bool $plural
     * @return null|string
     */
    public static function getAlbumTitle(string $type, bool $plural = false): ?string
    {
        return static::getAlbumTypes($plural)[$type] ?? '';
    }

    /**
     * @param bool $plural
     * @return array
     */
    public static function getAlbumTypes(bool $plural = false): array
    {
        return [
            self::ALBUM_TYPE_IMAGE => trans('uploader::main.image_album' . ($plural ? 's' : '')),
            self::ALBUM_TYPE_AUDIO => trans('uploader::main.audio_album' . ($plural ? 's' : '')),
            self::ALBUM_TYPE_VIDEO => trans('uploader::main.video_album' . ($plural ? 's' : '')),
            self::ALBUM_TYPE_APP   => trans('uploader::main.applications'),
            self::ALBUM_TYPE_TEXT  => trans('uploader::main.text_files'),
            self::ALBUM_TYPE_OTHER => trans('uploader::main.other_files')
        ];
    }

    /**
     * @param string $albumType
     * @return null|string
     */
    public static function getFileType(string $albumType = null): ?string
    {
        $albumTypes = [
            self::ALBUM_TYPE_IMAGE => SaveProcessor::FILE_TYPE_IMAGE,
            self::ALBUM_TYPE_AUDIO => SaveProcessor::FILE_TYPE_AUDIO,
            self::ALBUM_TYPE_VIDEO => SaveProcessor::FILE_TYPE_VIDEO,
            self::ALBUM_TYPE_APP   => SaveProcessor::FILE_TYPE_APP,
            self::ALBUM_TYPE_TEXT  => SaveProcessor::FILE_TYPE_TEXT,
            self::ALBUM_TYPE_OTHER => SaveProcessor::FILE_TYPE_OTHER
        ];
        return array_key_exists($albumType ?? static::getAlbumType(), $albumTypes)
            ? $albumTypes[$albumType ?? static::getAlbumType()]
            : null;
    }

    /**
     * @param string|null $ownerAttribute
     * @return Collection
     */
    public function getMediaFiles(string $ownerAttribute = null): Collection
    {
        return OwnerMediafile::getMediaFiles($this->type, $this->id, $ownerAttribute);
    }

    /**
     * @param string|null $ownerAttribute
     * @return EloquentBuilder
     */
    public function getMediaFilesQuery(string $ownerAttribute = null): EloquentBuilder
    {
        return OwnerMediafile::getMediaFilesQuery([
            'owner_name' => $this->type,
            'owner_id' => $this->id,
            'owner_attribute' => $ownerAttribute,
        ]);
    }

    /**
     * @param bool $withOwners
     * @return EloquentBuilder
     */
    public static function getAllQuery(bool $withOwners = false): EloquentBuilder
    {
        return parent::getAllQuery($withOwners)->where('type', '=', static::getAlbumType());
    }
}

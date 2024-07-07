<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\{Collection, Model, Builder as EloquentBuilder};
use Illuminate\Database\Eloquent\Relations\HasMany;
use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Behaviors\Owner\BehaviorMediafile;
use Itstructure\MFU\Interfaces\BeingOwnerInterface;
use Itstructure\MFU\Models\Owners\OwnerMediafile;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class Album
 * @package Itstructure\MFU\Models\Albums
 */
abstract class AlbumTyped extends AlbumBase implements BeingOwnerInterface
{
    const ALBUM_TYPE_IMAGE = SaveProcessor::FILE_TYPE_IMAGE . '_album';
    const ALBUM_TYPE_AUDIO = SaveProcessor::FILE_TYPE_AUDIO . '_album';
    const ALBUM_TYPE_VIDEO = SaveProcessor::FILE_TYPE_VIDEO . '_album';
    const ALBUM_TYPE_APP   = SaveProcessor::FILE_TYPE_APP . '_album';
    const ALBUM_TYPE_TEXT  = SaveProcessor::FILE_TYPE_TEXT . '_album';
    const ALBUM_TYPE_OTHER = SaveProcessor::FILE_TYPE_OTHER . '_album';

    /**
     * @var string|int
     */
    public $thumbnail;

    /**
     * @var bool
     */
    protected $removeDependencies = false;

    /**
     * @return string
     */
    abstract public static function getAlbumType(): string;

    /**
     * @return array
     */
    abstract protected static function getBehaviorAttributes(): array;

    /**
     * @return array
     */
    public static function getAllBehaviorAttributes(): array
    {
        return array_merge(static::getBehaviorAttributes(), ['thumbnail']);
    }

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
     * @return mixed
     */
    public function getPrimaryKey()
    {
        return $this->getKey();
    }

    /**
     * @param bool $removeDependencies
     * @return $this
     */
    public function setRemoveDependencies(bool $removeDependencies)
    {
        $this->removeDependencies = $removeDependencies;
        return $this;
    }

    /**
     * @return bool
     */
    public function getRemoveDependencies(): bool
    {
        return $this->removeDependencies;
    }

    /**
     * @param string|null $ownerAttribute
     * @return Collection|Mediafile[]
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
     * @param array $attributes
     * @return Model
     */
    public function fill(array $attributes)
    {
        foreach (static::getAllBehaviorAttributes() as $behaviorAttribute) {
            if (isset($attributes[$behaviorAttribute])) {
                $this->{$behaviorAttribute} = $attributes[$behaviorAttribute];
            }
        }
        return parent::fill($attributes);
    }

    /**
     * @return EloquentBuilder
     */
    public static function getAllQuery(): EloquentBuilder
    {
        return static::where('type', '=', static::getAlbumType());
    }

    /**
     * @return Collection
     */
    public static function getAllEntries(): Collection
    {
        return static::getAllQuery()->get();
    }

    protected static function booted(): void
    {
        $behavior = BehaviorMediafile::getInstance(static::getAllBehaviorAttributes());

        static::saved(function (Model $ownerModel) use ($behavior) {
            $ownerModel->wasRecentlyCreated
                ? $behavior->link($ownerModel)
                : $behavior->refresh($ownerModel);
        });

        static::deleted(function (Model $ownerModel) use ($behavior) {
            $behavior->clear($ownerModel);
        });
    }
}

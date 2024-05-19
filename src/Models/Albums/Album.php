<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\{Collection, Model, Builder as EloquentBuilder};
use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Behaviors\Owner\BehaviorMediafile;
use Itstructure\MFU\Interfaces\HasOwnerInterface;
use Itstructure\MFU\Models\Owners\{OwnerAlbum, OwnerMediafile};
use Itstructure\MFU\Models\Mediafile;

/**
 * Class Album
 * @package Itstructure\MFU\Models\Albums
 */
abstract class Album extends Model implements HasOwnerInterface
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
     * @var string
     */
    protected $table = 'albums';

    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'type'];

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
     * @param int $ownerId
     * @param string $ownerName
     * @param string $ownerAttribute
     * @return bool
     */
    public function addOwner(int $ownerId, string $ownerName, string $ownerAttribute): bool
    {
        return OwnerAlbum::addOwner($this->id, $ownerId, $ownerName, $ownerAttribute);
    }

    /**
     * @param string $type
     * @return null|string
     */
    public static function getAlbumTitle(string $type): ?string
    {
        return static::getAlbumTypes()[$type] ?? '';
    }

    /**
     * @return array
     */
    public static function getAlbumTypes(): array
    {
        return [
            self::ALBUM_TYPE_IMAGE => 'Image album',
            self::ALBUM_TYPE_AUDIO => 'Audio album',
            self::ALBUM_TYPE_VIDEO => 'Video album',
            self::ALBUM_TYPE_APP   => 'Applications',
            self::ALBUM_TYPE_TEXT  => 'Text files',
            self::ALBUM_TYPE_OTHER => 'Other files'
        ];
    }

    /**
     * @param string $albumType
     * @return null|string
     */
    public static function getFileType(string $albumType): ?string
    {
        $albumTypes = [
            self::ALBUM_TYPE_IMAGE => SaveProcessor::FILE_TYPE_IMAGE,
            self::ALBUM_TYPE_AUDIO => SaveProcessor::FILE_TYPE_AUDIO,
            self::ALBUM_TYPE_VIDEO => SaveProcessor::FILE_TYPE_VIDEO,
            self::ALBUM_TYPE_APP   => SaveProcessor::FILE_TYPE_APP,
            self::ALBUM_TYPE_TEXT  => SaveProcessor::FILE_TYPE_TEXT,
            self::ALBUM_TYPE_OTHER => SaveProcessor::FILE_TYPE_OTHER
        ];
        return array_key_exists($albumType, $albumTypes) ? $albumTypes[$albumType] : null;
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
     * @return Mediafile|null
     */
    public function getThumbnailModel(): ?Mediafile
    {
        if (null === $this->type || null === $this->id) {
            return null;
        }
        return OwnerMediafile::getOwnerThumbnailModel($this->type, $this->id);
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

    protected static function booted(): void
    {
        $behavior = BehaviorMediafile::getInstance(static::getAllBehaviorAttributes());

        static::created(function (Album $ownerModel) use ($behavior) {
            $behavior->link($ownerModel);
        });

        static::updated(function (Album $ownerModel) use ($behavior) {
            $behavior->refresh($ownerModel);
        });

        static::deleted(function (Album $ownerModel) use ($behavior) {
            $behavior->clear($ownerModel);
        });
    }
}

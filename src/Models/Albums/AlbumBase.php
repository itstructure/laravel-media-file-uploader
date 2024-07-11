<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\{Model, Builder as EloquentBuilder, Collection as EloquentCollection};
use Illuminate\Database\Eloquent\Relations\HasMany;
use Itstructure\MFU\Interfaces\{HasOwnerInterface, BeingOwnerInterface};
use Itstructure\MFU\Behaviors\Owner\BehaviorMediafile;
use Itstructure\MFU\Traits\OwnerBehavior;
use Itstructure\MFU\Models\Owners\{OwnerAlbum, OwnerMediafile};
use Itstructure\MFU\Models\Mediafile;

/**
 * Class AlbumBase
 * @package Itstructure\MFU\Models\Albums
 */
class AlbumBase extends Model implements HasOwnerInterface, BeingOwnerInterface
{
    use OwnerBehavior;

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
    public function getItsName(): string
    {
        return $this->type;
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
    public static function getBehaviorAttributes(): array
    {
        return [];
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
     * @param string|null $ownerAttribute
     * @return EloquentCollection
     */
    public function getMediaFiles(string $ownerAttribute = null): EloquentCollection
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
     * @return HasMany
     */
    public function owners(): HasMany
    {
        return $this->hasMany(OwnerAlbum::class, 'album_id', 'id');
    }

    /**
     * @param bool $withOwners
     * @return EloquentBuilder
     */
    public static function getAllQuery(bool $withOwners = false): EloquentBuilder
    {
        return static::query()->when($withOwners, function ($q) {
            $q->with('owners');
        });
    }

    /**
     * @param bool $withOwners
     * @return EloquentCollection
     */
    public static function getAll(bool $withOwners = false): EloquentCollection
    {
        return static::getAllQuery($withOwners)->get();
    }

    public static function getAllForOwner(BeingOwnerInterface $ownerModel): SupportCollection
    {
        return static::getAll(true)->map(function ($album) use ($ownerModel) {
            $album->relates = false;
            $album->owners->map(function (OwnerAlbum $ownerAlbum) use ($album, $ownerModel) {
                if ($ownerModel->getItsName() == $ownerAlbum->getOwnerName() && $ownerModel->getPrimaryKey() == $ownerAlbum->getOwnerId()) {
                    $album->relates = true;
                }
            });
            return $album;
        });
    }

    protected static function booted(): void
    {
        $behavior = BehaviorMediafile::getInstance(static::getBehaviorAttributes());

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

<?php

namespace Itstructure\MFU\Models\Albums;

use Illuminate\Database\Eloquent\{Collection, Model, Builder as EloquentBuilder};
use Illuminate\Database\Eloquent\Relations\HasMany;
use Itstructure\MFU\Interfaces\HasOwnerInterface;
use Itstructure\MFU\Models\Owners\{OwnerAlbum, OwnerMediafile};
use Itstructure\MFU\Models\Mediafile;

/**
 * Class AlbumBase
 * @package Itstructure\MFU\Models\Albums
 */
class AlbumBase extends Model implements HasOwnerInterface
{
    /**
     * @var string
     */
    protected $table = 'albums';

    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'type'];

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
     * @return HasMany
     */
    public function owners(): HasMany
    {
        return $this->hasMany(OwnerAlbum::class, 'album_id', 'id');
    }
}

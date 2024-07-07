<?php

namespace Itstructure\MFU\Models\Owners;

use Illuminate\Database\Eloquent\{Collection, Builder as EloquentBuilder};
use Itstructure\MFU\Facades\Uploader;
use Itstructure\MFU\Traits\HasCompositePrimaryKey;
use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Models\Mediafile;

/**
 * Class OwnerMediafile
 * @package Itstructure\MFU\Models\Owners
 */
class OwnerMediafile extends Owner
{
    use HasCompositePrimaryKey;

    public $incrementing = false;

    protected $primaryKey = ['mediafile_id', 'owner_id', 'owner_name', 'owner_attribute'];

    protected $table = 'owners_mediafiles';

    protected $fillable = ['mediafile_id', 'owner_id', 'owner_name', 'owner_attribute'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getMediaFile()
    {
        return $this->hasOne(Mediafile::class, 'mediafile_id', 'id');
    }

    /**
     * Get all mediafiles by owner.
     * @param string $ownerName
     * @param int    $ownerId
     * @param null|string $ownerAttribute
     * @return Collection|Mediafile[]
     */
    public static function getMediaFiles(string $ownerName, int $ownerId, string $ownerAttribute = null): Collection
    {
        return static::getMediaFilesQuery(static::buildFilterOptions($ownerId, $ownerName, $ownerAttribute))->get();
    }

    /**
     * Get all mediafiles query by owner.
     * @param array $args. It can be an array of the next params: owner_name{string}, owner_id{int}, owner_attribute{string}.
     * @return EloquentBuilder
     */
    public static function getMediaFilesQuery(array $args = []): EloquentBuilder
    {
        return Mediafile::query()->whereIn('id', static::getEntityIdsQuery('mediafile_id', $args)->get()->pluck('mediafile_id'));
    }

    /**
     * Get one owner thumbnail file by owner.
     * @param string $ownerName
     * @param int    $ownerId
     * @return Mediafile|null
     */
    public static function getOwnerThumbnailModel(string $ownerName, int $ownerId): ?Mediafile
    {
        $ownerMediafileModel = static::getEntityIdsQuery('mediafile_id', [
            'owner_name' => $ownerName,
            'owner_id' => $ownerId,
            'owner_attribute' => SaveProcessor::FILE_TYPE_THUMB,
        ])->first();

        if (null === $ownerMediafileModel) {
            return null;
        }

        return Mediafile::find($ownerMediafileModel->mediafile_id);
    }

    /**
     * Get image files by owner.
     * @param string $ownerName
     * @param int    $ownerId
     * @return Collection|Mediafile[]
     */
    public static function getImageFiles(string $ownerName, int $ownerId): Collection
    {
        return static::getMediaFiles($ownerName, $ownerId, SaveProcessor::FILE_TYPE_IMAGE);
    }

    /**
     * Get audio files by owner.
     * @param string $ownerName
     * @param int    $ownerId
     * @return Collection|Mediafile[]
     */
    public static function getAudioFiles(string $ownerName, int $ownerId): Collection
    {
        return static::getMediaFiles($ownerName, $ownerId, SaveProcessor::FILE_TYPE_AUDIO);
    }

    /**
     * Get video files by owner.
     * @param string $ownerName
     * @param int    $ownerId
     * @return Collection|Mediafile[]
     */
    public static function getVideoFiles(string $ownerName, int $ownerId): Collection
    {
        return static::getMediaFiles($ownerName, $ownerId, SaveProcessor::FILE_TYPE_VIDEO);
    }

    /**
     * Get app files by owner.
     * @param string $ownerName
     * @param int    $ownerId
     * @return Collection|Mediafile[]
     */
    public static function getAppFiles(string $ownerName, int $ownerId): Collection
    {
        return static::getMediaFiles($ownerName, $ownerId, SaveProcessor::FILE_TYPE_APP);
    }

    /**
     * Get text files by owner.
     * @param string $ownerName
     * @param int    $ownerId
     * @return Collection|Mediafile[]
     */
    public static function getTextFiles(string $ownerName, int $ownerId): Collection
    {
        return static::getMediaFiles($ownerName, $ownerId, SaveProcessor::FILE_TYPE_TEXT);
    }

    /**
     * Get other files by owner.
     * @param string $ownerName
     * @param int    $ownerId
     * @return Collection|Mediafile[]
     */
    public static function getOtherFiles(string $ownerName, int $ownerId): Collection
    {
        return static::getMediaFiles($ownerName, $ownerId, SaveProcessor::FILE_TYPE_OTHER);
    }

    /**
     * Get model mediafile primary key name.
     * @return string
     */
    protected static function getDependencyKeyName(): string
    {
        return 'mediafile_id';
    }

    /**
     * @param int $mediafileId
     * @return bool
     */
    protected static function removeDependency(int $mediafileId): bool
    {
        return Uploader::delete($mediafileId);
    }
}

<?php

namespace Itstructure\MFU\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Interfaces\HasOwnerInterface;
use Itstructure\MFU\Models\Owners\OwnerMediafile;

class Mediafile extends Model implements HasOwnerInterface
{
    protected $table = 'mediafiles';

    protected $fillable = ['file_name', 'mime_type', 'path', 'alt', 'size', 'title', 'description', 'thumbs', 'disk'];

    protected $casts = [
        'thumbs' => 'array',
    ];

    /**
     * @param array $mimeTypes
     * @return Collection
     */
    public static function findByMimeTypes(array $mimeTypes): Collection
    {
        return static::whereIn('mime_type', $mimeTypes)->get();
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return null|string
     */
    public function getAlt(): ?string
    {
        return $this->alt;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDisk(): string
    {
        return $this->disk;
    }

    /**
     * @return array
     */
    public function getThumbs(): array
    {
        return $this->thumbs;
    }

    /**
     * @param string $alias
     * @return string
     */
    public function getThumbPath(string $alias): string
    {
        if ($alias == SaveProcessor::THUMB_ALIAS_ORIGINAL) {
            return $this->getPath();
        }
        $thumbs = $this->getThumbs();
        return !empty($thumbs[$alias]) ? $thumbs[$alias] : $this->getPath();
    }

    /**
     * @param string $alias
     * @return string
     */
    public function getThumbUrl(string $alias = SaveProcessor::THUMB_ALIAS_DEFAULT): string
    {
        return Storage::disk($this->getDisk())->url($this->getThumbPath($alias));
    }

    /**
     * @return string
     */
    public function getOriginalUrl(): string
    {
        return Storage::disk($this->getDisk())->url($this->getPath());
    }

    /**
     * @param int $ownerId
     * @param string $ownerName
     * @param string $ownerAttribute
     * @return bool
     */
    public function addOwner(int $ownerId, string $ownerName, string $ownerAttribute): bool
    {
        return OwnerMediafile::addOwner($this->id, $ownerId, $ownerName, $ownerAttribute);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getOwners()
    {
        return $this->hasMany(OwnerMediafile::class, 'mediafile_id', 'id');
    }

    /**
     * Check if the file is image.
     * @return bool
     */
    public function isImage(): bool
    {
        return SaveProcessor::isImage($this->mime_type);
    }

    /**
     * Check if the file is audio.
     * @return bool
     */
    public function isAudio(): bool
    {
        return SaveProcessor::isAudio($this->mime_type);
    }

    /**
     * Check if the file is video.
     * @return bool
     */
    public function isVideo(): bool
    {
        return SaveProcessor::isVideo($this->mime_type);
    }

    /**
     * Check if the file is text.
     * @return bool
     */
    public function isText(): bool
    {
        return SaveProcessor::isText($this->mime_type);
    }

    /**
     * Check if the file is application.
     * @return bool
     */
    public function isApp(): bool
    {
        return SaveProcessor::isApp($this->mime_type);
    }

    /**
     * Check if the file is word.
     * @return bool
     */
    public function isWord(): bool
    {
        return SaveProcessor::isWord($this->mime_type);
    }

    /**
     * Check if the file is excel.
     * @return bool
     */
    public function isExcel(): bool
    {
        return SaveProcessor::isExcel($this->mime_type);
    }

    /**
     * Check if the file is visio.
     * @return bool
     */
    public function isVisio(): bool
    {
        return SaveProcessor::isVisio($this->mime_type);
    }

    /**
     * Check if the file is PowerPoint.
     * @return bool
     */
    public function isPowerPoint(): bool
    {
        return SaveProcessor::isPowerPoint($this->mime_type);
    }

    /**
     * Check if the file is pdf.
     * @return bool
     */
    public function isPdf(): bool
    {
        return SaveProcessor::isPdf($this->mime_type);
    }
}

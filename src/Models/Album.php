<?php

namespace Itstructure\MFU\Models;

use Illuminate\Database\Eloquent\Model;
use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Interfaces\HasOwnerInterface;

class Album extends Model implements HasOwnerInterface
{
    const ALBUM_TYPE_IMAGE = SaveProcessor::FILE_TYPE_IMAGE . '_album';
    const ALBUM_TYPE_AUDIO = SaveProcessor::FILE_TYPE_AUDIO . '_album';
    const ALBUM_TYPE_VIDEO = SaveProcessor::FILE_TYPE_VIDEO . '_album';
    const ALBUM_TYPE_APP   = SaveProcessor::FILE_TYPE_APP . '_album';
    const ALBUM_TYPE_TEXT  = SaveProcessor::FILE_TYPE_TEXT . '_album';
    const ALBUM_TYPE_OTHER = SaveProcessor::FILE_TYPE_OTHER . '_album';

    protected $table = 'albums';

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
}

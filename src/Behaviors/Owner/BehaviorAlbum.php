<?php

namespace Itstructure\MFU\Behaviors\Owner;

use Itstructure\MFU\Interfaces\HasOwnerInterface;
use Itstructure\MFU\Models\Albums\Album;
use Itstructure\MFU\Models\Owners\OwnerAlbum;

/**
 * Class BehaviorAlbum
 * @package Itstructure\MFU\Behaviors\Owner
 */
class BehaviorAlbum extends Behavior
{
    /**
     * @param $attributeValue
     * @return HasOwnerInterface|null
     */
    protected function getChildModel($attributeValue): ?HasOwnerInterface
    {
        return Album::where($this->findChildModelKey, '=', $attributeValue)->first();
    }

    /**
     * @param int $ownerId
     * @param string $ownerName
     * @param string $ownerAttribute
     * @return bool
     */
    protected function removeOwner(int $ownerId, string $ownerName, string $ownerAttribute): bool
    {
        return OwnerAlbum::removeOwner($ownerId, $ownerName, $ownerAttribute);
    }
}

<?php

namespace Itstructure\MFU\Behaviors\Owner;

use Itstructure\MFU\Interfaces\HasOwnerInterface;
use Itstructure\MFU\Models\{Mediafile, OwnerMediafile};

/**
 * Class BehaviorMediafile
 * @package Itstructure\MFU\Behaviors\Owner
 */
class BehaviorMediafile extends Behavior
{
    /**
     * @param $attributeValue
     * @return HasOwnerInterface|null
     */
    protected function getChildModel($attributeValue): ?HasOwnerInterface
    {
        return Mediafile::where($this->findChildModelKey, '=', $attributeValue)->first();
    }

    /**
     * @param int $ownerId
     * @param string $ownerName
     * @param string $ownerAttribute
     * @return bool
     */
    protected function removeOwner(int $ownerId, string $ownerName, string $ownerAttribute): bool
    {
        return OwnerMediafile::removeOwner($ownerId, $ownerName, $ownerAttribute);
    }
}

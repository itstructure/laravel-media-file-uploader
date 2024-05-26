<?php

namespace Itstructure\MFU\Interfaces;

/**
 * Interface HasOwnerInterface
 * @package Itstructure\MFU\Interfaces
 */
interface HasOwnerInterface
{
    /**
     * @param int $ownerId
     * @param string $ownerName
     * @param string $ownerAttribute
     * @return bool
     */
    public function addOwner(int $ownerId, string $ownerName, string $ownerAttribute): bool;
}

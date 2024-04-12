<?php

namespace Itstructure\MFU\Interfaces;

interface HasOwnerInterface
{
    public function addOwner(int $ownerId, string $ownerName, string $ownerAttribute): bool;
}

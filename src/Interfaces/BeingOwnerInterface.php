<?php

namespace Itstructure\MFU\Interfaces;

/**
 * Interface BeingOwnerInterface
 * @package Itstructure\MFU\Interfaces
 */
interface BeingOwnerInterface
{
    /**
     * @return string
     */
    public function getItsName(): string ;

    /**
     * @return mixed
     */
    public function getPrimaryKey();
}

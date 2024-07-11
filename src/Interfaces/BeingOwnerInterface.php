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
    public function getItsName(): string;

    /**
     * @return mixed
     */
    public function getPrimaryKey();

    /**
     * @return array
     */
    public static function getBehaviorAttributes(): array;

    /**
     * @param string $attribute
     * @param mixed $value
     * @return $this
     */
    public function setBehaviorValue(string $attribute, $value);

    /**
     * @param string $attribute
     * @return mixed
     */
    public function getBehaviorValue(string $attribute);

    /**
     * @param bool $removeDependencies
     * @return $this
     */
    public function setRemoveDependencies(bool $removeDependencies);

    /**
     * @return bool
     */
    public function getRemoveDependencies(): bool;
}

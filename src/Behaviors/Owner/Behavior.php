<?php

namespace Itstructure\MFU\Behaviors\Owner;

use Illuminate\Database\Eloquent\Model;
use Itstructure\MFU\Interfaces\{HasOwnerInterface, BeingOwnerInterface};

/**
 * Class Behavior
 * @package Itstructure\MFU\Behaviors\Owner
 */
abstract class Behavior
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $findChildModelKey;

    /**
     * @param $attributeValue
     * @return HasOwnerInterface|null
     */
    abstract protected function getChildModel($attributeValue): ?HasOwnerInterface;

    /**
     * @param int $ownerId
     * @param string $ownerName
     * @param string $ownerAttribute
     * @return bool
     */
    abstract protected function removeOwner(int $ownerId, string $ownerName, string $ownerAttribute): bool;

    /**
     * @param array $attributes
     * @param string $findChildModelKey
     * @return static
     */
    public static function getInstance(array $attributes, string $findChildModelKey = 'id')
    {
        return new static($attributes, $findChildModelKey);
    }

    /**
     * Behavior constructor.
     * @param array $attributes
     * @param string $findChildModelKey
     */
    protected function __construct(array $attributes, string $findChildModelKey)
    {
        $this->attributes = $attributes;
        $this->findChildModelKey = $findChildModelKey;
    }

    /**
     * @param BeingOwnerInterface|Model $ownerModel
     */
    public function link(BeingOwnerInterface $ownerModel): void
    {
        foreach ($this->attributes as $attributeName) {
            $this->linkOwner($ownerModel, $attributeName, $ownerModel->{$attributeName});
        }
    }

    /**
     * @param BeingOwnerInterface|Model $ownerModel
     */
    public function refresh(BeingOwnerInterface $ownerModel): void
    {
        foreach ($this->attributes as $attributeName) {
            $this->removeOwner($ownerModel->getPrimaryKey(), $ownerModel->getItsName(), $attributeName);
            $this->linkOwner($ownerModel, $attributeName, $ownerModel->{$attributeName});
        }
    }

    /**
     * @param BeingOwnerInterface|Model $ownerModel
     */
    public function clear(BeingOwnerInterface $ownerModel): void
    {
        foreach ($this->attributes as $attributeName) {
            $this->removeOwner($ownerModel->getPrimaryKey(), $ownerModel->getItsName(), $attributeName);
        }
    }

    /**
     * @param BeingOwnerInterface|Model $ownerModel
     * @param $attributeName
     * @param $attributeValue
     */
    protected function linkOwner(BeingOwnerInterface $ownerModel, $attributeName, $attributeValue): void
    {
        if (is_array($attributeValue)) {
            foreach ($attributeValue as $item) {
                if (empty($item)) {
                    continue;
                }
                $this->linkOwner($ownerModel, $attributeName, $item);
            }

        } else if (!empty($attributeValue)) {
            $childModel = $this->getChildModel($attributeValue);
            if (empty($childModel)) {
                return;
            }
            $childModel->addOwner($ownerModel->getPrimaryKey(), $ownerModel->getItsName(), $attributeName);
        }
    }
}

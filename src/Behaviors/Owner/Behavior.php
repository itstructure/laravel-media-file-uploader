<?php

namespace Itstructure\MFU\Behaviors\Owner;

use Illuminate\Database\Eloquent\Model;
use Itstructure\MFU\Interfaces\HasOwnerInterface;

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

    public function link(Model $ownerModel): void
    {
        foreach ($this->attributes as $attributeName) {
            $this->linkChildWithOwner($ownerModel, $attributeName, $ownerModel->{$attributeName});
        }
    }

    public function refresh(Model $ownerModel): void
    {
        foreach ($this->attributes as $attributeName) {
            $this->removeOwner($ownerModel->getKey(), $ownerModel->getTable(), $attributeName);
            $this->linkChildWithOwner($ownerModel, $attributeName, $ownerModel->{$attributeName});
        }
    }

    public function clear(Model $ownerModel): void
    {
        foreach ($this->attributes as $attributeName) {
            $this->removeOwner($ownerModel->getKey(), $ownerModel->getTable(), $attributeName);
        }
    }

    /**
     * @param Model $ownerModel
     * @param $attributeName
     * @param $attributeValue
     */
    protected function linkChildWithOwner(Model $ownerModel, $attributeName, $attributeValue): void
    {
        if (is_array($attributeValue)) {
            foreach ($attributeValue as $item) {
                if (empty($item)) {
                    continue;
                }
                $this->linkChildWithOwner($ownerModel, $attributeName, $item);
            }

        } else if (!empty($attributeValue)) {
            $childModel = $this->getChildModel($attributeValue);
            if (empty($childModel)) {
                return;
            }
            $childModel->addOwner($ownerModel->getKey(), $ownerModel->getTable(), $attributeName);
        }
    }
}

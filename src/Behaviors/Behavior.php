<?php

namespace Itstructure\MFU\Behaviors;

use Illuminate\Database\Eloquent\Model;
use Itstructure\MFU\Interfaces\HasOwnerInterface;

/**
 * Class Behavior
 * @package Itstructure\MFU\Behaviors
 */
abstract class Behavior
{
    /**
     * @var Model
     */
    protected $ownerModel;

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
     * @param Model $ownerModel
     * @param array $attributes
     * @param string $findChildModelKey
     * @return static
     */
    public static function getInstance(Model $ownerModel, array $attributes, string $findChildModelKey = 'id')
    {
        return new static($ownerModel, $attributes, $findChildModelKey);
    }

    /**
     * Behavior constructor.
     * @param Model $ownerModel
     * @param array $attributes
     * @param string $findChildModelKey
     */
    protected function __construct(Model $ownerModel, array $attributes, string $findChildModelKey)
    {
        $this->ownerModel = $ownerModel;
        $this->attributes = $attributes;
        $this->findChildModelKey = $findChildModelKey;
    }

    public function addOwners(): void
    {
        foreach ($this->attributes as $attributeName) {
            $this->linkChildWithOwner($attributeName, $this->ownerModel->{$attributeName});
        }
    }

    public function updateOwners(): void
    {
        foreach ($this->attributes as $attributeName) {
            $this->removeOwner($this->ownerModel->getKey(), $this->ownerModel->getTable(), $attributeName);
            $this->linkChildWithOwner($attributeName, $this->ownerModel->{$attributeName});
        }
    }

    public function deleteOwners(): void
    {
        foreach ($this->attributes as $attributeName) {
            $this->removeOwner($this->ownerModel->getKey(), $this->ownerModel->getTable(), $attributeName);
        }
    }

    /**
     * @param $attributeName
     * @param $attributeValue
     */
    protected function linkChildWithOwner($attributeName, $attributeValue): void
    {
        if (is_array($attributeValue)) {
            foreach ($attributeValue as $item) {
                if (empty($item)) {
                    continue;
                }
                $this->linkChildWithOwner($attributeName, $item);
            }

        } else if (!empty($attributeValue)) {
            $childModel = $this->getChildModel($attributeValue);
            if (empty($childModel)) {
                return;
            }
            $childModel->addOwner($this->ownerModel->getKey(), $this->ownerModel->getTable(), $attributeName);
        }
    }
}

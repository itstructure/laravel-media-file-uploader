<?php

namespace Itstructure\MFU\Traits;

use Illuminate\Database\Eloquent\Model;

trait OwnerBehavior
{
    /**
     * @var array
     */
    protected $behaviorValues = [];

    /**
     * @var bool
     */
    protected $removeDependencies = false;

    /**
     * @param string $attribute
     * @param mixed $value
     * @return $this
     */
    public function setBehaviorValue(string $attribute, $value)
    {
        $this->behaviorValues[$attribute] = $value;
        return $this;
    }

    /**
     * @param string $attribute
     * @return mixed
     */
    public function getBehaviorValue(string $attribute)
    {
        return $this->behaviorValues[$attribute] ?? null;
    }

    /**
     * @param bool $removeDependencies
     * @return $this
     */
    public function setRemoveDependencies(bool $removeDependencies)
    {
        $this->removeDependencies = $removeDependencies;
        return $this;
    }

    /**
     * @return bool
     */
    public function getRemoveDependencies(): bool
    {
        return $this->removeDependencies;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function fill(array $attributes)
    {
        foreach (static::getBehaviorAttributes() as $behaviorAttribute) {
            if (isset($attributes[$behaviorAttribute])) {
                $this->setBehaviorValue($behaviorAttribute, $attributes[$behaviorAttribute]);
            }
        }
        return parent::fill($attributes);
    }
}
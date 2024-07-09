<?php

namespace Itstructure\MFU\Models\Owners;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\{Collection, Model, Builder as EloquentBuilder};

/**
 * Class Owner
 * @package Itstructure\MFU\Models\Owners
 */
abstract class Owner extends Model
{
    /**
     * Get model (mediafile/album) primary key name.
     * @return string
     */
    abstract protected static function getDependencyKeyName(): string;

    /**
     * Remove:
     * 1. Mediafile entry with physical directories and files when album is removed.
     * 2. Album entry with related mediafiles and physical directories and files when parent entity (Product, Post, Page e.t.c) is removed.
     * @param int $entityId
     * @return bool
     */
    abstract protected static function removeDependency(int $entityId): bool;

    /**
     * Add owner to mediafiles table.
     * @param int    $modelId
     * @param int    $ownerId
     * @param string $ownerName
     * @param string $ownerAttribute
     * @return bool
     */
    public static function addOwner(int $modelId, int $ownerId, string $ownerName, string $ownerAttribute): bool
    {
        $ownerModel = new static();
        $ownerModel->{static::getDependencyKeyName()} = $modelId;
        $ownerModel->owner_id = $ownerId;
        $ownerModel->owner_name = $ownerName;
        $ownerModel->owner_attribute = $ownerAttribute;

        return $ownerModel->save();
    }

    /**
     * Remove this mediafile/album owner.
     * @param int $ownerId
     * @param string $ownerName
     * @param string|null $ownerAttribute
     * @param bool $removeDependencies
     * @return bool
     */
    public static function removeOwner(int $ownerId, string $ownerName, string $ownerAttribute = null, bool $removeDependencies = false): bool
    {
        $query = static::query();
        foreach (static::buildFilterOptions($ownerId, $ownerName, $ownerAttribute) as $attribute => $value) {
            /* @var QueryBuilder $q */
            $query->where($attribute, '=', $value);
        }
        $entries = $query->get();
        $thisOwnerEntityIds = $entries->pluck(static::getDependencyKeyName())->toArray();
        $otherOwnerEntityIds = static::filterMultipliedEntityIds($ownerId, $ownerName, $thisOwnerEntityIds)
            ->pluck(static::getDependencyKeyName())
            ->toArray();
        $deleted = 0;
        foreach ($entries as $entry) {
            $entityId = $entry->{static::getDependencyKeyName()};
            $entry->delete();
            if ($removeDependencies && !in_array($entityId, $otherOwnerEntityIds)) {
                static::removeDependency($entityId);
            }
            $deleted++;
        }
        return $deleted > 0;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    /**
     * @return string
     */
    public function getOwnerName(): string
    {
        return $this->owner_name;
    }

    /**
     * Getting entity id's which are related with Other owners too.
     * @param int $ownerId
     * @param string $ownerName
     * @param array $entityIds
     * @return Collection|static[]
     */
    public static function filterMultipliedEntityIds(int $ownerId, string $ownerName, array $entityIds): Collection
    {
        return static::query()->select(static::getDependencyKeyName())
            ->whereIn(static::getDependencyKeyName(), $entityIds)
            ->where(function ($q) use ($ownerId, $ownerName) {
                /* @var QueryBuilder $q */
                $q->where('owner_id', '!=', $ownerId)
                    ->orWhere('owner_name', '!=', $ownerName);
            })
            ->get();
    }

    /**
     * Get Id's by owner.
     * @param string $nameId
     * @param array $args It can be an array of the next params: owner_name{string}, owner_id{int}, owner_attribute{string}.
     * @return EloquentBuilder
     */
    protected static function getEntityIdsQuery(string $nameId, array $args): EloquentBuilder
    {
        return static::query()->select($nameId)->when(count($args) > 0, function($q) use ($args) {
            foreach ($args as $attribute => $value) {
                /* @var QueryBuilder $q */
                $q->where($attribute, $value);
            }
        });
    }

    /**
     * Build filter options for some actions.
     * @param int $ownerId
     * @param string $ownerName
     * @param string|null $ownerAttribute
     * @return array
     */
    protected static function buildFilterOptions(int $ownerId, string $ownerName, string $ownerAttribute = null): array
    {
        return array_merge([
            'owner_id' => $ownerId,
            'owner_name' => $ownerName
        ], empty($ownerAttribute) ? [] : ['owner_attribute' => $ownerAttribute]);
    }
}

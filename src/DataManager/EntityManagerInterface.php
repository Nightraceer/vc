<?php


namespace TestWork\DataManager;


use TestWork\DataManager\Entity\EntityInterface;
use TestWork\DataManager\Entity\EntityProperty;

/**
 * Interface EntityManagerInterface
 * @package TestWork\DataManager
 */
interface EntityManagerInterface
{
    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     */
    public function create(EntityInterface $entity): EntityInterface;

    /**
     * @param EntityInterface $entity
     */
    public function update(EntityInterface $entity): void;

    /**
     * @param EntityInterface $entity
     */
    public function remove(EntityInterface $entity): void;

    /**
     * @param array $conditions
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $order
     * @return array
     */
    public function find(array $conditions = [], ?int $limit = null, ?int $offset = null, ?array $order = null): array;

    /**
     * @return EntityProperty
     */
    public function getEntityProperty(): EntityProperty;
}

<?php


namespace TestWork\DataManager\EntityFactory;


use TestWork\DataManager\Entity\EntityInterface;

interface EntityFactoryInterface
{
    /**
     * @param array $array
     * @return EntityInterface
     */
    public function factory(array $array): EntityInterface;

    /**
     * @param array $array
     * @return EntityInterface
     */
    public function create(array $array): EntityInterface;

    /**
     * @param EntityInterface $entity
     * @param array $array
     * @return EntityInterface
     */
    public function modify(EntityInterface $entity, array $array): EntityInterface;
}

<?php


namespace TestWork\DataManager\Entity;


use TestWork\DataManager\Serializer\ArrayableInterface;

/**
 * Interface EntityInterface
 * @package TestWork\DataManager\Entity
 */
interface EntityInterface extends ArrayableInterface
{
    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self;

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return EntityProperty
     */
    public function getProperty(): EntityProperty;
}

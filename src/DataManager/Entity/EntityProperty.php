<?php


namespace TestWork\DataManager\Entity;

/**
 * Class EntityProperty
 * @package TestWork\DataManager\Entity
 */
class EntityProperty
{
    private string $id;

    private string $table;

    /**
     * EntityProperty constructor.
     * @param string $id
     * @param string $table
     */
    public function __construct(string $id, string $table)
    {
        $this->id = $id;
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }
}

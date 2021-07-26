<?php


namespace TestWork\DataManager\Serializer;

/**
 * Interface ArrayableInterface
 * @package TestWork\DataManager\Serializer
 */
interface ArrayableInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}

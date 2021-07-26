<?php


namespace TestWork\DataManager;


use TestWork\DataManager\Entity\Advertisement;
use TestWork\DataManager\Entity\EntityInterface;
use TestWork\DataManager\Entity\EntityProperty;
use TestWork\DataManager\Exception\NotFoundException;

/**
 * Class AdvertisementManager
 * @package TestWork\DataManager
 */
class AdvertisementManager extends AbstractEntityManager
{
    /**
     * @return EntityProperty
     */
    public function getEntityProperty(): EntityProperty
    {
        return (new Advertisement())->getProperty();
    }

    /**
     * @return EntityInterface
     *
     * @throws NotFoundException
     */
    public function findRelevant(): EntityInterface
    {
        $stmt = $this->db->query('SELECT * FROM `advertisements` WHERE `limit` > `showing` ORDER BY `price` DESC limit 0, 1');
        $result = $stmt->fetch();

        if (!$result) {
            throw new NotFoundException();
        }

        return $this->factoryEntity($result);
    }
}

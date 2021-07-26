<?php


namespace TestWork\DataManager\EntityFactory;


use TestWork\Utils\DateTime;
use TestWork\DataManager\Entity\Advertisement;
use TestWork\DataManager\Entity\EntityInterface;

/**
 * Class AdvertisementFactory
 * @package TestWork\DataManager\EntityFactory
 */
class AdvertisementFactory implements EntityFactoryInterface
{
    /**
     * @param array $array
     * @return EntityInterface
     */
    public function factory(array $array): EntityInterface
    {
        return new Advertisement(
            $array['id'],
            $array['text'],
            $array['price'],
            $array['limit'],
            $array['banner'],
            $array['showing'],
            new DateTime($array['updated_at']),
            new DateTime($array['created_at'])
        );
    }

    /**
     * @param array $array
     * @return EntityInterface
     */
    public function create(array $array): EntityInterface
    {
        $entity = new Advertisement();

        return $this->modify($entity, $array);
    }

    /**
     * @param EntityInterface $entity
     * @param array $array
     * @return EntityInterface
     */
    public function modify(EntityInterface $entity, array $array): EntityInterface
    {
        /** @var Advertisement $entity */
        if (isset($array['id'])) {
            $entity->setId($array['id']);
        }
        if (isset($array['text'])) {
            $entity->setText($array['text']);
        }
        if (isset($array['price'])) {
            $entity->setPrice($array['price']);
        }
        if (isset($array['limit'])) {
            $entity->setLimit($array['limit']);
        }
        if (isset($array['banner'])) {
            $entity->setBanner($array['banner']);
        }
        if (isset($array['showing'])) {
            $entity->setShowing($array['showing']);
        }
        if (isset($array['updated_at'])) {
            $entity->setUpdatedAt($array['updated_at']);
        }
        if (isset($array['created_at'])) {
            $entity->setCreatedAt($array['created_at']);
        }
        return $entity;
    }

}

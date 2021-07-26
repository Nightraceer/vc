<?php


namespace TestWork\DataManager;


use Atk4\Dsql\Exception;
use Atk4\Dsql\Mysql\Query;
use PDO;
use TestWork\Connection\DB;
use TestWork\DataManager\Entity\EntityInterface;
use TestWork\DataManager\Entity\EntityProperty;
use TestWork\DataManager\EntityFactory\EntityFactoryInterface;
use TestWork\DataManager\Exception\NotFoundException;
use TestWork\Utils\DateTime;
use TestWork\Utils\Str;

/**
 * Class AbstractEntityManager
 * @package TestWork\DataManager
 */
abstract class AbstractEntityManager implements EntityManagerInterface
{
    protected DB $db;
    protected EntityFactoryInterface $entityFactory;

    /**
     * AbstractEntityManager constructor.
     * @param DB $db
     * @param EntityFactoryInterface $entityFactory
     */
    public function __construct(DB $db, EntityFactoryInterface $entityFactory)
    {
        $this->db = $db;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     *
     * @throws Exception
     */
    public function create(EntityInterface $entity): EntityInterface
    {
        $fields = $entity->toArray();
        $query = $this->getQuery()->table($entity->getProperty()->getTable());

        foreach ($fields as $name => $value) {
            if ($value instanceof DateTime) {
                $query->set($name, (string)$value);
            } else {
                $query->set($name, $value);
            }
        }
        $query->mode('insert');

        $stmt = $this->db->prepare($query->render());
        $stmt->execute($query->params);

        if ($lastInsertId = $this->db->lastInsertId()) {
            $entity->setId($lastInsertId);
        }

        return $entity;
    }

    /**
     * @param EntityInterface $entity
     *
     * @throws Exception
     */
    public function update(EntityInterface $entity): void
    {
        $fields = $entity->toArray();
        $query = $this->getQuery()->table($entity->getProperty()->getTable());

        foreach ($fields as $name => $value) {
            if ($value instanceof DateTime) {
                $query->set($name, (string)$value);
            } else {
                $query->set($name, $value);
            }
        }
        $query->where($entity->getProperty()->getId(), '=', $entity->getId());
        $query->mode('update');

        $stmt = $this->db->prepare($query->render());
        $stmt->execute($query->params);
    }

    /**
     * @param EntityInterface $entity
     *
     * @throws Exception
     */
    public function remove(EntityInterface $entity): void
    {
        $query = $this->getQuery()->table($entity->getProperty()->getTable());
        $query->set($entity->getProperty()->getId(), $entity->getId());
        $query->mode('delete');

        $stmt = $this->db->prepare($query->render());
        $stmt->execute($query->params);
    }

    /**
     * @param array $conditions
     * @param int|null $limit
     * @param int|null $offset
     * @param array|null $order
     * @return array
     *
     * @throws Exception
     */
    public function find(array $conditions = [], ?int $limit = null, ?int $offset = null, ?array $order = null): array
    {
        $whereArgs = $this->prepareWhereArgs($conditions);
        $query = $this->getQuery()->table($this->getEntityProperty()->getTable());
        foreach ($whereArgs as $whereArg) {
            $query->where($whereArg[0], $whereArg[1], $whereArg[2]);
        }
        if ($limit !== null) {
            $query->limit($limit, $offset);
        }
        $query->mode('select');
        $stmt = $this->db->prepare($query->render());
        $stmt->execute($query->params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->factoryEntities($result);
    }

    /**
     * @param array $conditions
     * @return mixed
     *
     * @throws Exception
     * @throws NotFoundException
     */
    public function findOne(array $conditions)
    {
        $entitiesArray = $this->find($conditions, 1, null, null);

        if (is_array($entitiesArray) && count($entitiesArray)) {
            return reset($entitiesArray);
        }

        throw new NotFoundException();
    }

    /**
     * @param int $id
     * @return mixed
     *
     * @throws Exception
     * @throws NotFoundException
     */
    public function findById(int $id)
    {
        return $this->findOne([$this->getEntityProperty()->getId() => $id]);
    }

    /**
     * @param array $resultSet
     * @return array
     */
    protected function factoryEntities(array $resultSet): array
    {
        $entitiesArray = [];
        foreach ($resultSet as $entityArray) {
            $entity = $this->factoryEntity($entityArray);
            $entitiesArray[] = $entity;
        }
        return $entitiesArray;
    }

    /**
     * @param array $result
     * @return EntityInterface
     */
    protected function factoryEntity(array $result): EntityInterface
    {
        return $this->entityFactory->factory($result);
    }

    /**
     * @param array $array
     * @return array
     */
    protected function prepareWhereArgs(array $array): array
    {
        $argsArray = [];
        foreach ($array as $key => $value) {
            if (is_int($key)) {
                $argsArray[] = $value;
                continue;
            }

            $operator = null;

            if (is_array($value)) {
                $operator = strtoupper(array_shift($value));

                if (Str::startsWith($operator, 'IS')) {
                    $value = null;
                } elseif ($operator !== 'BETWEEN') {
                    $value = reset($value);
                }
            }

            if ($operator === null) {
                if ($value === null) {
                    $operator = 'IS';
                } else {
                    $operator = '=';
                }
            }

            $argsArray[] = [$key, $operator, $value];
        }

        return $argsArray;
    }

    /**
     * @return Query
     */
    protected function getQuery(): Query
    {
        return new Query();
    }

    /**
     * @return EntityProperty
     */
    abstract public function getEntityProperty(): EntityProperty;
}

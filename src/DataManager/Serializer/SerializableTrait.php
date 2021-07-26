<?php


namespace TestWork\DataManager\Serializer;


use ReflectionClass;
use ReflectionException;
use TestWork\Utils\Str;

/**
 * Trait SerializableTrait
 * @package TestWork\DataManager\Serializer
 */
trait SerializableTrait
{
    /**
     * @param $data
     *
     * @throws ReflectionException
     * @return array|string
     */
    private static function normalize($data)
    {
        if (is_array($data)) {
            return static::normalizeArray($data);
        }

        return static::normalizeValue($data);
    }

    /**
     * @param array $data
     *
     * @throws ReflectionException
     * @return array
     */
    private static function normalizeArray(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $result[$key] = static::normalizeArray($value);
            } else {
                $result[$key] = static::normalizeValue($value);
            }
        }

        return $result;
    }

    /**
     * @param $value
     *
     * @throws ReflectionException
     * @return array|string
     */
    private static function normalizeValue($value)
    {
        if (is_object($value)) {
            return static::getNormalizedObject($value);
        }
        return $value;
    }

    /**
     * @param $object
     * @return array
     *
     * @throws ReflectionException
     */
    protected static function getNormalizedObject($object): array
    {
        $result = [];
        $reflect = new ReflectionClass($object);
        $reflectionProperties = $reflect->getProperties();

        foreach ($reflectionProperties as $prop) {
            try {
                $method = $reflect->getMethod('get' . ucfirst($prop->getName()));
                $result[Str::snake($prop->getName())] = $object->{$method->getName()}();
            } catch (ReflectionException $e) {
                if ($prop->isPublic()) {
                    $result[Str::snake($prop->getName())] = static::normalize($prop->getValue($object));
                }
            }
        }

        return $result;
    }
}

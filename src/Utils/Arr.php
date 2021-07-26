<?php


namespace TestWork\Utils;

/**
 * Class Arr
 * @package TestWork\Utils
 */
class Arr
{
    /**
     * @param array $array
     * @param array $exclude
     * @return array
     */
    public static function exclude(array $array, array $exclude): array
    {
        foreach ($exclude as $key) {
            unset($array[$key]);
        }
        return $array;
    }
}

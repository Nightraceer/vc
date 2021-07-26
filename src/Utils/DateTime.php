<?php


namespace TestWork\Utils;

/**
 * Class DateTime
 * @package TestWork\Utils
 */
class DateTime extends \DateTime
{
    public const FORMAT = 'Y-m-d H:i:s';

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format(self::FORMAT);
    }
}

<?php


namespace TestWork\DataManager\Exception;


use Exception;
use Throwable;

/**
 * Class NotFoundException
 * @package TestWork\DataManager\Exception
 */
class NotFoundException extends Exception
{
    /**
     * NotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

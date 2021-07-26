<?php

namespace TestWork\Connection;

use PDO;

/**
 * Class DB
 * @package TestWork\Connection
 */
class DB extends PDO
{
    /**
     * DB constructor.
     * @param DBConfig $config
     */
    public function __construct(DBConfig $config)
    {
        parent::__construct(
            sprintf("mysql:dbname=%s;host=%s;port=%s",
                $config->getName(),
                $config->getHost(),
                $config->getPort()
            ),
            $config->getLogin(),
            $config->getPassword(),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
}

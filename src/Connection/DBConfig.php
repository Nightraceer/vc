<?php

namespace TestWork\Connection;

/**
 * Class DBConfig
 * @package TestWork\Connection
 */
class DBConfig
{
    private array $config;

    /**
     * DBConfig constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->config['port'] = $this->config['port'] ?? 3306;
        $this->config['host'] = $this->config['host'] ?? 'localhost';
        $this->config['charset'] = $this->config['charset'] ?? 'utf8mb4';
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->config['host'];
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->config['login'];
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->config['password'];
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->config['port'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->config['name'];
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->config['charset'];
    }
}

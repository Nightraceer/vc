<?php


namespace TestWork;


use InvalidArgumentException;
use TestWork\Connection\DBConfig;

/**
 * Class AppConfig
 * @package TestWork
 */
class AppConfig
{
    private array $config;
    private string $appRoot;
    private DBConfig $dbConfig;

    /**
     * AppConfig constructor.
     * @param array $config
     */
    public function __construct(array $config, string $appRoot)
    {
        $this->config = $config;
        $this->appRoot = $appRoot;
    }

    /**
     * @return DBConfig
     */
    public function getDBConfig(): DBConfig
    {
        if (!isset($this->dbConfig)) {
            $this->dbConfig = new DBConfig($this->config['db']);
        }
        return $this->dbConfig;
    }

    /**
     * @param string|null $item
     * @return array|mixed
     */
    public function getConfig(?string $item = null)
    {
        if ($item !== null) {
            if (!isset($this->config[$item])) {
                throw new InvalidArgumentException(sprintf('The configuration for `%s` isn\'t exists.', $item));
            }

            return $this->config[$item];
        }

        return $this->config;
    }

    /**
     * @return string
     */
    public function getConfigPath(): string
    {
        return "{$this->appRoot}/config";
    }

    /**
     * @return string
     */
    public function getCachePath(): string
    {
        return "{$this->appRoot}/var/cache";
    }
}

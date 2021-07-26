<?php


namespace TestWork\Test;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Parser;
use TestWork\AppConfig;
use TestWork\Connection\DB;

/**
 * Class BaseTestCase
 * @package TestWork\Test
 */
class BaseTestCase extends TestCase
{
    protected static $config;
    protected static $appRoot;

    public static function setUpBeforeClass(): void
    {
        self::$appRoot = dirname(__DIR__);;
        self::$config = (new Parser())->parseFile(__DIR__ . '/config.yml');
    }

    /**
     * @return DB
     */
    public static function getDB(): DB
    {
        return new DB(self::getAppConfig()->getDBConfig());
    }

    /**
     * @return AppConfig
     */
    public static function getAppConfig(): AppConfig
    {
        return new AppConfig(self::$config, self::$appRoot);
    }
}

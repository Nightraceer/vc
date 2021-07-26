<?php


namespace TestWork\Test;


use Symfony\Component\HttpFoundation\Request;
use TestWork\App;
use TestWork\Utils\Arr;
use TestWork\Validator\Constraint\RequiredConstraint;
use TestWork\Validator\Constraint\UrlConstraint;

/**
 * Class AdvertisementTest
 * @package TestWork\Test
 */
class AdvertisementTest extends BaseTestCase
{
    private static App $app;
    private static array $server;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$app = new App(self::$config, self::$appRoot);
        self::$server = [
            'REMOTE_ADDR' => '127.0.0.1',
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => '/ads',
            'HTTP_HOST' => 'localhost',
            'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
            'HTTP_CONTENT_TYPE' => 'application/x-www-form-urlencoded'
        ];
    }

    public function testCreateSuccess(): void
    {
        $request = new Request([], [
            'text' => 'test',
            'price' => 10,
            'limit' => 200,
            'banner' => 'http://test.com/test'
        ], [], [], [], self::$server);
        $response = self::$app->handle($request);
        $data = json_decode($response->getContent(), true);

        self::assertSame('OK', $data['message']);
        self::assertSame(200, $data['code']);
        self::assertSame(['text' => 'test', 'banner' => 'http://test.com/test'], Arr::exclude($data['data'], ['id']));
    }

    public function testCreateFail(): void
    {
        $request = new Request([], [
            'text' => 'test',
        ], [], [], [], self::$server);
        $response = self::$app->handle($request);
        $data = json_decode($response->getContent(), true);

        self::assertSame([
            'message' => 'Validation errors',
            'code' => 400,
            'data' => [
                'errors' => [
                    'price' => [
                        RequiredConstraint::ERROR
                    ],
                    'limit' => [
                        RequiredConstraint::ERROR
                    ],
                    'banner' => [
                        UrlConstraint::ERROR
                    ]
                ]
            ]
        ], $data);
    }

    public static function tearDownAfterClass(): void
    {
        $stmt = self::getDB()->query('DELETE FROM `advertisements`');
        $stmt->execute();
    }
}

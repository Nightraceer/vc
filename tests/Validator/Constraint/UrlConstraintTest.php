<?php


namespace TestWork\Test\Validator\Constraint;


use TestWork\Test\BaseTestCase;
use TestWork\Validator\Constraint\RequiredConstraint;
use TestWork\Validator\Constraint\UrlConstraint;

/**
 * Class UrlConstraintTest
 * @package TestWork\Test\Validator\Constraint
 */
class UrlConstraintTest extends BaseTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testHandle($value, $errors): void
    {
        $constraint = new UrlConstraint(self::getDB());
        $resultErrors = $constraint->handle($value);

        self::assertSame($errors, $resultErrors);
    }

    public function dataProvider(): array
    {
        return [
            [
                '',
                [UrlConstraint::ERROR]
            ],
            [
                null,
                [UrlConstraint::ERROR]
            ],
            [
                '/testing',
                [UrlConstraint::ERROR]
            ],
            [
                'http://test.com',
                []
            ],
            [
                'https://test.com/test',
                []
            ],
        ];
    }
}

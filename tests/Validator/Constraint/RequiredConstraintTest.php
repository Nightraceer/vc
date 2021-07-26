<?php


namespace TestWork\Test\Validator\Constraint;


use PHPUnit\Framework\TestCase;
use TestWork\Test\BaseTestCase;
use TestWork\Validator\Constraint\RequiredConstraint;

/**
 * Class RequiredConstraintTest
 * @package TestWork\Test\Validator\Constraint
 */
class RequiredConstraintTest extends BaseTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testHandle($value, $errors): void
    {
        $constraint = new RequiredConstraint(self::getDB());
        $resultErrors = $constraint->handle($value);

        self::assertSame($errors, $resultErrors);
    }

    public function dataProvider(): array
    {
        return [
            [
                '',
                [RequiredConstraint::ERROR]
            ],
            [
                null,
                [RequiredConstraint::ERROR]
            ],
            [
                '  ',
                [RequiredConstraint::ERROR]
            ],
            [
                'test',
                []
            ],
            [
                '0',
                []
            ],
        ];
    }
}

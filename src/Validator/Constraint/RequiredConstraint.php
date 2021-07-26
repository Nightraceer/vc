<?php


namespace TestWork\Validator\Constraint;

/**
 * Class RequiredConstraint
 * @package TestWork\Validator\Constraint
 */
class RequiredConstraint extends AbstractConstraint
{
    public const TYPE = 'REQUIRED';
    public const ERROR = 'Field is required';

    /**
     * @param $value
     * @return array|string[]
     */
    public function handle($value): array
    {
        if ($value === false || (empty($value) && '0' != $value) || (is_string($value) && trim($value) === '')) {
            return [self::ERROR];
        }

        return [];
    }
}

<?php


namespace TestWork\Validator\Constraint;

/**
 * Interface ConstraintInterface
 * @package TestWork\Validator\Constraint
 */
interface ConstraintInterface
{
    /**
     * @param $value
     * @return array
     */
    public function handle($value): array;
}

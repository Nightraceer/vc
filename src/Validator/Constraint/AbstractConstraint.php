<?php


namespace TestWork\Validator\Constraint;


use TestWork\Connection\DB;

/**
 * Class AbstractConstraint
 * @package TestWork\Validator\Constraint
 */
abstract class AbstractConstraint implements ConstraintInterface
{
    protected DB $db;
    protected array $options;

    /**
     * AbstractConstraint constructor.
     * @param DB $db
     * @param array $options
     */
    public function __construct(DB $db, array $options = [])
    {
        $this->db = $db;
        $this->options = $options;
    }

    /**
     * @param $value
     * @return array
     */
    abstract public function handle($value): array;
}

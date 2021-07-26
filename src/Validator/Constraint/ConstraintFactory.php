<?php

namespace TestWork\Validator\Constraint;

use TestWork\Connection\DB;

/**
 * Class ConstraintFactory
 * @package TestWork\Validator\Constraint
 */
class ConstraintFactory
{
    private DB $db;
    private array $constraintClasses = [
        RequiredConstraint::TYPE => RequiredConstraint::class,
        UrlConstraint::TYPE => UrlConstraint::class
    ];

    /**
     * ConstraintFactory constructor.
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * @param array $constraintOptions
     * @return ConstraintInterface[]
     */
    public function factory(array $constraintOptions): array
    {
        $constraints = [];
        $constraintOptions = $constraintOptions ?? [];

        foreach ($constraintOptions as $type => $options) {
            $type = mb_strtoupper($type);
            if (isset($this->constraintClasses[$type])) {
                $constraints[] = new $this->constraintClasses[$type]($this->db, $options);
            }
        }

        return $constraints;
    }
}

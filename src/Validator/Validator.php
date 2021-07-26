<?php


namespace TestWork\Validator;


use TestWork\Connection\DB;
use TestWork\Validator\Constraint\ConstraintFactory;

/**
 * Class Validator
 * @package TestWork\Validator
 */
class Validator
{
    private ConstraintFactory $constraintFactory;

    /**
     * Validator constructor.
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        $this->constraintFactory = new ConstraintFactory($db);
    }

    /**
     * @param $value
     * @param $constraints
     * @return array
     */
    public function handle($value, $constraints): array
    {
        $constraints = $this->constraintFactory->factory($constraints);
        $resultErrors = [];

        foreach ($constraints as $constraint) {
            $errors = $constraint->handle($value);
            if (!empty($errors)) {
                $resultErrors = [...$errors];
            }
        }
        return $resultErrors;
    }
}

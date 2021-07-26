<?php


namespace TestWork\Validator\Constraint;

/**
 * Class UrlConstraint
 * @package TestWork\Validator\Constraint
 */
class UrlConstraint extends AbstractConstraint
{
    public const TYPE = 'URL';
    public const ERROR = 'Field value must be url';

    /**
     * @param $value
     * @return array|string[]
     */
    public function handle($value): array
    {
        if (empty($value) || !$this->isUrl($value)) {
            return [self::ERROR];
        }
        return [];
    }

    /**
     * @param string $value
     * @return int
     */
    private function isUrl(string $value): int
    {
        return preg_match('%^(?:https?://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:\S*)?$%iu', $value);
    }

}

<?php

namespace App\Core\FormValidator\Rules;

class RequiredRule extends AbstractRule
{
    private const ERROR_MESSAGE = 'This field is required';

    public function check(mixed $value): bool
    {
        return !empty($value);
    }

    public function getErrorMessage(): string
    {
        return self::ERROR_MESSAGE;
    }
}

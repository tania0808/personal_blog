<?php

namespace App\Core\FormValidator\Rules;

class EmailRule extends AbstractRule
{
    private const ERROR_MESSAGE = 'This field must be a valid email address';

    public function check(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function getErrorMessage(): string
    {
        return self::ERROR_MESSAGE;
    }
}

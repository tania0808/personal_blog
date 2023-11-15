<?php

namespace App\Core\FormValidator\Rules;

class MinRule extends AbstractRule
{
    private const ERROR_MESSAGE = 'Min length of this field must be {min} characters';

    public function check(mixed $value): bool
    {
        return strlen($value) >= $this->constraints['minLength'];
    }

    public function getErrorMessage(): string
    {
        return str_replace('{min}', $this->constraints['minLength'], self::ERROR_MESSAGE);
    }
}

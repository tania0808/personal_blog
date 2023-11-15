<?php

namespace App\Core\FormValidator\Rules;

class MaxRule extends AbstractRule
{
    private const ERROR_MESSAGE = 'Max length of this field must be {max} characters';

    public function check(mixed $value): bool
    {
        return strlen($value) <= $this->constraints['maxLength'];
    }

    public function getErrorMessage(): string
    {
        return str_replace('{max}', $this->constraints['maxLength'], self::ERROR_MESSAGE);
    }
}

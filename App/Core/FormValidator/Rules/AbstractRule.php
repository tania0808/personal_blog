<?php

namespace App\Core\FormValidator\Rules;

abstract class AbstractRule
{
    public function __construct(
        protected array $constraints = []
    ) {
    }

    abstract public function check(mixed $value): bool;
    abstract public function getErrorMessage(): string;
}

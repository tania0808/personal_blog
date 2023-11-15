<?php

namespace App\Core\FormValidator\Rules;

class MatchRule extends AbstractRule
{
    private const ERROR_MESSAGE = 'This field must be the same as {match}';

    public function check(mixed $value): bool
    {
        echo "<pre>";
        var_dump($this->{$this->constraints['match']});
        echo "</pre>";die();
        return $value !== $this->{$this->constraints['match']};
    }

    public function getErrorMessage(): string
    {
        return str_replace('{match}', $this->constraints['match'], self::ERROR_MESSAGE);
    }
}

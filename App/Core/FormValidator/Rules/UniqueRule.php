<?php

namespace App\Core\FormValidator\Rules;

use App\Core\Application;

class UniqueRule extends AbstractRule
{
    private const ERROR_MESSAGE = 'Record with this {field} already exists';

    public function check(mixed $value): bool
    {
        $className = $this->constraints['class'];
        $uniqueAttribute = $this->constraints['fieldName'];
        $tableName = $className::tableName();
        $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribute = :attr");
        $statement->bindValue(":attr", $value);
        $statement->execute();
        $record = $statement->fetchObject();
        if ($record) {
            return false;
        }
        return true;
    }

    public function getErrorMessage(): string
    {
        return str_replace('{field}', $this->constraints['fieldName'], self::ERROR_MESSAGE);
    }
}

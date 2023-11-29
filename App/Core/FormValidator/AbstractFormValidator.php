<?php

namespace App\Core\FormValidator;

use App\Core\FormValidator\Rules\AbstractRule;
use App\Core\Request;

abstract class AbstractFormValidator
{
    private array $errors = [];

    abstract public function rules(): array;

    public function validate(Request $request): bool
    {
        $formData = $request->getBody();
        $rules = $this->rules();

        foreach ($rules as $fieldName => $fieldRules) {
            $fieldValue = $formData[$fieldName] ?? null;

            /** @var AbstractRule $rule */
            foreach ($fieldRules as $rule) {
                if (!$rule->check($fieldValue)) {
                    $this->addError($fieldName, $rule->getErrorMessage());
                }
            }
        }

        return empty($this->errors);
    }


    public function addError(string $fieldName, string $message): void
    {
        $this->errors[$fieldName][] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

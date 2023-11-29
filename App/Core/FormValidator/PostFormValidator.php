<?php

namespace App\Core\FormValidator;

use App\Core\FormValidator\Rules\MinRule;
use App\Core\FormValidator\Rules\RequiredRule;

final class PostFormValidator extends AbstractFormValidator
{
    public function rules(): array
    {
        return [
            'title' => [new RequiredRule(), new MinRule(['minLength' => 3])],
            'description' => [new RequiredRule()],
            'body' => [new RequiredRule()],
        ];
    }
}
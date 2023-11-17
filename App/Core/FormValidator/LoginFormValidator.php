<?php

namespace App\Core\FormValidator;

use App\Core\FormValidator\Rules\EmailRule;
use App\Core\FormValidator\Rules\RequiredRule;

final class LoginFormValidator extends AbstractFormValidator
{
    public function rules(): array
    {
        return [
            'email' => [new RequiredRule(), new EmailRule()],
            'password' => [new RequiredRule()],
        ];
    }
}
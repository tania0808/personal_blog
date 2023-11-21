<?php

namespace App\Core\FormValidator;

use App\Core\FormValidator\Rules\EmailRule;
use App\Core\FormValidator\Rules\MinRule;
use App\Core\FormValidator\Rules\RequiredRule;
use App\Core\FormValidator\Rules\UniqueRule;
use App\Models\User;

final class RegisterFormValidator extends AbstractFormValidator
{
    public function rules(): array
    {
        return [
            'firstName' => [new RequiredRule()],
            'lastName' => [new RequiredRule()],
            'email' => [new RequiredRule(), new EmailRule(), new UniqueRule(['class' => User::class, 'fieldName' => 'email'])],
            'password' => [new RequiredRule(), new MinRule(['minLength' => 8])],
        ];
    }
}
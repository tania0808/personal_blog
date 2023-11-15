<?php

namespace App\Core\FormValidator;

use App\Core\FormValidator\Rules\EmailRule;
use App\Core\FormValidator\Rules\MinRule;
use App\Core\FormValidator\Rules\RequiredRule;

final class ContactFormValidator extends AbstractFormValidator
{
    public function rules(): array
    {
        return [
            'subject' => [new RequiredRule(), new MinRule(['minLength' => 3])],
            'name' => [new RequiredRule()],
            'email' => [new RequiredRule(), new EmailRule()],
            'body' => [new RequiredRule(), new MinRule(['minLength' => 25])],
        ];
    }
}
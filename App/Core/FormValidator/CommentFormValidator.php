<?php

namespace App\Core\FormValidator;

use App\Core\FormValidator\Rules\MinRule;
use App\Core\FormValidator\Rules\RequiredRule;

final class CommentFormValidator extends AbstractFormValidator
{
    public function rules(): array
    {
        return [
            'content' => [new RequiredRule(), new MinRule(['minLength' => 8])],
        ];
    }
}
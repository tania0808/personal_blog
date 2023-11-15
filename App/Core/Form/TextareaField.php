<?php

namespace App\Core\Form;

use App\Models\Model;

class TextareaField extends BaseField
{
    public function renderInput(): string
    {
        return sprintf('
            <textarea name="%s" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring %s">
            %s
            </textarea>
        ',
            $this->attribute,
            $this->model->hasError($this->attribute) ? 'border-red-500 focus:border-red-600 placeholder:text-red-500' : '',
            $this->model->{$this->attribute},
        );
    }
}
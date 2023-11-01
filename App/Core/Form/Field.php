<?php

namespace App\Core\Form;

use App\Models\Model;

class Field extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public string $type = 'text';

    /**
     * @param string $type
     */
    public function __construct(Model $model, $attribute, $label)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute, $label);
    }


    public function renderInput(): string
    {
        return sprintf('
            <input type="%s" name="%s" value="%s" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 %s">
       
        ',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'border-red-500 focus:border-red-600 placeholder:text-red-500' : '',
        );
    }
}
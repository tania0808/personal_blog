<?php

namespace App\Core\Form;

use App\Models\Model;

class Field
{
    public Model $model;
    public string $attribute;
    public string $type = 'text';
    public string $label;

    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute, $type, $label)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = $type;
        $this->label = $label;
    }

    public function __toString()
    {
        return sprintf('
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">%s</label>
            <input type="%s" name="%s" value="%s" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 %s">
             <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">%s</span></p>
        </div>
    ', $this->label,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'border-red-500 focus:border-red-600 text-red-500 placeholder:text-red-500' : '',
            $this->model->getFirstError($this->attribute)
        );
    }
}
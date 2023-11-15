<?php

namespace App\Core\Form;

use App\Models\Model;

abstract class BaseField
{
    public Model $model;
    public string $attribute;
    public string $label;

    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute, $label)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->label = $label;
    }

    abstract public function renderInput(): string;

    public function __toString()
    {
        return sprintf('
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">%s</label>
            %s
             <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">%s</span></p>
        </div>
    ',
            $this->label,
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}
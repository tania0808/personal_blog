<?php

namespace App\Core\Form;

use App\Models\Model;

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form class="space-y-4 md:space-y-6" action="%s" method="%s" enctype="multipart/form-data">', $action, $method );
        return new Form();
    }

    public static function end ()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute, $type, $label)
    {
        return new InputField($model, $attribute, $type, $label);
    }

}
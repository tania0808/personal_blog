<?php

namespace App\Core\Form;

use App\Models\Model;

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form class="space-y-4 md:space-y-6" action="%s" method="%s">', $action, $method );
        return new Form();
    }

    public static function end ()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute, $type, $label)
    {
        return new Field($model, $attribute, $type, $label);
    }

}
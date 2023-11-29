<?php

namespace App\Core;

abstract class Model
{
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            $setterMethod = 'set' . ucfirst($key);

            if (method_exists($this, $setterMethod)) {
                $this->{$setterMethod}($value);
            }
        }
    }
}

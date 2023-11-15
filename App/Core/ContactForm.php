<?php

namespace App\Core;

use App\Models\Model;

class ContactForm extends Model
{
    public string $subject = '';
    public string $name = '';
    public string $email = '';
    public string $body = '';
}
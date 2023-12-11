<?php

namespace App\Core\Exception;

use Exception;

class MailNotSentException extends Exception
{
    protected $message = 'An error occurred when sending your message';
}

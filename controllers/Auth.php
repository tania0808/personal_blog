<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class Auth extends Controller {

    public function login()
    {
        return $this->render('login');
    }
    public function register()
    {
        return $this->render('register');
    }
}
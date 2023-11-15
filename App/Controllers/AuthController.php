<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\FormValidator\PostFormValidator;
use App\Core\FormValidator\RegisterFormValidator;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\LoginForm;
use App\Models\User;

class AuthController extends Controller {


    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if($request->isPost()) {
            $loginForm->loadData($request->getBody());

            if($loginForm->validate() && $loginForm->login()) {
                $response->redirect('/');
                $loginForm->login();
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }
    public function register(Request $request)
    {
        $this->setLayout('auth');
        $user = new User();

        if($request->isPost()) {
            $registerFormValidator = new RegisterFormValidator();
            $user->loadData($request->getBody());

            if ($registerFormValidator->validate($request) && $user->save()) {
                Application::$app->session->setFlash('success', 'Your account was successfully created !');
                Application::$app->response->redirect('/');
                exit();
            }

            return $this->render('register', [
                'model' => $user,
                'errors' => $registerFormValidator->getErrors()
            ]);
        }

        return $this->render('register', [
            'model' => $user,
            'errors' => []
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
        return $this->render('profile');
    }
}
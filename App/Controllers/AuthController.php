<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;
use App\Core\FormValidator\LoginFormValidator;
use App\Core\FormValidator\RegisterFormValidator;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\User;
use App\Repositories\UserRepository;

class AuthController extends Controller {

    private readonly UserRepository $userRepository;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
        $this->userRepository = new UserRepository();
    }

    public function login(Request $request, Response $response)
    {
        $fieldsToExclude = ['password','is_admin', 'created_at'];
        $loginFormValidator = new LoginFormValidator();
        $user = new User();
        $authError = '';

        if($request->isPost() && $loginFormValidator->validate($request)) {
            $user->loadData($request->getBody());
            $foundUser = $this->userRepository->getByEmail($user->email);

            if (!$foundUser || !password_verify($user->password, $foundUser->password)) {
                $authError = 'This combination of e-mail and password is incorrect';
            } else {
                foreach ($fieldsToExclude as $field) {
                    unset($foundUser->$field);
                }

                $user->loadData($foundUser);
                Application::$app->session->setFlash('success', 'Your have successfully logged in !');
                $response->redirect('/');
                return Application::$app->login($user);
            }
        }

        $this->setLayout('auth');
        return $this->render('auth/login', [
            'model' => $user,
            'errors' => $loginFormValidator->getErrors(),
            'authError' => $authError
        ]);
    }
    public function register(Request $request, Response $response)
    {
        $this->setLayout('auth');
        $registerFormValidator = new RegisterFormValidator();
        $user = new User();

        if($request->isPost()) {
            $user->loadData($request->getBody());

            if ($registerFormValidator->validate($request) && $this->userRepository->create($user)) {
                Application::$app->session->setFlash('success', 'Your account was successfully created !');
                $response->redirect('/');
                exit();
            }

            return $this->render('auth/register', [
                'model' => $user,
                'errors' => $registerFormValidator->getErrors()
            ]);
        }

        return $this->render('auth/register', [
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
        return $this->render('admin/profile');
    }
}
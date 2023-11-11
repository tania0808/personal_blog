<?php

namespace App\Models;

use App\Core\Application;

class LoginForm extends Model
{
    private string $email = '';
    private string $password = '';

    public function rules() : array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function login()
    {
        $user = (new User())->findOne(['email' => $this->email]);
        if(!$user) {
            $this->addError('email', 'This combination of e-mail and password is incorrect');
            return false;
        }

        if(!password_verify($this->password, $user->password)) {
            $this->addError('password', 'This combination of e-mail and password is incorrect');
            return false;
        }

        return Application::$app->login($user);
    }
}
<?php

namespace App\Repositories;

use App\Core\Application;
use App\Models\User;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function getByEmail(string $email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create(User $user): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)");
        return $stmt->execute(['first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email, 'password' => password_hash($user->password, PASSWORD_DEFAULT)]);
    }

    public function update(int $id, array $data): void
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id):void
    {
        // TODO: Implement delete() method.
    }
}
<?php

namespace App\Repositories;

use App\Core\Application;
use App\Core\Database;
use App\Models\User;
use PDO;

class UserRepository extends Repository implements UserRepositoryInterface
{
    public function getByEmail(string $email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $stmt->fetch();
    }

    public function getById(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $stmt->fetch();
    }

    public function getByIds(array $ids)
    {
        if(count($ids) < 1) {
            return false;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id IN($placeholders)");

        foreach ($ids as $key => $id) {
            $stmt->bindValue($key + 1, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);

        $users = $stmt->fetchAll();

        $indexedResults = [];

        foreach ($users as $user) {
            $indexedResults[$user->getId()] = $user;
        }

        return $indexedResults;
    }

    public function create(User $user): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)");
        return $stmt->execute(['first_name' => $user->getFirstName(), 'last_name' => $user->getLastName(), 'email' => $user->getEmail(), 'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT)]);
    }
}
<?php

namespace App\Repositories;

use App\Core\Application;
use App\Core\Database;
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
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['first_name'], $data['last_name'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);
    }

    public function getAll(): false|array
    {

        $sql = <<<SQL
            SELECT posts.*, users.first_name, users.last_name
            FROM posts
            INNER JOIN users ON posts.author_id = users.id;
        SQL;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getById($id)
    {

        $sql = <<<SQL
            SELECT posts.*, users.first_name, users.last_name
            FROM posts
            INNER JOIN users ON posts.author_id = users.id
            WHERE posts.id = :postId;
        SQL;
        $statement = $this->db->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetch(\PDO::FETCH_OBJ);
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
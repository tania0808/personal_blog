<?php

namespace App\Repositories;

use App\Core\Application;
use App\Core\Database;

class PostRepository implements RepositoryInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function create($data): bool
    {
        if ($data['image_name']) {
            $stmt = $this->db->prepare("INSERT INTO posts (author_id, title, body, description, image_name) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$data['author_id'], $data['title'], $data['body'], $data['description'], $data['image_name']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO posts (author_id, title, body, description) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$data['author_id'], $data['title'], $data['body'], $data['description']]);
        }
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
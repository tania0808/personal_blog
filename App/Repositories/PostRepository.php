<?php

namespace App\Repositories;

use App\Core\Application;
use App\Core\Database;
use App\Models\Post;

class PostRepository implements RepositoryInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function create(Post $post): bool
    {
        $stmt = $this->db->prepare("INSERT INTO posts (author_id, title, body, description, image_name) VALUES (:author_id, :title, :body, :description, :image_name)");
        return $stmt->execute(['author_id' => $post->author_id, 'title' => $post->title, 'body' => $post->body, 'description' => $post->description, 'image_name' => $post->image_name]);
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
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $statement->fetch();
    }

    public function update($id, Post $post): bool
    {
        $attributes = ['title', 'description', 'body', 'image_name'];

        $setParams = array_map(fn($attr) => "$attr = :$attr", $attributes);
        $setClause = implode(', ', $setParams);

        $sql = "UPDATE posts SET $setClause WHERE id = :id";

        $data = [];
        foreach ($attributes as $attribute) {
            $data[":$attribute"] = $post->$attribute;
        }
        $data[':id'] = $id;

        $statement = $this->db->prepare($sql);

        return $statement->execute($data);
    }

    public function delete(int $id):void
    {
        // TODO: Implement delete() method.
    }
}
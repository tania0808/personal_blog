<?php

namespace App\Repositories;

use App\Core\Application;
use App\Core\Database;
use App\Models\Post;
use App\Models\User;

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
        return $stmt->execute(['author_id' => $post->getAuthorId(), 'title' => $post->getTitle(), 'body' => $post->getBody(), 'description' => $post->getDescription(), 'image_name' => $post->getImageName()]);
    }

    public function getAll(): false|array
    {
        // TODO add "WHERE approved_by IS NOT NULL" after implementing admin page
        $sql = <<<SQL
            SELECT * FROM posts
        SQL;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);

        return $statement->fetchAll();
    }

    public function getById($id)
    {

        $sql = <<<SQL
            SELECT * FROM posts
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

    public function delete(int $id): bool
    {
        $sql = <<<SQL
            DELETE FROM posts
            WHERE posts.id = :postId;
        SQL;

        $statement = $this->db->prepare($sql);
        return $statement->execute([$id]);
    }

}
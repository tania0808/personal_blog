<?php

namespace App\Repositories;

use App\Core\Application;
use App\Core\Database;
use App\Models\Post;
use App\Models\User;

class PostRepository extends Repository implements RepositoryInterface
{
    public function create(Post $post): bool
    {
        $stmt = $this->db->prepare("INSERT INTO posts (author_id, title, body, description, image_name) VALUES (:author_id, :title, :body, :description, :image_name)");
        return $stmt->execute(['author_id' => $post->getAuthorId(), 'title' => $post->getTitle(), 'body' => $post->getBody(), 'description' => $post->getDescription(), 'image_name' => $post->getImage_name()]);
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

        $setParams = array_map(
            function ($attr) use ($post) {
                $getterMethod = 'get' . ucfirst($attr);
                $value = $post->{$getterMethod}();

                // Conditionally include image_name in the SET clause
                if ($attr !== 'image_name' || $value !== null) {
                    return "$attr = :$attr";
                }

                return null;
            },
            $attributes
        );

        // Remove null values from the setParams array
        $setParams = array_filter($setParams);

        $setClause = implode(', ', $setParams);
        $sql = "UPDATE posts SET $setClause WHERE id = :id";

        $data = [];

        foreach ($attributes as $attribute) {
            $getterMethod = 'get' . ucfirst($attribute);
            $data[":$attribute"] = $post->{$getterMethod}();
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
<?php

namespace App\Repositories;

use App\Models\Post;
use PDO;

class PostRepository extends Repository
{
    public function create(Post $post): bool
    {
        $sql = <<<SQL
            INSERT INTO posts (author_id, title, body, description, image_name) 
            VALUES (:author_id, :title, :body, :description, :image_name);
        SQL;
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'author_id' => $post->getAuthorId(),
            'title' => $post->getTitle(),
            'body' => $post->getBody(),
            'description' => $post->getDescription(),
            'image_name' => $post->getImage_name()
        ]);
    }

    public function getAll(): false|array
    {
        $sql = <<<SQL
            SELECT * FROM posts
        SQL;

        $statement = $this->db->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Post::class);

        return $statement->fetchAll();
    }

    public function getAllApproved(): false|array
    {
        $sql = <<<SQL
            SELECT * FROM posts
            WHERE approved_at IS NOT NULL 
        SQL;

        $statement = $this->db->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, Post::class);

        return $statement->fetchAll();
    }

    public function getById(int $postId)
    {
        $sql = <<<SQL
            SELECT * FROM posts
            WHERE posts.id = :postId;
        SQL;

        $statement = $this->db->prepare($sql);
        $statement->execute([$postId]);
        $statement->setFetchMode(PDO::FETCH_CLASS, Post::class);

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

        $sql = <<<SQL
            UPDATE posts 
            SET $setClause 
            WHERE id = :id;
        SQL;

        $data = [];

        foreach ($attributes as $attribute) {
            $getterMethod = 'get' . ucfirst($attribute);
            $data[":$attribute"] = $post->{$getterMethod}();
        }

        $data[':id'] = $id;

        $statement = $this->db->prepare($sql);

        return $statement->execute($data);
    }
}

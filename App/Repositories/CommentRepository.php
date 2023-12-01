<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository extends Repository
{
    public function create(Comment $comment): bool
    {
        $sql = <<<SQL
            INSERT INTO comments (author_id, post_id, content) 
            VALUES (:author_id, :post_id, :content);
        SQL;
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'author_id' => $comment->getAuthorId(),
            'post_id' => $comment->getPostId(),
            'content' => $comment->getContent()
        ]);
    }

    public function getAll(): false|array
    {
        $sql = <<<SQL
            SELECT * FROM comments
            ORDER BY created_at DESC;
        SQL;

        $statement = $this->db->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS, Comment::class);

        return $statement->fetchAll();
    }

    public function getAllByPostId($postId): false|array
    {
        $sql = <<<SQL
            SELECT * FROM comments
            WHERE comments.post_id = :postId
                AND approved_at IS NOT NULL
            ORDER BY created_at DESC;
        SQL;

        $statement = $this->db->prepare($sql);
        $statement->execute([$postId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Comment::class);

        return $statement->fetchAll();
    }
}

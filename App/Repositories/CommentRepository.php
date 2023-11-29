<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository extends Repository
{
    public function create(Comment $comment): bool
    {
        $stmt = $this->db->prepare("INSERT INTO comments (author_id, post_id, content) VALUES (:author_id, :post_id, :content)");

        return $stmt->execute(['author_id' => $comment->getAuthorId(), 'post_id' => $comment->getPostId(), 'content' => $comment->getContent()]);
    }

    public function getAll(): false|array
    {
        $sql = <<<SQL
            SELECT * FROM comments
            WHERE approved_at IS NOT NULL
            ORDER BY created_at DESC;
        SQL;

        $statement = $this->db->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS, Comment::class);

        return $statement->fetchAll();
    }

    public function getAllByPostId($postId): false|array
    {
        // TODO add "WHERE approved_by IS NOT NULL" after implementing admin page
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

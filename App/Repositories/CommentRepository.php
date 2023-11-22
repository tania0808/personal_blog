<?php

namespace App\Repositories;

use App\Core\Application;
use App\Core\Database;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use PDO;

class CommentRepository implements CommentRepositoryInterface
{
    private Database $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function create(Comment $comment): bool
    {
        $stmt = $this->db->prepare("INSERT INTO comments (author_id, post_id, content) VALUES (:author_id, :post_id, :content)");
        return $stmt->execute(['author_id' => $comment->getAuthorId(), 'post_id' => $comment->getPostId(), 'content' => $comment->getContent()]);
    }

    public function getAllByPostId($postId): false|array
    {
        // TODO add "WHERE approved_by IS NOT NULL" after implementing admin page
        $sql = <<<SQL
            SELECT * FROM comments
            WHERE comments.post_id = :postId;
        SQL;
        $statement = $this->db->prepare($sql);
        $statement->execute([$postId]);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Comment::class);
        return $statement->fetchAll();
    }

    public function delete(int $id): bool
    {
        $sql = <<<SQL
            DELETE FROM comments
            WHERE id = :id;
        SQL;

        $statement = $this->db->prepare($sql);
        return $statement->execute([$id]);
    }
}
<?php

namespace App\Repositories;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function create(Comment $comment): bool;
    public function getAllByPostId(int $postId): bool | array;
    public function delete(int $id): bool;
}
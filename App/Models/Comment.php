<?php

namespace App\Models;

use App\Core\Model;

class Comment extends Model
{
    private int $id;
    private int $author_id;
    private string $post_id;
    private string $content = '';
    private int | null $approved_by;
    private string | null $approved_at;
    private string $created_at;
    private string $updated_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $author_id): void
    {
        $this->author_id = $author_id;
    }

    public function getPostId(): string
    {
        return $this->post_id;
    }

    public function setPostId(string $post_id): void
    {
        $this->post_id = $post_id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getApprovedBy(): ?int
    {
        return $this->approved_by;
    }

    public function setApprovedBy(?int $approved_by): void
    {
        $this->approved_by = $approved_by;
    }

    public function getApprovedAt(): ?string
    {
        return $this->approved_at;
    }

    public function setApprovedAt(?string $approved_at): void
    {
        $this->approved_at = $approved_at;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
<?php

namespace App\Models;

use App\Core\Model;

class Post extends Model
{
    private int $id;

    private int $author_id;

    private string $title = '';
    private string $description = '';
    private string $body = '';

    private string | null $image_name = null;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getImage_name(): string | null
    {
        return $this->image_name;
    }

    public function setImageName(string $image_name): void
    {
        $this->image_name = $image_name;
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

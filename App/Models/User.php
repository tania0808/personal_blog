<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    private int $id;
    private string $first_name = '';
    private string $last_name = '';
    private string $email = '';
    private string $password = '';
    private bool $is_admin;
    private string $created_at;

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getId(): int | null
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getIs_admin(): bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): void
    {
        $this->is_admin = $is_admin;
    }

    public function getCreated_at(): string
    {
        return $this->created_at;
    }

    public function setCreated_at(string $created_at): void
    {
        $this->created_at = $created_at;
    }
}

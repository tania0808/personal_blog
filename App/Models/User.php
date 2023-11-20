<?php

namespace App\Models;

use App\Core\DbModel;

class User extends DbModel
{
    public int $id;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    private bool $is_admin;
    private string $created_at;

    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function getDisplayName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
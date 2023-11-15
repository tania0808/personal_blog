<?php

namespace App\Models;

use App\Core\DbModel;
use App\Core\UserModel;

class User extends UserModel
{
    public int $id;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
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

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
        ];
    }

    public function attributes(): array
    {
        return ['first_name', 'last_name', 'email', 'password'];
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
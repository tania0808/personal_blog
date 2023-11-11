<?php

namespace App\Models;

use App\Core\DbModel;

class Post extends DbModel
{
    private int $id;

    private int $user_id;

    public string $title = '';
    public string $description = '';
    public string $body = '';

    public string $image_name = '';
    private string $created_at;
    private string $updated_at;

    public static function tableName(): string
    {
        return 'posts';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'description' => [self::RULE_REQUIRED],
            'body' => [self::RULE_REQUIRED],
        ];
    }

    public function attributes(): array
    {
        return ['user_id', 'title', 'description', 'body', 'image_name'];
    }

    public function setUser($userId)
    {
        $this->user_id = $userId;
    }

    public function setImage($imageName)
    {
        $this->image_name = $imageName;
    }
}
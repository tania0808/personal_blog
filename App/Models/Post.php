<?php

namespace App\Models;

use App\Core\DbModel;

class Post extends DbModel
{
    public int $id;

    public int $author_id;

    public string $title = '';
    public string $description = '';
    public string $body = '';

    public string $image_name = '';
    private int | null $approved_by;
    private string | null $approved_at;
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
        return ['author_id', 'title', 'description', 'body', 'image_name'];
    }

    public function setAuthor($author_id)
    {
        $this->author_id = $author_id;
    }

    public function setImage($imageName)
    {
        $this->image_name = $imageName;
    }
}
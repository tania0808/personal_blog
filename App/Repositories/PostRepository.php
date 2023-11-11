<?php

namespace App\Repositories;

use App\Core\Application;

class PostRepository extends Repository
{
    public function all()
    {

        $sql = <<<SQL
            SELECT posts.*, users.first_name, users.last_name
            FROM posts
            INNER JOIN users ON posts.user_id = users.id;
        SQL;

        return $this->executeQuery($sql);
    }

    public function getOne($id)
    {

        $sql = <<<SQL
            SELECT posts.*, users.first_name, users.last_name
            FROM posts
            INNER JOIN users ON posts.user_id = users.id
            WHERE posts.id = $id;
        SQL;

        return $this->executeQuery($sql);
    }
}
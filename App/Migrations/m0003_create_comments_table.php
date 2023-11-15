<?php

use \App\Core\Application;

class m0003_create_comments_table
{
    public function up()
    {
        $db = Application::$app->db;

        $SQL = <<<SQL
            CREATE TABLE IF NOT EXISTS comments  (
                id SERIAL PRIMARY KEY,
                user_id int references users(id),
                post_id int references posts(id),
                content text NOT NULL,
                is_approved bool default false,
                created_at timestamp default current_timestamp,
                updated_at timestamp default current_timestamp                        
            )
        SQL;

        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;

        $SQL = "DROP TABLE comments;";

        $db->pdo->exec($SQL);
    }
}
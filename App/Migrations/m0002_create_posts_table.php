<?php

use \App\Core\Application;

class m0002_create_posts_table
{
    public function up()
    {
        $db = Application::$app->db;

        $SQL = <<<SQL
            CREATE TABLE IF NOT EXISTS posts  (
                id SERIAL PRIMARY KEY,
                user_id int references users(id),
                title varchar (250) NOT NULL,
                body text NOT NULL,
                description varchar (250) NOT NULL,
                image_name text default NULL,
                created_at timestamp default current_timestamp,
                updated_at timestamp default current_timestamp                        
            )
        SQL;

        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;

        $SQL = "DROP TABLE posts;";

        $db->pdo->exec($SQL);
    }
}

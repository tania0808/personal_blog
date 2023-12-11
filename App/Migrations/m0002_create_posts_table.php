<?php
use App\Core\Application;

class m0002_create_posts_table
{
    public function up(): void
    {
        $db = Application::$app->db;

        $SQL = <<<SQL
            CREATE TABLE IF NOT EXISTS posts  (
                id SERIAL PRIMARY KEY,
                author_id int references users(id),
                title varchar (250) NOT NULL,
                body text NOT NULL,
                description varchar (250) NOT NULL,
                image_name varchar (250) default NULL,
                approved_by int references users(id),
                approved_at timestamp default null,
                created_at timestamp default current_timestamp,
                updated_at timestamp default current_timestamp                        
            )
        SQL;

        $db->pdo->exec($SQL);
    }

    public function down(): void
    {
        $db = Application::$app->db;

        $SQL = 'DROP TABLE posts;';

        $db->pdo->exec($SQL);
    }
}

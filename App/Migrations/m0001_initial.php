<?php

use App\Core\Application;

class m0001_initial
{
    public function up()
    {
        $db = Application::$app->db;

        $SQL = <<<SQL
            CREATE TABLE IF NOT EXISTS users  (
                id SERIAL PRIMARY KEY,
                first_name varchar (50) NOT NULL,
                last_name varchar (50) NOT NULL,
                email varchar (255) UNIQUE NOT NULL,
                password varchar (255) NOT NULL,
                is_admin boolean NOT NULL default false,
                created_at timestamp default current_timestamp
            )
        SQL;

        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;

        $SQL = "DROP TABLE users;";

        $db->pdo->exec($SQL);
    }
}

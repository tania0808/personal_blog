<?php

namespace App\Repositories;

use App\Core\Application;

class Repository
{
    public function prepare($sql): bool|\PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function execute($statement, $params = [])
    {
        $statement->execute($params);
        return $statement;
    }

    public function fetchAll($statement)
    {
        return $statement->fetchAll();
    }

    protected function executeQuery($sql, $params = [])
    {
        $statement = $this->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $statement->bindValue(":$key", $value);
            }
        }

        $this->execute($statement);
        return $this->fetchAll($statement);
    }
}
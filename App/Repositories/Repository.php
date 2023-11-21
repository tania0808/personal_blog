<?php

namespace App\Repositories;

use App\Core\Application;
class Repository
{
    protected function executeQuery($sql, $params = [])
    {
        $statement = Application::$app->db->pdo->prepare($sql);

        return $statement->execute($params);
    }
    public function fetchAll($statement)
    {
        $this->executeQuery($statement);

        $result = $this->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
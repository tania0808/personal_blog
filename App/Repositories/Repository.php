<?php

namespace App\Repositories;

use App\Core\Application;

// @TODO: devrait être abstract et avoir un constructeur pour stocker une instance de PDO plutôt que d'avoir un prepare qui te retourne une instance d'un PDOStatement
class Repository
{
    // @TODO: return type et il faut intégrer un appel à executeQuery dedans
    // TODO: fetchAll n'a rien à faire ici, tu peux garder tout le reste et retourner le statement en faisant un return sur execute + FETCH_OBJ

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
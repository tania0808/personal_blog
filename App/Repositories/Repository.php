<?php

namespace App\Repositories;

use App\Core\Application;
use App\Core\Database;

class Repository
{
    protected readonly Database $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }
}
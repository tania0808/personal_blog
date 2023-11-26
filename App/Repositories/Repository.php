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

    public function updateApprovalStatus(string $table, int $id, int $authorId, bool $approve): bool
    {
        $approvedAt = $approve ? 'now()' : 'null';

        $sql = <<<SQL
            UPDATE $table
            SET approved_at = $approvedAt, approved_by = :author_id
            WHERE $table.id = :id;
        SQL;

        $statement = $this->db->prepare($sql);
        return $statement->execute(['id' => $id, 'author_id' => $authorId]);
    }

    public function delete(string $table, int $id): bool
    {
        $sql = <<<SQL
            DELETE FROM $table
            WHERE $table.id = :id;
        SQL;

        $statement = $this->db->prepare($sql);
        return $statement->execute([$id]);
    }
}
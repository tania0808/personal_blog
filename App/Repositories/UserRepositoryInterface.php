<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function getByEmail(string $email);
    public function getByEmailAndPassword(string $email, string $password);
}
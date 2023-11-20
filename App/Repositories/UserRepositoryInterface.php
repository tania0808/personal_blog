<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(User $user);
    public function getByEmail(string $email);
}
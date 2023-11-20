<?php

namespace App\Repositories;

use App\Models\Post;

interface RepositoryInterface
{
    public function getAll();
    public function getById(int $id);
    public function create(Post $post);
    public function update($id, Post $post);
    public function delete(int $id);
}
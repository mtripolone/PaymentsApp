<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryContract
{
    public function create(array $payload): User;

    public function findOrFail(int $userId): User;

    public function login(array $payload): User;
}

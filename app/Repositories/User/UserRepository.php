<?php

namespace App\Repositories\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserRepository implements UserRepositoryContract
{
    public function __construct(
        protected User $model
    ) {
    }

    public function create(array $payload): User
    {
        $user = $this->model->create([
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'email' => $payload['email'],
            'profile' => $payload['profile'],
            'document' => $payload['document'],
            'password' => $payload['password'],
        ]);

        $user->wallet()->create([
            'balance' => 0,
        ]);

        return $user;
    }

    public function findOrFail(int $userId): User
    {
        return  $this->model->findOrFail($userId);
    }

    public function login(array $payload): User
    {
        $user = $this->model->whereEmail(
            $payload['email']
        )->first();

        if (! $user || ! Hash::check($payload['password'], $user->password)) {
            throw new Exception('Credenciais Invalidas', Response::HTTP_BAD_REQUEST);
        }

        return $user;
    }
}

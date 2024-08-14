<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginRequest;
use App\Repositories\User\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __construct(
        protected UserRepository $repository
    ) {
    }

    public function login(LoginRequest $request)
    {
        $payload = $request->validated();

        $user = $this->repository->login($payload);

        $token = $user->createToken('newToken')->plainTextToken;

        $response = [
            'user ' => $user,
            'token' => $token,
        ];

        return response($response, Response::HTTP_OK);
    }
}

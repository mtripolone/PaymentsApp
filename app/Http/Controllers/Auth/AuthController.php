<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AuthRequest;
use App\Repositories\User\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        protected UserRepository $repository
    ) {
    }

    public function register(AuthRequest $request)
    {
        $payload = $request->validated();

        $user = $this->repository->create($payload);

        $response = [
            'user ' => $user,
        ];

        return response($response, Response::HTTP_OK);
    }
}

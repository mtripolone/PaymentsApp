<?php

namespace App\Services\Transference\Authorization;

use Exception;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeService
{
    public function transferAuthorizator()
    {
        try {
            return Http::throw()->get(config('services.authorizer.address'));
        } catch (Exception $e) {
            throw new Exception('Transação não Autorizada', Response::HTTP_UNAUTHORIZED, $e);
        }
    }
}

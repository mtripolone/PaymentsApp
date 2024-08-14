<?php

namespace App\Services\Transference\Authorization;

use Exception;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeService
{
    public function transferAuthorizator()
    {
        try {
            $client = new Client();
            return $client->request('GET', config('services.authorizer.address'));
        } catch (Exception $e) {
            throw new Exception('Transação não Autorizada', Response::HTTP_UNAUTHORIZED, $e);
        }
    }
}

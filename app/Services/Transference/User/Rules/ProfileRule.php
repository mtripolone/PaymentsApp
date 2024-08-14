<?php

namespace App\Services\Transference\User\Rules;

use Exception;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ProfileRule
{
    public function validateProfileType($profile)
    {
        if ($profile != 'user') {
            throw new Exception('Não é possivel realizar transferências', Response::HTTP_UNAUTHORIZED);
        }
    }
}

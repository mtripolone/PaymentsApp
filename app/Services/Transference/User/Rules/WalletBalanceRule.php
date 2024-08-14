<?php

namespace App\Services\Transference\User\Rules;

use App\Repositories\Wallet\WalletRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class WalletBalanceRule
{
    public function __construct(
        private WalletRepository $walletRepository,
    ) {
    }

    public function checkWalletBalance($value, $userId)
    {
        $wallet = $this->walletRepository->findByUserId($userId);

        if ($value > $wallet->balance) {
            throw new Exception('Saldo da carteira insuficiente', Response::HTTP_UNAUTHORIZED);
        }
    }
}

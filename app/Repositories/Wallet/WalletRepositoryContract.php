<?php

namespace App\Repositories\Wallet;

use App\Models\Wallet;

interface WalletRepositoryContract
{
    public function findOrFail(int $walletId): Wallet;

    public function findByUserId(int $userId): Wallet;

    public function decreaseBalance(int $userId, float $value): void;

    public function increaseBalance(int $userId, float $value): void;
}

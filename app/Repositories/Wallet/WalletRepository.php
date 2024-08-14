<?php

namespace App\Repositories\Wallet;

use App\Models\Wallet;

class WalletRepository implements WalletRepositoryContract
{
    public function __construct(
        protected Wallet $model
    ) {
    }

    public function findOrFail(int $id): Wallet
    {
        return  $this->model->findOrFail($id);
    }

    public function findByUserId(int $userId): Wallet
    {
        return $this->model->where('user_id', $userId)->firstOrFail();
    }

    public function decreaseBalance(int $userId, float $value): void
    {
        $wallet = $this->findByUserId($userId);

        $wallet->decrement('balance', $value);
    }

    public function increaseBalance(int $userId, float $value): void
    {
        $wallet = $this->findByUserId($userId);

        $wallet->increment('balance', $value);
    }
}

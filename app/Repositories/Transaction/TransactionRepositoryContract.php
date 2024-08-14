<?php

namespace App\Repositories\Transaction;

interface TransactionRepositoryContract
{
    public function where(string $table, int $walletId);
}

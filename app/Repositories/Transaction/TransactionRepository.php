<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryContract
{
    public function __construct(
        protected Transaction $model
    ) {
    }

    public function where(string $table, int $walletId)
    {
        return  $this->model->where($table, $walletId);
    }
}

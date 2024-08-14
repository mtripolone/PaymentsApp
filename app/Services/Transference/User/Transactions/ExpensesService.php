<?php

namespace App\Services\Transference\User\Transactions;

class ExpensesService
{
    public function saveExpensesTransaction($value, $payer, $payee)
    {
        $payee->wallet->transactions()->create([
            'from_id' => $payee->id,
            'to_id' => $payer->id,
            'value' => $value,
            'payments' => 'invoice',
        ]);
    }
}

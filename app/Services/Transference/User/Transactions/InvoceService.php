<?php

namespace App\Services\Transference\User\Transactions;

class InvoceService
{
    public function saveInvoceTransaction($value, $payer, $payee)
    {
        $payer->wallet->transactions()->create([
            'from_id' => $payer->id,
            'to_id' => $payee->id,
            'value' => $value,
            'payments' => 'expenses',
        ]);
    }
}

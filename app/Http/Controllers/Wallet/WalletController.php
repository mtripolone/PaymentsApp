<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WalletController extends Controller
{
    public function __construct(
        protected TransactionRepository $repository
    ) {
    }

    public function userTransactions(Request $request)
    {
        $historic = [];

        if(Cache::has("transactions_{$request->wallet}")) {
            return response()->json(Cache::get("transactions_{$request->wallet}"));
        }

        $transactions = $this->repository->where('from_id', $request->wallet)->get();
        
        Cache::remember("transactions_{$request->wallet}", now()->addMinutes(10), function () use ($transactions) {
            foreach ($transactions as $transaction) {
                $valueFormated = number_format($transaction['value'], 2, ',', '.');
                $historic[] = "Transaction Type: {$transaction['payments']} of $ {$valueFormated}";
            } 
            return $historic;
        });

        return response()->json($historic);

    }
}

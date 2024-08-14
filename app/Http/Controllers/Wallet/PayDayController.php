<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Repositories\Wallet\WalletRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PayDayController extends Controller
{
    public function __construct(
        protected WalletRepository $repository
    ) {
    }

    public function payDay(Request $request)
    {
        $walletUser = $this->repository->findOrFail($request->wallet);
        $walletUser->balance += $request->payday;
        $walletUser->save();

        return response('Dinheiro Recebido', Response::HTTP_OK);
    }
}

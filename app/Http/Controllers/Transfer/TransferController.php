<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransferRequest;
use App\Services\Transference\Wallet\WalletService;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class TransferController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
    ) {
    }

    public function transference(TransferRequest $request)
    {
        $transfer = $request->validated();

        try {
            $this->walletService->walletTransfer($transfer);
        } catch (Exception $e) {
            return response($e->getMessage(),
                $e->getCode() == 0
                ? Response::HTTP_NOT_FOUND
                : Response::HTTP_UNAUTHORIZED);
        }

        return response('Transação realizada com sucesso!', Response::HTTP_OK);
    }
}

<?php

namespace App\Services\Transference\Wallet;

use App\Jobs\NotificationJob;
use App\Repositories\User\UserRepository;
use App\Repositories\Wallet\WalletRepository;
use App\Services\Transference\Authorization\AuthorizeService;
use App\Services\Transference\Notification\NotificationService;
use App\Services\Transference\User\Rules\ProfileRule;
use App\Services\Transference\User\Rules\WalletBalanceRule;
use App\Services\Transference\User\Transactions\ExpensesService;
use App\Services\Transference\User\Transactions\InvoceService;
use Exception;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function __construct(
        private ProfileRule $profileRule,
        private WalletBalanceRule $balanceRule,
        private UserRepository $userRepository,
        private AuthorizeService $authService,
        private InvoceService $invoceService,
        private ExpensesService $expensesService,
        private WalletRepository $walletRepository,
        private NotificationService $notification,
    ) {
    }

    public function walletTransfer(array $transfer)
    {
        try {
            DB::beginTransaction();

            $payer = $this->userRepository->findOrFail($transfer['payer']);
            $payee = $this->userRepository->findOrFail($transfer['payee']);

            $this->profileRule->validateProfileType($payer->profile);

            $this->balanceRule->checkWalletBalance($transfer['value'], $payer->id);

            $this->authService->transferAuthorizator();
            
            $this->walletRepository->decreaseBalance($payer->id, $transfer['value']);
            $this->invoceService->saveInvoceTransaction($transfer['value'], $payer, $payee);

            $this->walletRepository->increaseBalance($payee->id, $transfer['value']);
            $this->expensesService->saveExpensesTransaction($transfer['value'], $payer, $payee);
           
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }

        NotificationJob::dispatch(
            $payee, sprintf("Transferência de %s para %s realizada com sucesso no valor de %s",
                $payer->first_name,
                $payee->first_name,
                $transfer['value']
            )
        );
    }
}

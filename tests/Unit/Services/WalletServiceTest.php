<?php

namespace Tests\Unit\Services;

use App\Jobs\NotificationJob;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Services\Transference\Wallet\WalletService;
use App\Repositories\User\UserRepository;
use App\Repositories\Wallet\WalletRepository;
use App\Services\Transference\User\Rules\ProfileRule;
use App\Services\Transference\User\Rules\WalletBalanceRule;
use App\Services\Transference\Authorization\AuthorizeService;
use App\Services\Transference\User\Transactions\ExpensesService;
use App\Services\Transference\User\Transactions\InvoceService;
use Illuminate\Support\Facades\Queue;
use Mockery;

class WalletServiceTest extends TestCase
{
    public function test_wallet_transfer_successful()
    {
        Queue::fake([NotificationJob::class]);
        $userRepository = $this->mock(UserRepository::class);
        $authService = $this->mock(AuthorizeService::class);
        $invoceService = $this->mock(InvoceService::class);
        $expensesService = $this->mock(ExpensesService::class);
        $walletRepository = $this->mock(WalletRepository::class);

        $transfer = [
            'payer' => 1,
            'value' => 100,
            'payee' => 2
        ];
        
        $payer = User::factory()->makeOne(['id' => 1, 'profile' => 'user']);        
        $payee = User::factory()->makeOne(['id' => 2]);
        $payerWallet = Wallet::factory()->makeOne([
            'user_id' => $payer->id
        ]);

        $userRepository->shouldReceive('findOrFail')
            ->twice()
            ->andReturn($payer, $payee);

        DB::spy();
        DB::shouldReceive('beginTransaction')->once();

        DB::shouldReceive('commit')->once();

        $walletRepository->shouldReceive('decreaseBalance')
            ->with($transfer['payer'], $transfer['value'])
            ->once();

        $walletRepository
            ->shouldReceive('findByUserId')
            ->with($payer->id)
            ->andReturn($payerWallet);

        $walletRepository->shouldReceive('increaseBalance')
            ->with($transfer['payee'], $transfer['value'])
            ->once();

        $authService->shouldReceive('transferAuthorizator');
        $invoceService->shouldReceive('saveInvoceTransaction')
            ->once()
            ->with(100.0, $payer, $payee);
        
        $expensesService->shouldReceive('saveExpensesTransaction')
            ->once()
            ->with(100.0, $payer, $payee);



        /*$payer->shouldReceive('getAttribute')->with('profile')->andReturn('user');
        $payer->shouldReceive('setAttribute')->with('wallet.balance', Mockery::type('float'))->andReturnSelf();
        $payee->shouldReceive('setAttribute')->with('wallet.balance', Mockery::type('float'))->andReturnSelf();
        $payer->shouldReceive('save')->once();
        $payee->shouldReceive('save')->once(); */
                
                
        $walletService = app(WalletService::class);
        $walletService->walletTransfer($transfer);

        Queue::assertPushed(NotificationJob::class);

       /* // Configuração dos mocks

        $profileRule = Mockery::mock(ProfileRule::class);
        $balanceRule = Mockery::mock(WalletBalanceRule::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $authService = Mockery::mock(AuthorizeService::class);
        $invoceService = Mockery::mock(InvoceService::class);
        $expensesService = Mockery::mock(ExpensesService::class);

        // Configure o mock para retornar um objeto User
        $userRepository->shouldReceive('findOrFail')
            ->twice()
            ->andReturn($payer, $payee);

        $profileRule->shouldReceive('validateProfileType')->once()->with('common');
        $balanceRule->shouldReceive('checkWalletBalance')->once()->with(100.0, $payer);
        $authService->shouldReceive('transferAuthorizator')->once();
        $invoceService->shouldReceive('saveInvoceTransaction')->once()->with(100.0, $payer, $payee);
        $expensesService->shouldReceive('saveExpensesTransaction')->once()->with(100.0, $payer, $payee);

        // Instância o serviço com os mocks
        $walletService = new WalletService(
            $profileRule,
            $balanceRule,
            $userRepository,
            $authService,
            $invoceService,
            $expensesService
        );

        // Chama o método e verifica o resultado
        $result = $walletService->walletTransfer(['value' => 100.0, 'payer' => 1, 'payee' => 2]);
        $this->assertTrue($result);*/
    }
}
<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Transfer\TransferController;
use App\Http\Controllers\Wallet\PayDayController;
use App\Http\Controllers\Wallet\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Rotas Publicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Rotas Privadas
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/transaction', [TransferController::class, 'transference']);
    Route::post('/payday', [PayDayController::class, 'payDay']);
    Route::post('/statement', [WalletController::class, 'userTransactions']);
});

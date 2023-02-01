<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect('/accounts');
    })->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/reset-codes', [ProfileController::class, 'resetCodes'])->name('profile.resetCodes');

    Route::get('/dashboard',
        [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/accounts',
        [AccountController::class, 'index'])->name('accounts.index');
    Route::post('/accounts/create',
        [AccountController::class, 'create'])->name('account.create');

    Route::get('/accounts/{id}',
        [AccountController::class, 'showOne'])->name('account.show');
    Route::patch('/accounts/{id}',
        [AccountController::class, 'update'])->name('account.update');
    Route::delete('/accounts/{id}',
        [AccountController::class, 'destroy'])->name('account.destroy');

    Route::get('/cards',
        [CardController::class, 'show'])->name('cards.show');
    Route::get('/cards/{name}',
        [CardController::class, 'showOne'])->name('card.show');
    Route::post('/cards/create',
        [CardController::class, 'create'])->name('cards.create');

    Route::get('/transfer',
        [TransferController::class, 'show'])->name('transfer.show');
    Route::post('/transfer',
        [TransferController::class, 'create'])->name('transfer.create');

    Route::get('/crypto',
        [CryptoController::class, 'index'])->name('crypto.index');
    Route::get('/crypto/search/',
        [CryptoController::class, 'search'])->name('crypto.search');
    Route::get('/crypto/{symbol}',
        [CryptoController::class, 'show'])->name('crypto.show');
    Route::post('/crypto/{symbol}/buy',
        [CryptoController::class, 'buy'])->name('crypto.buy');
    Route::post('/crypto/{symbol}/sell',
        [CryptoController::class, 'sell'])->name('crypto.sell');

    Route::get('/portfolio',
        [PortfolioController::class, 'index'])->name('asset.index');
});

require __DIR__ . '/auth.php';

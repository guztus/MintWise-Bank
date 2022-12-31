<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CardController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/accounts',
        [AccountController::class, 'show'])->name('accounts.show');
    Route::get('/accounts/{name}',
        [AccountController::class, 'showOne'])->name('account.show');
    Route::post('/accounts/create',
        [AccountController::class, 'create'])->name('account.create');

    Route::get('/cards',
        [CardController::class, 'show'])->name('cards.show');
    Route::get('/cards/{name}',
        [CardController::class, 'showOne'])->name('card.show');
    Route::post('/cards/create',
        [CardController::class, 'create'])->name('cards.create');

    Route::get('/transfer',
        [TransferController::class, 'show'])->name('transfer.show');
    Route::post('/transfer/confirm',
        [TransferController::class, 'confirm'])->name('transfer.confirm');
});

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\TransactionsController;
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

Route::middleware('auth')->group(function () {

    Route::post('/2fa', function () {

        return redirect(\route('dashboard'));

    })->name('2fa')->middleware('2fa');

    Route::middleware('2fa')->group(function () {

        Route::get('/dashboard', [AccountsController::class, 'index'])->name('dashboard');
        Route::get('/', function () {
            return view('dashboard');
        });

        Route::resource('accounts', AccountsController::class)->only([
            'show', 'store'
        ]);

        Route::resource('accounts.transactions', TransactionsController::class)->only([
            'store'
        ]);

    });
});

Route::get('/', function () {
    return view('auth.login');
});

require __DIR__.'/auth.php';

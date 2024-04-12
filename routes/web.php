<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoresController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Dashboard');
});


Route::get('/help', function () {
    return Inertia::render('Welcome');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // ログイン者の編集
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ユーザー関連
    Route::resource('users', UsersController::class);
    Route::get('getUserList',[ UsersController::class, 'getUserList']);

    // 売上関連
    Route::get('/sale/{userId}', [SalesController::class, 'show'])->name('sale.show');
    Route::post('/sale', [SalesController::class, 'store'])->name('sale.store');
    Route::put('/sale/{saleId}', [SalesController::class, 'update']);
    Route::get('/sale/getSaleList/{userId}', [SalesController::class, 'getSales']);//売上取得


    // 前店舗取得API
    Route::get('/stores', [StoresController::class, 'getAllShopArrya']);

});

require __DIR__.'/auth.php';

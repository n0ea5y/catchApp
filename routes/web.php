<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\StoreController;
use App\Http\Controllers\Web\SaleController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return Inertia::render('Dashboard');
    });
        
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::resource('/user', UserController::class);
    Route::resource('/sale', SaleController::class);
    // Route::resource('/profile', ProfileController::class);
    
        
    // 前店舗取得API
    Route::get('/store/getStoreList', [StoreController::class, 'getAllShopArrya']);
    // ユーザー売上取得API
    Route::get('/sale/getSaleList/{userId}', [SaleController::class, 'getSales']);//売上取得
    // ユーザー一覧取得API
    Route::get('/getUserList',[ UserController::class, 'getUserList']);

    // // ログイン者の編集
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

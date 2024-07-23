<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\StoreController;
use App\Http\Controllers\Web\SaleController;

use App\Http\Controllers\Sp\SpUserController;
use App\Http\Controllers\Sp\SpStoreController;
use App\Http\Controllers\Sp\SpSaleController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Jenssegers\Agent\Agent;


Route::middleware('auth')->group(function () {
    $agent = new Agent();
    $isMobile = $agent->isMobile();
    
    if($isMobile){
        Route::get('/', function () {
            return Inertia::render('Sp/Dashboard');
        });
    }else{
        Route::get('/', function () {
            return Inertia::render('Pc/Dashboard');
        });
    }
        
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Pc/Dashboard');
    // })->middleware(['auth', 'verified'])->name('dashboard');

    // Route::resource('/user', UserController::class);
    // Route::resource('/sale', SaleController::class);
    // Route::resource('/profile', ProfileController::class);
    
    /**
     * 下記スマホのルート設定
     */
    Route::get('/sp/dashboard', function () {
        return Inertia::render('Sp/Dashboard');
    })->middleware(['auth', 'verified'])->name('sp.dashboard');

    Route::resource('/sp/user', SpUserController::class)->names([
        'index' => 'sp.user.index',
        'create' => 'sp.user.create',
        'store' => 'sp.user.store',
        'show' => 'sp.user.show',
        'edit' => 'sp.user.edit',
        'update' => 'sp.user.update',
        'destroy' => 'sp.user.destroy',
    ]);
    
    Route::resource('/user', SpSaleController::class);

    Route::resource('/sp/sale', SpSaleController::class)->names([
        'index' => 'sp.sale.index',
        'create' => 'sp.sale.create',
        'store' => 'sp.sale.store',
        'show' => 'sp.sale.show',
        'edit' => 'sp.sale.edit',
        'update' => 'sp.sale.update',
        'destroy' => 'sp.sale.destroy',
    ]);

    // 日別売上取得
    Route::get('salesData', [SpSaleController::class, 'getSales'])->name('sp.sale.get-sales');

    // 売上の店舗合計取得
    Route::get('/user-total-sale', [SpSaleController::class, 'getSaleTotalList']);

    // 前店舗取得API
    Route::get('/store/getStoreList', [StoreController::class, 'getAllShopArrya']);
    // ユーザー一覧取得API
    Route::get('/getUserList',[ UserController::class, 'getUserList']);
    Route::get('/api-users',[ UserController::class, 'getUsers']);
    Route::get('/user-sale/{userId}',[ SpSaleController::class, 'getSaleData']);

    // // ログイン者の編集
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

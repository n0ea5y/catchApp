<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\SaleController;

// ユーザー認証が必要な場合のルート
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Illuminate\Http\Request $request) {
        return $request->user();
    });

    // Route::resource('/user', UserController::class)->names([
    //     'index' => 'api.user.index',
    //     'store' => 'api.user.store',
    //     'show' => 'api.user.show',
    //     'update' => 'api.user.update',
    //     'destroy' => 'api.user.destroy',
    // ]);
    
    // // 前店舗取得API
    // Route::get('/getStoreList', [StoreController::class, 'getAllShopObj']);
    // // ユーザー売上取得API
    // Route::get('/sale/getSaleList/{userId}', [SaleController::class, 'getSales']);//売上取得
    // // ユーザー一覧取得API
    // Route::get('getUserList',[ UserController::class, 'getUserList']);

});

<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('houses', \App\Http\Controllers\HouseController::class);
    Route::apiResource('services', ServiceController::class);
    Route::get('get-addresses', [\App\Http\Controllers\AddressController::class, 'index']);
    Route::post('create-address', [\App\Http\Controllers\AddressController::class, 'store']);
    Route::post('wallet-transaction', [\App\Http\Controllers\WalletController::class, 'createTransactionRequest']);
    Route::get('transactions', [\App\Http\Controllers\WalletController::class, 'index']);
    Route::get('get-balance', [\App\Http\Controllers\WalletController::class, 'getBalance']);
    Route::post('create-service-provider', [\App\Http\Controllers\ServiceController::class, 'storeServiceProvider']);
    Route::get('service-provider', [\App\Http\Controllers\ServiceController::class, 'serviceProviders']);
    Route::post('send-notification', [\App\Http\Controllers\NotificationController::class, 'sendNotificationApi']);
    Route::get('trending-houses', [\App\Http\Controllers\HouseController::class, 'trendingHouses']);
    Route::post('/orders/house/{houseId}', [\App\Http\Controllers\OrderController::class, 'requestHouse']);
    Route::get('user/orders', [\App\Http\Controllers\OrderController::class, 'showUserOrders']);
    Route::get('owner/orders', [\App\Http\Controllers\OrderController::class, 'showHouseOwnerOrders']);
    Route::post('orders/{orderId}/update-status/{action}', [\App\Http\Controllers\OrderController::class, 'updateOrderStatus']);
    Route::post('/orders/service-provider', [\App\Http\Controllers\OrderController::class, 'storeServiceOrder']);
    Route::get('service-provider/orders', [\App\Http\Controllers\OrderController::class, 'showServiceProviderOrders']);
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'sendNotification'])->name('notifications');
    Route::get('services-popular', [\App\Http\Controllers\ServiceController::class, 'popularServices']);
    Route::get('service-providers/popular', [\App\Http\Controllers\ServiceController::class, 'popularServiceProviders']);
    Route::post('/transactions/{id}/approve', [\App\Http\Controllers\WalletController::class, 'approveTransaction']);
    Route::post('/transactions/{id}/reject', [\App\Http\Controllers\WalletController::class, 'rejectTransaction']);
    Route::get('profile', [\App\Http\Controllers\CustomAuthController::class, 'validate']);
    Route::post('join-request/{id}/accept', [\App\Http\Controllers\JoinRequestController::class, 'accept']);
    Route::post('join-request/{id}/reject', [\App\Http\Controllers\JoinRequestController::class, 'reject']);
    Route::apiResource('join-request', \App\Http\Controllers\JoinRequestController::class);
    Route::delete('categories/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy']);
    Route::delete('services/{service}', [\App\Http\Controllers\ServiceController::class, 'destroy']);
    Route::delete('houses/{house}', [\App\Http\Controllers\HouseController::class, 'destroy']);
    Route::delete('orders/{order}', [\App\Http\Controllers\OrderController::class, 'destroy']);
    Route::delete('transactions/{transaction}', [\App\Http\Controllers\TransactionController::class, 'destroy']);
    Route::delete('wallets/{wallet}', [\App\Http\Controllers\WalletController::class, 'destroy']);
    Route::delete('addresses/{address}', [\App\Http\Controllers\AddressController::class, 'destroy']);
    Route::delete('join-request/{id}', [\App\Http\Controllers\JoinRequestController::class, 'destroy']);
});
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [\App\Http\Controllers\CustomAuthController::class, 'login']);
    Route::post('validate', [\App\Http\Controllers\CustomAuthController::class, 'validate']);
    Route::post('register', [\App\Http\Controllers\CustomAuthController::class, 'register']);
    Route::post('update-profile', [\App\Http\Controllers\CustomAuthController::class, 'updateProfile'])->name('customer-auth.update')->middleware('auth:api');
    Route::post('change-password', [\App\Http\Controllers\CustomAuthController::class, 'changePassword'])->middleware('auth:api');
    Route::post('logout', [\App\Http\Controllers\CustomAuthController::class, 'logout'])->middleware('auth:api');
});

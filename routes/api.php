<?php


// use App\Http\Controllers\AuthController;
// use Illuminate\Support\Facades\Route;

// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/refresh', [AuthController::class, 'refreshToken']);

// Route::group(['middleware' => ['auth:api']], function () {
//     Route::get('/me', [AuthController::class, 'me']);
//     Route::post('/logout', [AuthController::class, 'logout']);

// });
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ResiController;
use Illuminate\Http\Request;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:3,1');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/refresh-token', [AuthController::class, 'refreshToken']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/transaksi/completed/{customerId}', [TransaksiController::class, 'getCompletedTransactions']);
    Route::get('/vouchers', [VoucherController::class, 'getAll']);
    Route::get('/transaksi/ongoing/{customerId}', [TransaksiController::class, 'getOngoingTransactions']);
    Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'getTransaksiById']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/services', [ServiceController::class, 'getAllServices']);
    Route::get('/customer', [CustomerController::class, 'getCustomer']);
    Route::put('/customer', [CustomerController::class, 'update']);
    Route::get('/transaksi/{customerId}', [TransaksiController::class, 'getTransaksiByCustomerId']);
    Route::get('/resi/{transaksiId}', [ResiController::class, 'getResi']);
    Route::post('/claim-voucher/{voucher}', [VoucherController::class, 'claim']);
    Route::get('/claimed-vouchers', [VoucherController::class, 'getClaimedVouchers']);
});

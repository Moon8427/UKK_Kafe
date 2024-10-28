<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\kasirController;
use App\Http\Controllers\managerController;


    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');

//Route
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

//Protected Routes
Route::group([
    "middleware"=>["auth:api"]
], function(){

    Route::get("profile", [AuthController::class, 'profile']);
    Route::get("refresh", [AuthController::class, 'refresh']);
    Route::get("logout", [AuthController::class, 'logout']);

});

//order
Route::post('/order',[kasirController::class,'order']);

//menu
Route::get('/getMenu', [adminController::class, 'getMenu']);
Route::post('/addMenu', [adminController::class, 'addMenu']);
Route::put('/updateMenu/{id}', [adminController::class, 'updateMenu']);
Route::delete('/deleteMenu/{id}', [adminController::class, 'deleteMenu']);
Route::get('/getMenuid/{id}', [adminController::class, 'getMenuid']);

//meja
Route::get('/getMeja', [adminController::class, 'getMeja']);
Route::post('/addMeja', [adminController::class, 'addMeja']);
Route::put('/updateMeja/{id}', [adminController::class, 'updateMeja']);
Route::delete('/deleteMeja/{id}', [adminController::class, 'deleteMeja']);
Route::get('/getMejaid/{id}', [adminController::class, 'getMejaid']);

// //transaksi
// Route::middleware('auth')->group(function () {
//     Route::get('/kasir/create', [kasirController::class, 'create'])->name('kasir.create');
//     Route::post('/kasir', [kasirController::class, 'store'])->name('kasir.store');
//     Route::get('/kasir/{transaction}', [kasirController::class, 'show'])->name('kasir.show');
// });

Route::prefix('transaksi')->group(function () {
    Route::get('/create', [kasirController::class, 'create'])->name('transaksi.create');
    Route::post('/store', [kasirController::class, 'store'])->name('transaksi.store');
    Route::get('/{transaksi}', [kasirController::class, 'show'])->name('transaksi.show');
});

Route::get('/get_detail', [managerController::class, 'getDetailTransaksi'])->name('detail_transaki.show');

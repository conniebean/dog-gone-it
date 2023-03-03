<?php

use App\Http\Controllers\OwnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('owner')->group(function () {
    Route::get('index', OwnerController::class . '@index')->name('owner.index');
    Route::post('store', OwnerController::class . '@store')->name('owner.store');
    Route::delete('delete/{id}', OwnerController::class . '@delete')->name('owner.delete')->middleware('admin');
});

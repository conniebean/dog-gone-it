<?php

use App\Http\Controllers\DaycareController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserController;
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
    Route::delete('{id}/dogs/{dogId}', DogController::class . '@delete')->name('dog.delete');
});

Route::prefix('dog')->group(function (){
    Route::post('store/{ownerId}', DogController::class . '@store')->name('dog.store');
});

Route::prefix('employee')->group(function() {
    Route::post('create', UserController::class . '@store')->name('employee.create')->middleware('admin');
    Route::delete('delete/{userId}', UserController::class . '@delete')->name('employee.delete')->middleware('admin');
    Route::put('promote/{id}', UserController::class . '@promote')->name('employee.promote')->middleware('admin');
});

Route::prefix('daycare')->group(function(){
    Route::post('store', DaycareController::class . '@store')->name('daycare.store');
});


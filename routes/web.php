<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BoardingController;
use App\Http\Controllers\DaycareController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\GroomingController;
use App\Http\Controllers\OwnerController;
use App\Models\Dog;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//Route::inertia('/home', "Home")->middleware(['auth', 'verified']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dogs', [DogController::class, 'show']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('appointments')->group(function () {
        Route::get('/daycare/index', [DaycareController::class, 'index']);
        Route::get('/grooming/index', [GroomingController::class, 'index']);
        Route::get('/boarding/index', [BoardingController::class, 'index']);
    });
});

Route::get('/appointment/{appointment}/details', function () {
    dd('here');
})->name('appointment.details')->middleware(['signed']);

require __DIR__ . '/auth.php';

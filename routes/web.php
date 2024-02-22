<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TraficLightController;
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
Route::prefix('trafic-lights')->group(function () {
    Route::get('/', [TraficLightController::class, 'index'])->name('trafic-light.index');
    Route::get('/go', [TraficLightController::class, 'go'])->name('trafic-light.go');
});


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurvivorController;
use App\Models\Pool;
use App\Models\SurvivorRegistration;
use App\Livewire\Fun;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::get('/game/{pool:id}/{survivorregistration:id}', Fun::class)->name('fun.wire');

Route::view('/test', 'test');

Route::get('/fun', [SurvivorController::class, 'fun']);

Route::get('/survivor/pool/{pool:id}', [SurvivorController::class, 'showByPool'])->name('pool.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

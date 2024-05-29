<?php

use App\Http\Controllers\ForbiddenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PickemController;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\SurvivorController;
use App\Livewire\Pickem;
use App\Livewire\Fun;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


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

Volt::route('/loginv2', 'loginv2')->name('loginv2');

Route::view('/', 'welcome');

Route::get('/forbidden/game/{pool:id}', [ForbiddenController::class, 'show'])->name('forbidden.pool');

Route::get('/all-pools', [PoolController::class, 'index'])->name('pools.browse');

Route::get('/my-pools/create', [PoolController::class, 'create'])->name('pool.create')->middleware('auth');
Route::get('/my-pools/{pool:id}/delete', [PoolController::class, 'destroy'])->name('pool.destroy');
Route::post('/my-pools/create', [PoolController::class, 'store'])->middleware('auth')->name('pool.post');
Route::get('/my-pools/register/{pool:id}', [PoolController::class, 'register'])->name('pool.register')->middleware('auth');
Route::post('/my-pools/register/{pool:id}/checkout', [PoolController::class, 'checkout'])->name('pool.checkout')->middleware('auth');

Route::get('/my-pools/{pool:id}/setup', [PoolController::class, 'finishSetup'])->name('pool.setup');
Route::post('/my-pools/{pool:id}/setup/checkout', [PoolController::class, 'creatorCheckout'])->name('pool.creatorCheckout')->middleware('auth');


Route::get('/my-pools/leave/{survivorregistration:id}', [PoolController::class, 'leave'])->name('pool.leave')->middleware('auth');

Route::middleware(['auth', 'survivor'])->group(function () {


    Route::get('/game/by-pool/{pool:id}', [PoolController::class, 'show'])->name('pool.show')->middleware('can:view,pool');

    Route::get('/game/pickem/{pool:id}', [PickemController::class, 'show'])->name('pickem.show')->middleware('can:view,pool');

    Route::get('/game/survivor/{pool:id}', [SurvivorController::class, 'showByPool'])->name('survivor.show')->middleware('can:view,pool');

    Route::get('/game/wire/pickem/{pool:id}', Pickem::class)->name('pickem.wire')->middleware('can:view,pool');
    Route::get('/game/wire/survivor/{pool:id}', Fun::class)->name('fun.wire')->middleware('can:view,pool');

    Route::get('/my-pools', [HomeController::class, 'show'])->name('mypools.show');

    Route::view('/test', 'test');

    Route::get('/fun', [SurvivorController::class, 'fun']);

});


//Route::get('/pickem/pool/{pool:id}', [PickemController::class, 'showByPool'])->name('pickem.show');
//Route::get('/pickem/pool/{pool:id}', Pickem::class)->name('pickem.show');
//Route::get('/game/{pool:id}/{survivorregistration:id}', Fun::class)->name('fun.wire');
//Route::get('/survivor/{pool:id}/{survivorregistration:id}', SurvivorGame::class)->name('fun.wire');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

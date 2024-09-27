<?php

use App\Http\Controllers\ForbiddenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PickemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatroomController;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\SurvivorController;
use App\Livewire\Pickem;
use App\Livewire\Fun;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::get('/forbidden/geex7891', [ForbiddenController::class, 'index']);

Route::get('unsubscribe/{user:email}', [HomeController::class, 'unsubscribe'])->name('unsubscribe');

Route::get('/', [GuestController::class, 'index'])->name('home');

Route::middleware(['auth', 'survivor', 'verified'])->group(function () {

    Route::get('/my-pools/{pool:id}/edit', [PoolController::class, 'edit'])->name('pool.edit')->middleware('can:update,pool');

    Route::get('/chat/game/{pool:id}', [ChatroomController::class, 'show'])->name('chat.show')->middleware('can:view,pool');

    Route::get('/game/by-pool/{pool:id}', [PoolController::class, 'show'])->name('pool.show')->middleware('can:view,pool');

    Route::get('/game/pickem/{pool:id}', [PickemController::class, 'show'])->name('pickem.show')->middleware('can:view,pool');

    Route::get('/stats/pickem/{pool:id}', [PickemController::class, 'viewStats'])->name('pickem.stats')->middleware('can:view,pool');

    Route::get('/game/survivor/{pool:id}', [SurvivorController::class, 'showByPool'])->name('survivor.show')->middleware('can:view,pool');

    Route::get('/game/wire/pickem/{pool:id}', Pickem::class)->name('pickem.wire')->middleware('can:view,pool');

    Route::get('/game/wire/survivor/{pool:id}', Fun::class)->name('fun.wire')->middleware('can:view,pool');

    Route::get('/my-pools', [HomeController::class, 'show'])->name('mypools.show');

    Route::get('/fun', [SurvivorController::class, 'fun']);

    Route::get('/forbidden/game/{pool:id}', [ForbiddenController::class, 'show'])->name('forbidden.pool');


    Route::get('/all-pools', [PoolController::class, 'index'])->name('pools.browse');

    Route::get('/my-pools/create', [PoolController::class, 'create'])->name('pool.create')->middleware('season.started');

    Route::get('/my-pools/{pool:id}/delete', [PoolController::class, 'destroy'])->name('pool.destroy');
    Route::post('/my-pools/create', [PoolController::class, 'store'])->middleware('season.started')->name('pool.post');
    Route::get('/my-pools/register/{pool:id}', [PoolController::class, 'register'])->name('pool.register')->middleware('season.started');
    Route::post('/my-pools/register/{pool:id}/checkout', [PoolController::class, 'checkout'])->name('pool.checkout')->middleware('season.started');

    Route::get('/my-pools/{pool:id}/setup', [PoolController::class, 'finishSetup'])->name('pool.setup');

    Route::post('/my-pools/{pool:id}/setup/checkout', [PoolController::class, 'creatorCheckout'])->name('pool.creatorCheckout')->middleware('season.started');


    Route::get('/my-pools/leave/{survivorregistration:id}', [PoolController::class, 'leave'])->name('pool.leave')->middleware('season.started');

    Route::get('/my-payments', [PaymentController::class, 'index'])->name('my-payments.index')->middleware('auth');

    Route::get('/support', [ContactController::class, 'index'])->name('support.index')->middleware('auth');
    Route::get('/support/{ticket:id}', [ContactController::class, 'show'])->name('support.show')->middleware('auth');
    Route::post('/support/{ticket:id}/store', [ContactController::class, 'store'])->name('ticket.store')->middleware('auth');
    Route::get('/support/{ticket:id}/destroy', [ContactController::class, 'destroy'])->name('ticket.destroy')->middleware('auth');
    Route::post('/support/create', [ContactController::class, 'create'])->name('ticket.create')->middleware('auth');
    Route::view('/trophy-room', 'trophy')->name('trophies.index');
    Route::view('/faq', 'faq')->name('faq.index');


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

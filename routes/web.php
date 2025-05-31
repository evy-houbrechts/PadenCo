<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WaarnemingController;
use App\Http\Controllers\AgendaController;      
use App\Http\Controllers\AccountController;    
use App\Http\Controllers\UitslagenController;
use App\Http\Controllers\VrijwilligerController; 
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;

Route::get("/",function(){
    return view("home");
})->name( "home");

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register'])->name('register.store')->middleware('guest');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->name('login.store')->middleware('guest');

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::resource('waarneming', WaarnemingController::class)->middleware('auth');

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/agenda/{user}', [AgendaController::class, 'show'])->name('agenda.show');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::delete('/agenda', [AgendaController::class, 'destroy'])->name('agenda.destroy');
});

Route::get('account', [AccountController::class, 'index'])->name('account')->middleware('auth');
Route::put('/account/update', [AccountController::class, 'update'])->name('account.update')->middleware('auth');


Route::get('uitslagen', [UitslagenController::class, 'index'])->name('uitslagen');

Route::prefix('vrijwilliger')->group(function () {
    Route::get('', [VrijwilligerController::class, 'index'])->name('vrijwilliger.index');
    Route::get('form', [VrijwilligerController::class, 'form'])->name('vrijwilliger.form');
    Route::post('store', [VrijwilligerController::class, 'store'])->name('vrijwilliger.store');
    Route::get('soorten', [VrijwilligerController::class, 'soorten'])->name('vrijwilliger.soorten');
});

Route::get('/wachtwoord-vergeten', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/wachtwoord-vergeten', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/wachtwoord-reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/wachtwoord-reset', [ResetPasswordController::class, 'reset'])->name('password.update');

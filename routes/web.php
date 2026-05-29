<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Cesty pre každého používateľa s prihlásením
Route::middleware('guest')->group(function () {
    Route::get('login', fn() => to_route('auth.create'))->name('login');
    Route::resource('auth', AuthController::class)->only(['create', 'store']);
});

// Cesty pre prihlásených používateľov
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Cesty súvisiace s prihlasovaním a prihlasovacími údajmi
    Route::delete('auth', [AuthController::class, 'destroy'])->name('logout');
    Route::get('change-password', [AuthController::class, 'editPassword'])
        ->name('user.change-password.edit');
    Route::patch('change-password', [AuthController::class, 'updatePassword'])
        ->name('user.change-password.update');

    // zobrazenie profilu používateľa
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');

    // Cesty pre žiaka
    Route::resource('students', StudentController::class)->only('index')->middleware('admin-teacher'); // toto len admin a učiteľ
    Route::resource('students', StudentController::class)
        ->only(['store', 'create', 'destroy', 'update', 'edit'])->middleware('admin');
    Route::patch('students/{student}/restore', [StudentController::class, 'restore'])->name('students.restore')
        ->middleware('admin');
    Route::delete('students/{student}/forceDelete', [StudentController::class, 'forceDelete'])
        ->middleware('admin')->name('students.forceDelete');
    Route::resource('students', StudentController::class)->only('show')->withTrashed(['show']); // toto všetci prihlásený

    // Cesty pre zákonného zástupcu
    Route::resource('students.guardians', GuardianController::class)->only(['store', 'create', 'destroy', 'update', 'edit'])->middleware('admin');
    Route::resource('students.guardians', GuardianController::class)->only('show')->withTrashed(['show']);
});

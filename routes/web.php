<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', fn() => to_route('auth.create'))->name('login');
    Route::resource('auth', AuthController::class)->only(['create', 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::delete('auth', [AuthController::class, 'destroy'])->name('logout');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile');

    Route::resource('students', StudentController::class)->only('index'); // toto len admin a učiteľ
    Route::resource('students', StudentController::class)
        ->only(['store', 'create', 'destroy', 'update', 'edit'])->middleware('admin-student'); //na toto pôjde middleware, že to môže robiť len admin
    Route::resource('students', StudentController::class)->only('show'); // toto všetci});
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandController;
use App\Http\Controllers\BandStudentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\InstrumentReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomReservationController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
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
    Route::resource('students.guardians', GuardianController::class)->only(['store', 'create', 'destroy', 'update', 'edit'])
        ->middleware('admin');
    Route::resource('students.guardians', GuardianController::class)->only('show')->withTrashed(['show']);
    Route::patch('students/{student}/guardians/{guardian}/restore', [GuardianController::class, 'restore'])->name('students.guardians.restore')
        ->middleware('admin');

    // cesty pre učiteľov
    Route::resource('teachers', TeacherController::class)->only('index');
    Route::resource('teachers', TeacherController::class)->only(['store', 'create', 'destroy', 'update', 'edit'])
        ->middleware('admin');
    Route::patch('teachers/{teacher}/restore', [TeacherController::class, 'restore'])->name('teachers.restore')
        ->middleware('admin');
    Route::resource('teachers', TeacherController::class)->only('show')->withTrashed(['show']);

    // Cesty pre špecializácie
    Route::resource('specializations', SpecializationController::class)->only('index');
    Route::resource('specializations', SpecializationController::class)->only(['store', 'create', 'destroy', 'update', 'edit'])
        ->middleware('admin');
    Route::resource('specializations', SpecializationController::class)->only('show')->withTrashed(['show']);
    Route::patch('specializations/{specialization}/restore', [SpecializationController::class, 'restore'])->name('specializations.restore')
        ->middleware('admin');

    // Cesty pre Odbor
    Route::resource('departments', DepartmentController::class)->only('index');
    Route::resource('departments', DepartmentController::class)->only(['store', 'create', 'destroy', 'update', 'edit'])
        ->middleware('admin');
    Route::patch('departments/{department}/restore', [DepartmentController::class, 'restore'])->name('departments.restore');
    Route::resource('departments', DepartmentController::class)->only('show')->withTrashed(['show']);

    // Cesty pre predmety

    // Cesty pre miestnosti
    Route::resource('rooms', RoomController::class)->only('index')
        ->middleware('admin-teacher');
    Route::resource('rooms', RoomController::class)->only(['edit', 'update','create' , 'store', 'destroy'])->middleware('admin');
    Route::resource('rooms', RoomController::class)->only('show')->withTrashed(['show']);
    Route::resource('rooms.reservations', RoomReservationController::class)->only(['index', 'create', 'store','edit','update' ,'destroy'])
        ->middleware('admin-teacher');
    Route::resource('rooms.reservations', RoomReservationController::class)
        ->only('show')->middleware('admin-teacher');

    // Cesty pre nástroje
    Route::resource('instruments', InstrumentController::class)->only('index')
        ->middleware('admin-teacher');
    Route::resource('instruments', InstrumentController::class)->only(['store', 'create', 'edit', 'update', 'destroy'])
        ->middleware('admin');
    Route::resource('instruments', InstrumentController::class)->only('show');

    // Cesty pre rezervácie nástroja
    Route::resource('instruments-reservations', InstrumentReservationController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('admin-teacher');
    Route::resource('instruments-reservations', InstrumentReservationController::class)
        ->only('show');
    Route::get('my-reservations', [InstrumentReservationController::class, 'myReservations'])->name('instrument-reservations.my');


    // Cesty pre kapely
    Route::resource('bands', BandController::class)->only('index');
    Route::resource('bands', BandController::class)->only(['create', 'store', 'update', 'edit', 'destroy'])
        ->middleware('admin-teacher');
    Route::patch('bands/{band}/restore', [BandController::class, 'restore'])->name('bands.restore')->middleware('admin');
    Route::resource('bands', BandController::class)->only('show')->withTrashed(['show']);
    Route::resource('bands.students', BandStudentController::class)->only(['index', 'store', 'create', 'destroy']);

    // Cesty pre udalosti
    Route::resource('events', EventController::class)->only('index');
    Route::resource('events', EventController::class)->only(['store', 'create', 'destroy', 'update', 'edit'])
        ->middleware('admin-teacher');
    Route::patch('events/{event}/restore', [EventController::class, 'restore'])->name('events.restore')
        ->middleware('admin');
    Route::resource('events', EventController::class)->only('show')->withTrashed(['show']);
    Route::get('my-events', [EventParticipantController::class, 'index'])
        ->name('my-events');
    Route::post('events/{event}/participants', [EventParticipantController::class, 'store'])
        ->name('events.participants.store');
    Route::delete('events/{event}/participants', [EventParticipantController::class, 'destroy'])
        ->name('events.participants.destroy');
    Route::get('events/{event}/participants', [EventParticipantController::class, 'show'])->name('events.participants.show');
    Route::delete('events/{event}/participants/{participant}', [EventParticipantController::class, 'destroyParticipant'])->name('events.participants.destroy-participant');
});

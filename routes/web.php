<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth', 'permitted']);

Route::get('/logout', [UserController::class, 'logout'])->name('admin.logout');

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->middleware(['auth', 'permitted']);
    Route::post('/enroll', [UserController::class, 'enroll'])->name('admin.users.enroll')->middleware(['auth']);
    Route::get('/list', [UserController::class, 'list'])->name('admin.users.list')->middleware(['auth']);
    Route::get('/get', [UserController::class, 'getOne'])->name('admin.users.get.one')->middleware(['auth']);
    Route::get('/delete', [UserController::class, 'deleteOne'])->name('admin.users.delete.one')->middleware(['auth']);
    Route::get('/find', [UserController::class, 'find'])->name('admin.users.find.one')->middleware(['auth']);
});

Route::prefix('/usertypes')->group(function () {
    Route::get('/', [UserTypeController::class, 'index'])->middleware(['auth', 'permitted']);
    Route::post('/enroll', [UserTypeController::class, 'enroll'])->name('admin.usertypes.enroll')->middleware(['auth']);
    Route::get('/list', [UserTypeController::class, 'list'])->name('admin.usertypes.list')->middleware(['auth']);
    Route::get('/get', [UserTypeController::class, 'getOne'])->name('admin.usertypes.get.one')->middleware(['auth']);
    Route::get('/delete', [UserTypeController::class, 'deleteOne'])->name('admin.usertypes.delete.one')->middleware(['auth']);
});

Route::prefix('/subjects')->group(function () {
    Route::get('/', [SubjectController::class, 'index'])->middleware(['auth', 'permitted']);
    Route::post('/enroll', [SubjectController::class, 'enroll'])->name('admin.subject.enroll')->middleware(['auth']);
    Route::get('/list', [SubjectController::class, 'list'])->name('admin.subject.list')->middleware(['auth']);
    Route::get('/get', [SubjectController::class, 'getOne'])->name('admin.subject.get.one')->middleware(['auth']);
    Route::get('/delete', [SubjectController::class, 'deleteOne'])->name('admin.subject.delete.one')->middleware(['auth']);
});

Route::prefix('/events')->group(function () {
    Route::get('/', [EventController::class, 'index'])->middleware(['auth', 'permitted']);
    Route::post('/enroll', [EventController::class, 'enroll'])->name('admin.events.enroll')->middleware(['auth']);
    Route::get('/list', [EventController::class, 'list'])->name('admin.events.list')->middleware(['auth']);
    Route::get('/get', [EventController::class, 'getOne'])->name('admin.events.get.one')->middleware(['auth']);
    Route::get('/delete', [EventController::class, 'deleteOne'])->name('admin.events.delete.one')->middleware(['auth']);
});

Route::prefix('/timetable')->group(function () {
    Route::get('/', [TimetableController::class, 'index'])->middleware(['auth', 'permitted']);
    Route::post('/enroll', [TimetableController::class, 'enroll'])->name('admin.timetable.enroll')->middleware(['auth']);
    Route::get('/list', [TimetableController::class, 'list'])->name('admin.timetable.list')->middleware(['auth']);
    Route::get('/get', [TimetableController::class, 'getOne'])->name('admin.timetable.get.one')->middleware(['auth']);
    Route::get('/delete', [TimetableController::class, 'deleteOne'])->name('admin.timetable.delete.one')->middleware(['auth']);
});
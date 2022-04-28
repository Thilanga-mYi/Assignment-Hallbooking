<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReasonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[UserController::class,'loginAPI']);
Route::post('/ticket/submit',[TicketController::class,'submitAPI']);
Route::post('/ticket/history',[TicketController::class,'historyAPI']);
Route::get('/device/assigned',[UserController::class,'assigned']);
Route::post('/assigned/check',[UserController::class,'assignedCheck']);

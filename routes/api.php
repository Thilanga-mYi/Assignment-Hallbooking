<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\StudentBookLectureHallController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReasonController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use App\Models\StudentBookLectureHall;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'loginAPI']);
Route::post('/ticket/submit', [TicketController::class, 'submitAPI']);
Route::post('/ticket/history', [TicketController::class, 'historyAPI']);
Route::get('/device/assigned', [UserController::class, 'assigned']);
Route::post('/assigned/check', [UserController::class, 'assignedCheck']);

Route::get('/lectureHall/saveLectureHall', [ApiController::class, 'StudentBookLectureHall']);
Route::get('/appointment/submit', [ApiController::class, 'StudentAppointLecture_Submit']);
Route::get('appointment/lectureSide_list', [ApiController::class, 'StudentAppointLecture_LectureSide_List']);
Route::get('appointment/StudentSide_list', [ApiController::class, 'StudentAppointLecture_StudentSide_List']);
Route::get('appointment/approve', [ApiController::class, 'StudentAppointLecture_Approve']);
Route::get('appointment/reject', [ApiController::class, 'StudentAppointLecture_Reject']);

<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\LectureHall;
use App\Models\Payment;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\Transport;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    // GET ACTIVE LECTURE LIST
    public function GetActiveLectures()
    {
        return [
            'code' => 200,
            'status' => 'success',
            'data' => Lecture::where('status', 1),
        ];
    }

    // GET ACTIVE TRANSPORT LIST
    public function GetActiveTransports()
    {
        return [
            'code' => 200,
            'status' => 'success',
            'data' => Transport::where('status', 1),
        ];
    }

    // GET TIMETABLE SLOTS
    public function GetActiveTimetableSlots()
    {

        $records = [];

        foreach (Timetable::orderBy('date', 'DESC')->get() as $key => $slot) {
            $records[] = [
                'slot_name' => $slot->name,
                'subject' => Subject::find($slot->subject_id)->name,
                'lecture_hall' => LectureHall::find($slot->lecture_hall_id)->lecture_hall_name,
                'date' => $slot->date,
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'status' => $slot->status,
                'editable' => 1,
            ];
        }

        return [
            'code' => 200,
            'status' => 'success',
            'date' => $records,
        ];
    }

    // LECTURE ENROLLMENT AND PAYMENT REQUEST
    public function PaymentRegister(Request $request)
    {
        $request->validate([
            'payment_name' => 'required|string',
            'payment_student_id' => 'required|numeric|exists:users,id',
            'payment_lecture_id' => 'required|numeric|exists:lectures,id',
            'payment_paid_amount' => 'required|numeric|min:1',
            'payment_status' => 'required|numeric|in:1,2',
        ]);

        if (
            count(
                Payment::where('student_id', $request->payment_student_id)
                    ->where('lecture_id', $request->payment_lecture_id)
                    ->get()
            ) != 0
        ) {

            $data = [
                'name' => $request->payment_name,
                'student_id' => $request->payment_student_id,
                'lecture_id' => $request->payment_lecture_id,
                'paid_amount' => $request->payment_paid_amount,
                'status' => 3,
            ];

            Payment::create();
        } else {
            return [
                'code' => 2,
                'msg' => '2',
            ];
        }
    }
}

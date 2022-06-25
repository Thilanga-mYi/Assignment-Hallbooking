<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\LectureHall;
use App\Models\Payment;
use App\Models\StudentAppointLecture;
use App\Models\StudentBookLectureHall;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\Transport;
use App\Models\User;
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

    // STUDENT BOOK LECTURE HALL
    public function StudentBookLectureHall(Request $request)
    {

        $request->validate([
            'reason' => 'required|string',
            'student_id' => 'required|numeric|min:1|exists:users,id',
            'lecture_hall_id' => 'required|numeric|min:1|exists:lecture_halls,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|numeric|in:1,2',
        ]);

        foreach (Lecture::where('status', 1)
            ->where('conduct_date', $request->date)
            ->where('lecture_hall_id', $request->lecture_hall_id)
            ->get() as $key => $lecture) {

            if (
                $request->start_time >= $lecture->start_time && $request->end_time <= $lecture->end_time ||
                $lecture->start_time >= $request->start_time && $lecture->end_time <= $request->end_time
            ) {
                return [
                    'code' => 1,
                    'msg' => 'Time slot unavialble',
                ];
            }
        }

        foreach (StudentBookLectureHall::where('status', 1)
            ->where('date', $request->date)
            ->where('lecture_hall_id', $request->lecture_hall_id)
            ->get() as $key => $lecture) {

            if (
                $request->start_time >= $lecture->start_time && $request->end_time <= $lecture->end_time ||
                $lecture->start_time >= $request->start_time && $lecture->end_time <= $request->end_time
            ) {
                return [
                    'code' => 1,
                    'msg' => 'Time slot unavialble',
                ];
            }
        }

        $booking_data = [
            'reason' => $request->reason,
            'student_id' => $request->student_id,
            'lecture_hall_id' => $request->lecture_hall_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 2,
        ];

        StudentBookLectureHall::create($booking_data);

        return [
            'code' => 2,
            'msg' => 'Request Successfull',
        ];
    }

    // STUDENT APPOINT LECTURE
    public function StudentAppointLecture_Submit(Request $request)
    {
        $request->validate([
            'reason' => 'required|string',
            'student_id' => 'required|numeric|min:1|exists:users,id',
            'lecture_id' => 'required|numeric|min:1|exists:users,id',
            'date_time' => 'required|date',
        ]);

        $studentAppointedLecture_data = [
            'reason' => $request->reason,
            'student_id' => $request->student_id,
            'lecture_id' => $request->lecture_id,
            'date_time' => $request->date_time,
        ];

        StudentAppointLecture::created($studentAppointedLecture_data);

        return [
            'code' => 2,
            'msg' => 'Successfully Appointed',
        ];
    }

    public function StudentAppointLecture_StudentSide_List(Request $request)
    {

        $tableData = [];

        $records = (new StudentAppointLecture)->where('student_id', 1)->get();

        foreach ($records as $key => $appointment) {
            $tableData[] = [
                'reason' => $appointment['reason'],
                'student' => User::find($appointment['student_id'])->name,
                'lecture' => User::find($appointment['lecture_id'])->name,
                'date_time' => $appointment['date_time'],
                'status' => $appointment['status'],
            ];
        }

        return $tableData;
    }

    public function StudentAppointLecture_LectureSide_List(Request $request)
    {

        $tableData = [];

        $records = (new StudentAppointLecture)->where('lecture_id', 1)->get();

        foreach ($records as $key => $appointment) {
            $tableData[] = [
                'reason' => $appointment['reason'],
                'student' => User::find($appointment['student_id'])->name,
                'lecture' => User::find($appointment['lecture_id'])->name,
                'date_time' => $appointment['date_time'],
                'status' => $appointment['status'],
            ];
        }

        return $tableData;
    }

    public function StudentAppointLecture_Approve(Request $request)
    {

        $request->validate([
            'id' => 'required|numeric'
        ]);

        StudentAppointLecture::where('id', $request->id)->update(['status', 1]);

        return [
            'code' => 2,
            'msg' => 'Successfully Confirmed',
        ];
    }

    public function StudentAppointLecture_Reject(Request $request)
    {

        $request->validate([
            'id' => 'required|numeric'
        ]);

        StudentAppointLecture::where('id', $request->id)->update(['status', 3]);

        return [
            'code' => 2,
            'msg' => 'Successfully Canceled',
        ];
    }
}

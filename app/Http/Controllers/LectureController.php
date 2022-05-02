<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\LectureHall;
use App\Models\Payment;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index()
    {
        $lecture_halls = LectureHall::where('status', 1)->get();
        $lecture_types = Lecture::$lecture_type;
        return view('pages.lecture', compact('lecture_halls', 'lecture_types'));
    }

    public function enroll(Request $request)
    {

        $request->validate([
            'l_name' => 'required|string',
            'l_hall_id' => 'required|numeric|min:1',
            'l_type_id' => 'required|numeric|in:1,2',
            'l_date' => 'required|date',
            'l_start_time' => 'required',
            'l_end_time' => 'required',
            'l_student_capacity' => 'required|numeric|min:1',
            'l_status' => 'required|numeric|in:1,2',
        ]);

        if ($request->l_student_capacity > LectureHall::find($request->l_hall_id)->student_capacity) {
            return redirect()->back()->with([
                'code' => 2,
                'color' => 'warning',
                'msg' => 'Hall Capcity is no compatible for your requirement',
            ]);
        }

        foreach (Lecture::where('status', 1)
            ->where('conduct_date', $request->l_date)
            ->where('lecture_hall_id', $request->l_hall_id)
            ->get() as $key => $lecture) {

            if (
                $request->l_start_time >= $lecture->start_time && $request->l_end_time <= $lecture->end_time ||
                $lecture->start_time >= $request->l_start_time && $lecture->end_time <= $request->l_end_time
            ) {
                return redirect()->back()->with([
                    'code' => 3,
                    'color' => 'warning',
                    'msg' => 'Requested time slot unavailable'
                ]);
            }
        }

        $lecture_data = [
            'name' => $request->l_name,
            'lecture_category_id' => 1,
            'lecture_hall_id' => $request->l_hall_id,
            'lecture_type' => $request->l_type_id,
            'conduct_date' => $request->l_date,
            'start_time' => $request->l_start_time,
            'end_time' => $request->l_end_time,
            'student_capacity' => $request->l_student_capacity,
            'status' => $request->l_status,
        ];

        if ($request->isnew == 1) {
            Lecture::create($lecture_data);
        } else {
            $request->validate([
                'record' => 'required|numeric|exists:lectures,id'
            ]);

            Lecture::where('id', $request->record)->update($lecture_data);
        }

        return redirect()->back()->with(
            [
                'code' => 1,
                'color' => 'success',
                'msg' => 'Lecture Successfully Saved'
            ]
        );
    }

    public function list()
    {
        return Laratables::recordsOf(Lecture::class);
    }

    public function getOne(Request $request)
    {

        $request->validate([
            'id' => 'required|numeric|exists:lectures,id'
        ]);

        return Lecture::find($request->id);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:lectures,id'
        ]);

        Lecture::find($request->id)->delete();

        return redirect()->back()->with(
            [
                'code' => 1,
                'color' => 'danger',
                'msg' => 'Lecture Successfully Removed',
            ]
        );
    }

    public function getEnrolledStudents(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:payments,id',
        ]);

        return Payment::where('status', [1, 2])
            ->where('lecture_id', $request->id)
            ->with('getStudent')
            ->get();
    }
}

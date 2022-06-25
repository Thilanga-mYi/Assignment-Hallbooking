<?php

namespace App\Http\Controllers;

use App\Models\StudentBookLectureHall;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class StudentBookLectureHallController extends Controller
{

    public function index()
    {
        return view('pages.studentBookedLectureHall');
    }

    public function list()
    {
        return Laratables::recordsOf(StudentBookLectureHall::class);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:student_book_lecture_halls,id',
            'status' => 'required|in:1,2,3',
        ]);

        $studentbooked_lecture_hall_data = [
            'id' => $request->id,
            'status' => $request->status,
        ];

        StudentBookLectureHall::find($request->id)->update($studentbooked_lecture_hall_data);

        return redirect()->back()->with(
            [
                'code' => 1,
                'color' => 'success',
                'msg' => 'Request Successfully Confirmed'
            ]
        );
    }
}

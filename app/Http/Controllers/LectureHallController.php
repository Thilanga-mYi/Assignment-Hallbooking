<?php

namespace App\Http\Controllers;

use App\Models\LectureHall;
use App\Models\University;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class LectureHallController extends Controller
{
    public function index()
    {
        $universities = University::where('status', 1)->get();
        return view('pages.lecture_hall', compact('universities'));
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'lh_university' => 'required|numeric|min:1',
            'lh_name' => 'required|string',
            'lh_capacity' => 'required|numeric|min:1',
            'lh_location' => 'required|string',
            'lh_description' => 'nullable',
            'lh_status' => 'required|in:1,2',
        ]);

        $lecture_hall_data = [
            'lecture_hall_name' => $request->lh_name,
            'university_id' => $request->lh_university,
            'lecture_hall_location' => $request->lh_location,
            'student_capacity' => $request->lh_capacity,
            'description' => $request->lh_description,
            'status' => $request->lh_status,
        ];

        if ($request->isnew == 1) {
            LectureHall::create($lecture_hall_data);
        } else {

            $request->validate([
                'record' => 'required|numeric|exists:lecture_halls,id',
            ]);

            LectureHall::find($request->record)->update($lecture_hall_data);
        }

        return redirect()->back()->with(
            [
                'code' => 1,
                'color' => 'success',
                'msg' => 'Lecture Hall Successfully Saved'
            ]
        );
    }

    public function list()
    {
        return Laratables::recordsOf(LectureHall::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:lecture_halls,id'
        ]);

        return LectureHall::where('id', $request->id)->first();
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:lecture_halls,id'
        ]);

        LectureHall::where('id', $request->id)->delete();

        return redirect()->back()->with(
            [
                'code' => 1,
                'color' => 'danger',
                'msg' => 'Lecture Hall Successfully Removed'
            ]
        );
    }
}

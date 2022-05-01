<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\LectureHall;
use App\Models\Subject;
use App\Models\Timetable;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('status', 1)->get();
        $lecture_halls = LectureHall::where('status', 1)->get();
        return view('pages.timetable', compact('subjects', 'lecture_halls'));
    }

    public function enroll(Request $request)
    {


        $request->validate([
            't_slot_name' => 'required|string',
            't_subject_id' => 'required|numeric|min:1|exists:subjects,id',
            't_lecture_hall_id' => 'required|numeric|min:1|exists:lecture_halls,id',
            't_date' => 'required|date',
            't_start_time' => 'required',
            't_end_time' => 'required',
            't_status' => 'required|numeric|in:1,2',
        ]);

        $timetable_data = [
            'slot_name' => $request->t_slot_name,
            'subject_id' => $request->t_subject_id,
            'lecture_hall_id' => $request->t_lecture_hall_id,
            'date' => $request->t_date,
            'start_time' => $request->t_start_time,
            'end_time' => $request->t_end_time,
            'status' => $request->t_status,
        ];

        if ($request->isnew) {
            Timetable::create($timetable_data);
        } else {
            $request->validate([
                'record' => 'required|numeric|exists:timetables,id'
            ]);

            Timetable::where('id', $request->record)->update($timetable_data);
        }

        return redirect()->back()->with(
            [
                'code' => 1,
                'color' => 'success',
                'msg' => 'Timetable Successfully Saved'
            ]
        );
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:timetables,id'
        ]);

        return Timetable::find($request->id);
    }

    public function doDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:timetables,id'
        ]);

        Timetable::where('id', $request->id)->delete();

        return redirect()->back()->with([
            'code' => 1,
            'color' => 'danger',
            'msg' => 'Record Succefully Deleted',
        ]);
    }

    public function getTimetableRecords()
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

    public function getLectureRecords()
    {
        $records = [];

        foreach (Lecture::orderBy('date', 'DESC')->get() as $key => $slot) {
            $records[] = [
                'lecture_name' => $slot->name,
                'lecture_type' => ($slot->lecture_type == 1 ? 'Theory' : 'Practicles'),
                'lecture_hall' => LectureHall::find($slot->lecture_hall_id)->lecture_hall_name,
                'date' => $slot->conduct_date,
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'status' => $slot->end_time,
                'editable' => 2,
            ];
        }

        return [
            'code' => 200,
            'status' => 'success',
            'date' => $records,
        ];
    }

    public function list()
    {
        return Laratables::recordsOf(Timetable::class);
    }
}

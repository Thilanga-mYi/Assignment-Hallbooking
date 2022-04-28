<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        return view('pages.subject');
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'isnew' => 'required|in:1,2',
            'record' => 'nullable',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:1,2'
        ]);

        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];

        if ($request->has('description') && $request->description != '') {
            $data['description'] = $request->description;
        }

        if ($request->isnew == 1) {
            Subject::create($data);
        } else {
            $request->validate([
                'record' => 'required|numeric|exists:subjects,id'
            ]);
            Subject::find($request->record)->update($data);
        }

        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'Subject Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function list(Request $request)
    {
        return Laratables::recordsOf(Subject::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:subjects,id'
        ]);
        return Subject::where('id', $request->id)->first();
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:subjects,id'
        ]);

        Subject::where('id', $request->id)->delete();

        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'Subject Successfully Removed']);
    }
}

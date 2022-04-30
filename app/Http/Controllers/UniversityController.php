<?php

namespace App\Http\Controllers;

use App\Models\University;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        return view('pages.university');
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'isnew' => 'required|in:1,2',
            'record' => 'nullable',
            'university_name' => 'required|string',
            'university_address' => 'required|string',
            'university_status' => 'required|in:1,2'
        ]);

        $data = [
            'name' => $request->university_name,
            'address' => $request->university_address,
            'status' => $request->university_status,
        ];

        if ($request->isnew == 1) {
            University::create($data);
        } else {
            $request->validate([
                'record' => 'required|numeric|exists:universities,id'
            ]);
            University::find($request->record)->update($data);
        }

        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'University Saved Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function list()
    {
        return Laratables::recordsOf(University::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:universities,id'
        ]);
        return University::where('id', $request->id)->first();
    }

    public function deleteOne(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:universities,id'
        ]);

        University::where('id', $request->id)->delete();
        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'University Successfully Removed']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('pages.events');
    }

    public function enroll(Request $request)
    {

        $request->validate([
            'isnew' => 'required|in:1,2',
            'record' => 'nullable',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start' => 'required',
            'end' => 'required',
            'status' => 'required|in:1,2'
        ]);

        $data = [
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'status' => $request->status,
        ];

        if ($request->has('description') && $request->description != '') {
            $data['description'] = $request->description;
        }

        if ($request->isnew == 1) {
            Event::create($data);
        } else {

            $request->validate([
                'record' => 'required|numeric|exists:events,id'
            ]);
            Event::find($request->record)->update($data);
        }

        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'Event Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function list()
    {
        return Laratables::recordsOf(Event::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:events,id'
        ]);
        return Event::where('id', $request->id)->first();
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:events,id'
        ]);

        Event::where('id', $request->id)->delete();

        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'Event Successfully Removed']);
    }
}

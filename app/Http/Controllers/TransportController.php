<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        $week_days = Transport::WEEK_DAYS;
        return view('pages.transport', compact('week_days'));
    }

    public function enroll(Request $request)
    {

        $request->validate([
            'isnew' => 'required|in:1,2',
            'record' => 'nullable',
            'trans_vehicle_no' => 'required|string',
            'trans_date' => 'required|date',
            'trans_start_time' => 'required',
            'trans_end_time' => 'required',
            'trans_start_location' => 'required|string',
            'trans_end_location' => 'required|string',
            'trans_route_description' => 'required|string',
            'trans_remark' => 'nullable',
            'trans_status' => 'required|in:1,2',
        ]);

        $trans_data = [
            'vehicle_no' => $request->trans_vehicle_no,
            'date' => $request->trans_date,
            'start_time' => $request->trans_start_time,
            'end_time' => $request->trans_end_time,
            'start_location' => $request->trans_start_location,
            'end_location' => $request->trans_end_location,
            'route_description' => $request->trans_route_description,
            'remark' => $request->trans_remark,
            'status' => $request->trans_status,
        ];

        if ($request->isnew == 1) {
            Transport::create($trans_data);
        } else {
            $request->validate([
                'record' => 'required|numeric|exists:transports,id'
            ]);
            Transport::find($request->record)->update($trans_data);
        }

        return redirect()->back()->with(
            [
                'code' => 1,
                'color' => 'success',
                'msg' => 'Transport Saved Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')
            ]
        );
    }

    public function list()
    {
        return Laratables::recordsOf(Transport::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:transports,id'
        ]);
        return Transport::where('id', $request->id)->first();
    }

    public function deleteOne(Request $request)
    {
    }
}

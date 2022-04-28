<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\User;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index()
    {
        return view('pages.license');
    }

    public function list(Request $request)
    {
        return Laratables::recordsOf(License::class);
    }

    public function find(Request $request)
    {
        $data = [];

        foreach (License::select('id', 'no', 'nic')->where('status', 1)->where('no', 'LIKE', '%' . $request->term . '%')
            ->orWhere('nic', 'LIKE', '%' . $request->term . '%')
            ->get() as $key => $value) {
            $data[] = ['id' => $value->id, 'text' => $value->no . ' (' . $value->nic . ')'];
        }

        return $data;
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:licenses,id'
        ]);
        return License::where('id', $request->id)->first();
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:licenses,id'
        ]);

        $licenseObject = License::where('id', $request->id)->first();

        if (User::where('nic', $licenseObject->nic)->count() == 0) {
            $licenseObject->delete();
            return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'License Successfully Removed']);
        } else {
            return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'License Cannot Be Remove']);
        }
    }

    public function renewOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:licenses,id'
        ]);

        $licenseObject = License::where('id', $request->id)->first();
        $licenseObject->update(['generated' => getCarbonDate($licenseObject->generated)->addYears(8), 'expire' => getCarbonDate($licenseObject->expire)->addYears(8)]);
        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'License Successfully Renewed']);
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'isnew' => 'required|in:1,2',
            'record' => 'nullable',
            'name' => 'required|string',
            'rfid' => 'required|string',
            'nic' => 'required|string|max:12',
            'bloodgroup' => 'required|string',
            'generated' => 'required|date',
            'expire' => 'required|date',
            'iswearglasses' => 'required|in:1,2',
            'status' => 'required|in:1,2'
        ]);

        if ($request->isnew == 1) {
            $request->validate(['no' => 'required|string|unique:licenses,no']);
            License::create([
                'name' => $request->name,
                'nic' => $request->nic,
                'no' => $request->no,
                'rfid' => $request->rfid,
                'bloodgroup' => $request->bloodgroup,
                'generated' => $request->generated,
                'expire' => $request->expire,
                'iswearglasses' => $request->iswearglasses,
                'vehicletypes' => json_encode($request->vehicletypes),
                'status' => $request->status,
            ]);
        } else {
            License::where('id', $request->record)->update([
                'name' => $request->name,
                'nic' => $request->nic,
                'no' => $request->no,
                'rfid' => $request->rfid,
                'bloodgroup' => $request->bloodgroup,
                'generated' => $request->generated,
                'expire' => $request->expire,
                'iswearglasses' => $request->iswearglasses,
                'vehicletypes' => json_encode($request->vehicletypes),
                'status' => $request->status,
            ]);
        }

        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'License Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('pages.payments');
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'record' => 'required|numeric|exists:payments,id',
            'payment_remark' => 'nullable',
            'payment_status' => 'required|numeric|in:1,2'
        ]);

        $data = [
            'remark' => $request->payment_remark,
            'status' => $request->payment_status,
        ];

        Payment::where('id', $request->record)->update($data);

        return redirect()->back()->with([
            'code' => 1,
            'color' => 'success',
            'msg' => 'Successfully Changed Status',
        ]);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:payments,id',
        ]);

        return Payment::find($request->id);
    }

    public function list()
    {
        return Laratables::recordsOf(Payment::class);
    }
}

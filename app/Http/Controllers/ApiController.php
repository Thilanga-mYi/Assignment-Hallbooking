<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function PaymentRegister(Request $request)
    {
        $request->validate([
            'payment_name' => 'required|string',
            'payment_student_id' => 'required|numeric|exists:users,id',
            'payment_lecture_id' => 'required|numeric|exists:lectures,id',
            'payment_paid_amount' => 'required|numeric|min:1',
            'payment_status' => 'required|numeric|in:1,2',
        ]);

        if (
            count(
                Payment::where('student_id', $request->payment_student_id)
                    ->where('lecture_id', $request->payment_lecture_id)
                    ->get()
            ) != 0
        ) {

            $data = [
                'name' => $request->payment_name,
                'student_id' => $request->payment_student_id,
                'lecture_id' => $request->payment_lecture_id,
                'paid_amount' => $request->payment_paid_amount,
                'status' => 3,
            ];

            Payment::create();
        } else {
            return [
                'code' => 2,
                'msg' => '2',
            ];
        }
    }
}

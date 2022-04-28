<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Ticket;
use App\Models\TicketReason;
use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $officerUserType = 1;

    public function index()
    {
        $usertypes = UserType::where('status', 1)->get();
        return view('pages.users', compact(['usertypes']));
    }

    public function loginAPI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('usertype', 4)->where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $response = ['user' => $user, 'reasons' => TicketReason::where('status', 1)->get(), 'tickets' => Ticket::where('by', $user->id)->orderBy('created_at', 'DESC')->with('licensedata')->with('ticketdata')->limit(20)->get()];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }

    public function assignedCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mac' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        if ($user = User::where('mac', $request->mac)->whereNotNull('rfid')->first()) {
            $license = License::where('nic', $user->nic)->first();
            $license['bloodgroup'] = License::$bloodgroup[$license->bloodgroup];

            $vehicles = [];

            foreach (json_decode($license['vehicletypes']) as $key => $value) {
                $vehicles[] = License::$types[$key];
            }

            $license['vehicletypes'] = $vehicles;

            $expired_total = 0.0;

            foreach (Ticket::where('license', $license->id)->where('status', 3)->with('ticketdata')->get() as $key => $value) {
                $expired_total += $value['ticketdata']->ticket_value;

                if (Carbon::now()->gt(Carbon::parse($value->created_at)->addDays(14))) {
                    $expired_total += 500;
                }
            }

            $data = ["license" => $license, 'expired_total' => format_currency($expired_total)];

            $user->update(['rfid' => null]);

            return response($data, 200);
        } else {
            return response([], 422);
        }
    }

    public function assigned(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mac' => 'required|string',
            'rfid' => 'required|string|exists:licenses,rfid',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        if ($user = User::where('mac', $request->mac)->first()) {
            User::where('rfid', $request->rfid)->update(['rfid' => null]);
            $user->update(['rfid' => $request->rfid]);
            return response(["message" => 'Successful'], 200);
        } else {
            if ($validator->fails()) {
                return response(["message" => 'Device Not Assigned'], 422);
            }
        }
    }

    public function find(Request $request)
    {
        $data = [];

        foreach (User::select('id', 'name', 'nic')->where('usertype', $this->officerUserType)->where('status', 1)->where('nic', 'LIKE', '%' . $request->term . '%')
            ->get() as $key => $value) {
            $data[] = ['id' => $value->id, 'text' => $value->name . ' (' . $value->nic  . ')'];
        }

        return $data;
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('routes');
        Session::flush();
        return redirect('/login');
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'isnew' => 'required|in:1,2',
            'nic' => 'required|string',
            'name' => 'required|min:1',
            'mobile' => 'required',
            'usertype' => 'required|exists:user_types,id',
            'status' => 'required|in:1,2,3'
        ]);

        if ($request->isnew == 1) {
            $request->validate([
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
            ]);

            $data = [
                'nic' => $request->nic,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'usertype' => $request->usertype,
                'status' => $request->status,
            ];

            User::create($data);
        } else {
            $request->validate([
                'password' => 'nullable|min:8',
                'password_confirmation' => 'nullable|same:password',
                'record' => 'required|exists:users,id'
            ]);
            $data = [
                'nic' => $request->nic,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'usertype' => $request->usertype,
                'status' => $request->status
            ];
            if ($request->has('password') && $request->password != '' && $request->has('password_confirmation')) {
                $data['password'] = Hash::make($request->password);
            }
            User::where('id', $request->record)->update($data);
        }
        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'User Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
    }

    public function changeStatus($id, $status)
    {
        $user = User::find($id);
        if ($user) {
            $user->update(['status' => $status]);
            return redirect()->back()->with(['resp' => ['msg' => 'User Successfully Updated.', 'color' => 'success']]);
        }
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id'
        ]);
        User::where('id', $request->id)->update(['status' => 4]);

        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'User Successfully Removed']);
    }

    public function list(Request $request)
    {
        return Laratables::recordsOf(User::class);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id'
        ]);
        return User::where('id', $request->id)->first();
    }
}

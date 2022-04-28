<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Invoice;
use App\Models\Ticket;
use App\Models\User;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $officerUserType = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $officersCount = 0;
        $ticketsCount = 0;
        $pendingCount = 0;

        $date = Carbon::now()->timezone('Asia/Colombo')->subDays(10)->format('Y-m-d');

        $lastTenTickets = [];

        $dates = [];
        $tickets = [];

        foreach ($lastTenTickets as $key => $value) {
            $check = false;
            $index = 0;

            if(array_key_exists($value->created_at->timezone('Asia/Colombo')->format('Y-m-d'),$tickets)){
                $tickets[$value->created_at->timezone('Asia/Colombo')->format('Y-m-d')]=$tickets[$value->created_at->timezone('Asia/Colombo')->format('Y-m-d')]+ $value->grand_total;
            }else{
                $tickets[$value->created_at->timezone('Asia/Colombo')->format('Y-m-d')]=$value['ticketdata']->ticket_value;
            }
        }

        $dates=array_keys($tickets);
        $tickets=array_values($tickets);

        $dates = array_reverse($tickets);
        $tickets = array_reverse($tickets);

        return view('home',compact(['officersCount','ticketsCount','pendingCount','dates','tickets']));
    }
}

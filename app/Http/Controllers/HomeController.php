<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Invoice;
use App\Models\LectureHall;
use App\Models\Subject;
use App\Models\Ticket;
use App\Models\Timetable;
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

        $calenderData = [];

        foreach (Timetable::orderBy('date', 'DESC')->get() as $key => $slot) {
            $start=Carbon::parse($slot->date . ' ' . $slot->start_time);
            $end=Carbon::parse($slot->date . ' ' . $slot->end_time);
            $calenderData[] = ['title' => $slot->slot_name . ' ( ' . Subject::find($slot->subject_id)->name . ' )', 'start' =>  $start->format('Y-m-d').'T'.$start->format('h:m:s') , 'end' => $end->format('Y-m-d').'T'.$end->format('h:m:s')];
        }

        return view('home', compact('calenderData'));
    }
}

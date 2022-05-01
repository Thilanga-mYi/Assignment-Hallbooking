<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Event;
use App\Models\Invoice;
use App\Models\Lecture;
use App\Models\LectureHall;
use App\Models\Subject;
use App\Models\Ticket;
use App\Models\Timetable;
use App\Models\Transport;
use App\Models\User;
use App\Models\VehicleType;
use Carbon\Carbon;
use Freshbitsweb\Laratables\Laratables;
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
            $start = Carbon::parse($slot->date . ' ' . $slot->start_time);
            $end = Carbon::parse($slot->date . ' ' . $slot->end_time);
            $calenderData[] = [
                'title' => $slot->slot_name . ' ( ' . Subject::find($slot->subject_id)->name . ' )',
                'start' =>  $start->format('Y-m-d') . 'T' . $start->format('h:m:s'),
                'end' => $end->format('Y-m-d') . 'T' . $end->format('h:m:s')
            ];
        }

        $total_transports = count(Transport::where('status', 1)->get());
        $total_events = count(Event::where('status', 1)->get());
        $total_lectures = count(Lecture::where('status', 1)->get());
        $total_payment_requests = 1;

        return view('home', compact('calenderData', 'total_transports', 'total_events', 'total_lectures', 'total_payment_requests'));
    }

    public function eventsList()
    {
        return Laratables::recordsOf(Event::class);
    }

    public function lecturesList()
    {
        return Laratables::recordsOf(Lecture::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('status', 1)->get();
        return view('pages.timetable', compact(['subjects']));
    }
}

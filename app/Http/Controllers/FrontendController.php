<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function exhibits()
    {
        return view('exhibits');
    }

    public function animals()
    {
        return view('animals');
    }

    public function visitors()
    {
        return view('visitors');
    }

    public function bookings()
    {
        return view('bookings');
    }

    public function tours()
    {
        return view('tours');
    }

    public function feedingSchedules()
    {
        return view('feeding-schedules');
    }
}
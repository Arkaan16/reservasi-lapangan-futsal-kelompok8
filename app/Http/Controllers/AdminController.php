<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Schedule;

class AdminController extends Controller
{
    public function index()
    {
        $fields = Field::count();
        $bookings = Booking::all();
        $users = User::where('role', 'user')->count(); 
        $schedules = Schedule::count();
        
        return view('admin.dashboard', compact('fields', 'bookings', 'users', 'schedules'));
    }
}

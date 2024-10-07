<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Booking;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $fields = Field::count();
        $bookings = Booking::all();
        $users = User::where('role', 'user')->count(); 
        
        return view('admin.dashboard', compact('fields', 'bookings', 'users'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    public function create($fieldId)
    {
        $field = Field::findOrFail($fieldId); // Ambil data lapangan berdasarkan ID
        return view('user.bookings.create', compact('field'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'field_id' => 'required|exists:fields,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'booking_name' => $request->booking_name,
            'phone_number' => $request->phone_number,
            'field_id' => $request->field_id,
            'schedule_id' => $request->schedule_id,
            'status' => 'pending', // Status default untuk booking baru oleh user
        ]);

        return redirect()->route('user.bookings.create')->with('success', 'Booking berhasil ditambahkan!');
    }
}

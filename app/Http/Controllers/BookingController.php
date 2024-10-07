<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\Booking;

class BookingController extends Controller
{
    public function create()
    {
        $fields = Field::all(); // Ambil data lapangan dari database
        return view('create', compact('fields'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Simpan pemesanan
        Booking::create([
            'user_id' => auth()->id(), // ID pengguna yang login
            'field_id' => $request->field_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('bookings.create')->with('success', 'Pemesanan berhasil!');
    }
}
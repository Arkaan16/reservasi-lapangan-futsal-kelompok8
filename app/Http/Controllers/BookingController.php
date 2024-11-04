<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'field', 'payment')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $fields = Field::all();
        $schedules = Schedule::with('field')->get(); // Ambil jadwal dengan relasi lapangan

        return view('admin.bookings.create', compact('users', 'fields', 'schedules'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'field_id' => 'required|exists:fields,id',
            'schedule_id' => 'required|exists:schedules,id',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        // Membuat booking
        $booking = Booking::create($validated);

        // Membuat payment
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $validated['amount'],
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking dan Payment berhasil dibuat.');
    }

    public function edit($id)
    {
        $booking = Booking::with('payment')->findOrFail($id);
        $fields = Field::all();
        return view('admin.bookings.edit', compact('booking', 'fields'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'status' => 'required|in:pending,confirmed,completed,canceled',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        // Update booking
        $booking = Booking::findOrFail($id);
        $booking->update($validated);

        // Update payment
        $booking->payment->update([
            'amount' => $validated['amount'],
            'status' => $request->input('payment_status'),
            'payment_method' => $validated['payment_method'],
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking dan Payment berhasil diupdate.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
    
}
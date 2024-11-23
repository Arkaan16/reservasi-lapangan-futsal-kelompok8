<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        // Menampilkan semua booking milik user yang login
        $bookings = Booking::where('user_id', Auth::id())->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        // Ambil semua data lapangan dan jadwal
        $users = User::all();
        $fields = Field::all(); // Ambil semua data lapangan
        $schedules = Schedule::where('is_available', true)->get(); // Ambil semua jadwal

        // Kirim data ke view create
        return view('admin.bookings.create', compact('users','fields', 'schedules'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'schedule_id' => 'required|exists:schedules,id',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
        ]);

        // Simpan booking, tanpa perlu memilih user_id, karena menggunakan Auth::id()
        Booking::create([
            'user_id' => Auth::id(), // Menggunakan user yang sedang login
            'field_id' => $validated['field_id'],
            'schedule_id' => $validated['schedule_id'],
            'booking_name' => $validated['booking_name'],
            'phone_number' => $validated['phone_number'],
            'status' => 'pending',
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat');
    }

    public function edit(Booking $booking)
    {
        // Pastikan hanya user terkait yang dapat mengedit atau admin
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk mengedit booking ini.');
        }

        $fields = Field::all();
        $schedules = Schedule::all();
        return view('admin.bookings.edit', compact('booking', 'fields', 'schedules'));
    }

    public function update(Request $request, Booking $booking)
    {
        // Memastikan hanya admin atau pemilik booking yang bisa mengupdate
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk mengupdate booking ini.');
        }

        // Validasi input
        $validated = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'schedule_id' => 'required|exists:schedules,id',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'status' => 'required|in:pending,confirmed,completed,canceled',
        ]);

        // Update booking
        $booking->update($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui');
    }

    public function destroy(Booking $booking)
    {
        // Memastikan hanya admin atau pemilik booking yang bisa menghapus
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk menghapus booking ini.');
        }

        // Menghapus booking
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus');
    }   

    public function getSchedules(Request $request)
    {
    // Validasi input
    $validated = $request->validate([
        'field_id' => 'required|exists:fields,id',
        'date' => 'required|date',
    ]);

    // Ambil jadwal berdasarkan lapangan dan tanggal
    $schedules = Schedule::where('field_id', $validated['field_id'])
                         ->where('date', $validated['date'])
                         ->where('is_available', true) // Pastikan jadwal tersedia
                         ->get();

    return response()->json($schedules);
}
}

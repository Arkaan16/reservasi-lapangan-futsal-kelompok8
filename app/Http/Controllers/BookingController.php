<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with('user', 'field', 'payment')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        $fields = Field::all();
        $schedules = Schedule::with('field')->get(); // Ambil jadwal dengan relasi lapangan

        return view('admin.bookings.create', compact('users', 'fields', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'field_id' => 'required|exists:fields,id',
            'schedule_id' => 'required|exists:schedules,id',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk bukti pembayaran
        ]);

        // Membuat booking
        $booking = Booking::create([
            'user_id' => $request->user_id,
            'field_id' => $request->field_id,
            'schedule_id' => $request->schedule_id,
            'booking_name' => $request->booking_name,
            'phone_number' => $request->phone_number,
        ]);

        $paymentProofPath = null; // Inisialisasi path bukti pembayaran

        // Menangani upload foto bukti pembayaran
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Membuat payment
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $request->amount,
            'status' => 'pending', // Status payment default
            'payment_method' => $request->payment_method,
            'payment_proof' => $paymentProofPath, // Menyimpan path bukti pembayaran
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking dan Payment berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with('user', 'field', 'payment')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = Booking::with('user', 'field', 'payment')->findOrFail($id);
        $users = User::where('role', 'user')->get();
        $fields = Field::all();
        $schedules = Schedule::with('field')->get();

        return view('admin.bookings.edit', compact('booking', 'users', 'fields', 'schedules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'field_id' => 'required|exists:fields,id',
            'schedule_id' => 'required|exists:schedules,id',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,paid,failed', // Validasi untuk status
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk bukti pembayaran
        ]);

        $booking = Booking::with('payment')->findOrFail($id);
        $booking->user_id = $request->user_id;
        $booking->field_id = $request->field_id;
        $booking->schedule_id = $request->schedule_id;
        $booking->booking_name = $request->booking_name;
        $booking->phone_number = $request->phone_number;

        // Mengupdate pembayaran
        $payment = $booking->payment;
        $payment->amount = $request->amount; // Mengupdate jumlah pembayaran
        $payment->payment_method = $request->payment_method; // Mengupdate metode pembayaran
        $payment->status = $request->status; // Mengupdate status pembayaran

        // Menyimpan bukti pembayaran jika diupload
        if ($request->hasFile('payment_proof')) {
            // Hapus file lama jika ada
            if ($payment->payment_proof) {
                Storage::disk('public')->delete($payment->payment_proof);
            }
            $payment->payment_proof = $request->file('payment_proof')->store('payment_proofs', 'public'); // Menyimpan bukti pembayaran yang baru
        }

        $booking->save(); // Simpan perubahan booking
        $payment->save(); // Simpan perubahan payment

        return redirect()->route('admin.bookings.index')->with('success', 'Booking status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::with('payment')->findOrFail($id);

        // Hapus file bukti pembayaran jika ada
        if ($booking->payment->payment_proof) {
            Storage::disk('public')->delete($booking->payment->payment_proof);
        }

        // Hapus booking dan payment
        $booking->payment()->delete(); // Hapus pembayaran
        $booking->delete(); // Hapus booking

        return redirect()->route('admin.bookings.index')->with('success', 'Booking dan Payment berhasil dihapus.');
    }
}

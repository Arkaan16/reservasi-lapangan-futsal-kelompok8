<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all(); // Mendapatkan semua pembayaran
        $bookings = Booking::with('schedule')->get(); // Mendapatkan semua booking dengan relasi schedule

        return view('admin.payments.index', compact('payments', 'bookings'));
    }


    public function create($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);  // Cari booking berdasarkan ID
        return view('admin.payments.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,paid,failed',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $paymentData = $request->only(['booking_id', 'amount', 'status', 'payment_method']);

        if ($request->hasFile('payment_proof')) {
            $paymentData['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        Payment::create($paymentData);

        return redirect()->route('admin.payments.index')->with('success', 'Payment successfully added!');
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,paid,failed',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $paymentData = $request->only(['amount', 'status', 'payment_method']);

        if ($request->hasFile('payment_proof')) {
            // Hapus file lama jika ada
            if ($payment->payment_proof) {
                Storage::delete('public/' . $payment->payment_proof);
            }

            $paymentData['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $payment->update($paymentData);

        return redirect()->route('admin.payments.index')->with('success', 'Payment successfully updated!');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment->payment_proof) {
            Storage::delete('public/' . $payment->payment_proof);
        }
        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Payment successfully deleted!');
    }
}

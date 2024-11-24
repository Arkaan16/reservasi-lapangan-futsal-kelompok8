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
    // public function create($field_id)
    // {
    //     $field = Field::findOrFail($field_id); // Ambil data lapangan berdasarkan ID
    //     return view('user.bookings.create', compact('field'));
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'booking_name' => 'required|string|max:255',
    //         'phone_number' => 'required|string|max:15',
    //         'field_id' => 'required|exists:fields,id',
    //         'schedule_id' => 'required|exists:schedules,id',
    //     ]);

    //     Booking::create([
    //         'user_id' => Auth::id(),
    //         'booking_name' => $request->booking_name,
    //         'phone_number' => $request->phone_number,
    //         'field_id' => $request->field_id,
    //         'schedule_id' => $request->schedule_id,
    //         'status' => 'pending', // Status default untuk booking baru oleh user
    //     ]);

    //     return redirect()->route('user.bookings.index')->with('success', 'Booking berhasil ditambahkan!');
    // }
    public function create(Request $request, $field_id)
    {
        try {
            $field = Field::findOrFail($field_id);
            $fields = Field::all();
            $schedules = Schedule::all();
            return view('user.bookings.create', compact('field', 'fields', 'schedules'));
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Lapangan tidak ditemukan');
        }
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'field_id' => 'required|exists:fields,id',
                'booking_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'schedule_id' => 'required|exists:schedules,id',
            ]);
    
            Booking::create([
                'user_id' => auth()->id(),
                'field_id' => $request->field_id,
                'schedule_id' => $request->schedule_id,
                'booking_name' => $request->booking_name,
                'phone_number' => $request->phone_number,
                'status' => 'pending',
            ]);
    
            return redirect()->route('user.bookings.index')->with('success', 'Pemesanan berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat pemesanan');
        }
    }

    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with(['field', 'schedule'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Menampilkan 10 booking per halaman
        
        return view('user.bookings.index', compact('bookings'));
    }

}
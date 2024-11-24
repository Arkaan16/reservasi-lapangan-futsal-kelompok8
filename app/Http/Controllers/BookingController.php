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
        if (auth()->user()->role == 'admin') {
            $bookings = Booking::all();
        } else {
            $bookings = Booking::where('user_id', auth()->id())->get();
        }

        if (auth()->user()->role == 'admin') {
            return view('admin.bookings.index', compact('bookings'));
        } else {
            return view('user.bookings.index', compact('bookings'));
        }
    }

    // public function index()
    // {
    //     // Menampilkan semua booking milik user yang login
    //     $bookings = Booking::where('user_id', Auth::id())->get();
    //     return view('admin.bookings.index', compact('bookings'));
    // }

    // public function create()
    // {
    //     // Ambil semua data lapangan dan jadwal
    //     $users = User::all();
    //     $fields = Field::all(); // Ambil semua data lapangan
    //     $schedules = Schedule::where('is_available', true)->get(); // Ambil semua jadwal

    //     // Kirim data ke view create
    //     return view('admin.bookings.create', compact('users','fields', 'schedules'));
    // }

    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $validated = $request->validate([
    //         'field_id' => 'required|exists:fields,id',
    //         'schedule_id' => 'required|exists:schedules,id',
    //         'booking_name' => 'required|string|max:255',
    //         'phone_number' => 'required|string|max:13',
    //     ]);

    //     // Simpan booking, tanpa perlu memilih user_id, karena menggunakan Auth::id()
    //     Booking::create([
    //         'user_id' => Auth::id(), // Menggunakan user yang sedang login
    //         'field_id' => $validated['field_id'],
    //         'schedule_id' => $validated['schedule_id'],
    //         'booking_name' => $validated['booking_name'],
    //         'phone_number' => $validated['phone_number'],
    //         'status' => 'pending',
    //     ]);

    //     return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat');
    // }

    //----------------------------------------------------------------------------------------------//
    // public function create()
    // {
    //     // Ambil data lapangan, pengguna, dan jadwal yang tersedia
    //     $fields = Field::all();
    //     $users = User::all();
    //     $schedules = Schedule::with('field')
    //                          ->where('is_available', 1) // hanya yang tersedia
    //                          ->get();

    //     return view('admin.bookings.create', compact('fields', 'users', 'schedules'));
    // }

    public function create()
    {
        $fields = Field::all();
        $userRole = auth()->user()->role;
        $users = User::all();  // Hanya untuk admin yang membutuhkan daftar pengguna
    
        // Menentukan jadwal yang akan ditampilkan berdasarkan role
        if ($userRole == 'admin') {
            // Admin bisa melihat semua jadwal
            $schedules = Schedule::all();
        } else {
            // Pengguna biasa hanya melihat jadwal yang tersedia
            $schedules = Schedule::where('is_available', true)->get();
        }
    
        // Menentukan tampilan yang berbeda berdasarkan role pengguna
        if ($userRole == 'admin') {
            // Untuk admin, kirimkan data pengguna ke view
            return view('admin.bookings.create', compact('fields', 'schedules', 'users'));
        } else {
            // Untuk user biasa
            return view('user.bookings.create', compact('fields', 'schedules'));
        }
    }
    
    // public function store(Request $request)
    // {
        
    //     // Validasi input
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'booking_name' => 'required|string|max:255',
    //         'phone_number' => 'required|string|max:20',
    //         'field_id' => 'required|exists:fields,id',
    //         'schedule_id' => 'required|exists:schedules,id',
    //         'status' => 'required|string|in:pending,confirmed,completed,canceled',
    //     ]);

    //     // Simpan booking
    //     Booking::create([
    //         'user_id' => $request->user_id,
    //         'booking_name' => $request->booking_name,
    //         'phone_number' => $request->phone_number,
    //         'field_id' => $request->field_id,
    //         'schedule_id' => $request->schedule_id,
    //         'status' => $request->status,
    //     ]);

    //     if (auth()->user()->role == 'admin') {
    //         return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil ditambahkan.');
    //     } else {
    //         return redirect()->route('user.bookings.index')->with('success', 'Booking berhasil ditambahkan.');
    //     }
    // }

    // public function store(Request $request)
    //     {
    //         dd($request->all()); 
    //         // Validasi input
    //         $request->validate([
    //             'booking_name' => 'required|string|max:255',
    //             'phone_number' => 'required|string|max:20',
    //             'field_id' => 'required|exists:fields,id',
    //             'schedule_id' => 'required|exists:schedules,id',
    //             'status' => 'required|string|in:pending,confirmed,completed,canceled',
    //             'user_id' => 'required_if:role,admin|exists:users,id',  // Validasi jika admin memilih user
    //         ]);

    //         // Cek jika yang login admin atau user
    //         $userId = auth()->user()->role == 'admin' ? $request->user_id : auth()->id();

    //         // Menyimpan data booking
    //         Booking::create([
    //             'user_id' => $userId,  // Menggunakan user_id yang dipilih oleh admin atau ID user yang login
    //             'booking_name' => $request->booking_name,
    //             'phone_number' => $request->phone_number,
    //             'field_id' => $request->field_id,
    //             'schedule_id' => $request->schedule_id,
    //             'status' => $request->status ?? 'pending',
    //         ]);

    //         // Redirect sesuai role pengguna
    //         if (auth()->user()->role == 'admin') {
    //             return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil ditambahkan.');
    //         } else {
    //             return redirect()->route('user.bookings.index')->with('success', 'Booking berhasil ditambahkan.');
    //         }
    //     }

    public function store(Request $request)
    {
        try {
            // Logging untuk debug
            \Log::info('Booking Request:', $request->all());
            \Log::info('Auth User:', ['id' => auth()->id(), 'role' => auth()->user()->role]);

            // Set validasi yang berbeda untuk admin dan user
            $validationRules = [
                'booking_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'field_id' => 'required|exists:fields,id',
                'schedule_id' => 'required|exists:schedules,id',
            ];

            // Tambahan validasi untuk admin
            if (auth()->user()->role === 'admin') {
                $validationRules['user_id'] = 'required|exists:users,id';
                $validationRules['status'] = 'required|string|in:pending,confirmed,completed,canceled';
            }

            // Validasi input
            $validated = $request->validate($validationRules);

            // Set user_id berdasarkan role
            $userId = auth()->user()->role === 'admin' ? $request->user_id : auth()->id();
            
            // Set status default untuk user biasa
            $status = auth()->user()->role === 'admin' ? $request->status : 'pending';

            // Cek apakah schedule sudah dibooking
            $existingBooking = Booking::where('schedule_id', $request->schedule_id)
                ->where('field_id', $request->field_id)
                ->where('status', '!=', 'canceled')
                ->first();

            if ($existingBooking) {
                throw new \Exception('Jadwal ini sudah dibooking.');
            }

            // Menyimpan data booking
            $booking = Booking::create([
                'user_id' => $userId,
                'booking_name' => $request->booking_name,
                'phone_number' => $request->phone_number,
                'field_id' => $request->field_id,
                'schedule_id' => $request->schedule_id,
                'status' => $status,
            ]);

            \Log::info('Booking Created:', $booking->toArray());

            // Redirect sesuai role pengguna
            $route = auth()->user()->role === 'admin' ? 'admin.bookings.index' : 'user.bookings.index';
            return redirect()->route($route)->with('success', 'Booking berhasil ditambahkan.');

        } catch (\Exception $e) {
            \Log::error('Booking Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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

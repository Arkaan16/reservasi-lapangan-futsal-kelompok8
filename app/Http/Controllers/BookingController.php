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
        $bookings = Booking::all();
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

    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'field_id' => 'required|exists:fields,id',
    //         'date' => 'required|date',
    //         'schedule_id' => 'required|exists:schedules,id', // pastikan memilih jadwal yang ada
    //         'total_price' => 'required|numeric|min:0',
    //     ]);
    
    //     // Mendapatkan jadwal yang dipilih
    //     $schedule = Schedule::find($request->schedule_id);
    //     if ($schedule->is_available == 0) {
    //         return redirect()->back()->with('error', 'Jadwal sudah dipesan.');
    //     }
    
    //     // Menyimpan booking dengan menambahkan tanggal yang dipilih
    //     $booking = Booking::create([
    //         'user_id' => auth()->id(),
    //         'field_id' => $request->field_id,
    //         'schedule_id' => $schedule->id,
    //         'total_price' => $request->total_price, // Gunakan nilai yang dikirimkan dari form
    //         'booking_name' => $request->booking_name,
    //         'phone_number' => $request->phone_number,
    //         'status' => 'pending',
    //     ]);
    
    //     // Memperbarui jadwal untuk menyimpan tanggal booking
    //     $schedule->update([
    //         'date' => $request->date,  // Menyimpan tanggal booking ke dalam jadwal
    //         'is_available' => 0
    //     ]);
    
    //     // Jika pengguna adalah admin, arahkan ke halaman admin
    //     if (auth()->user()->role === 'admin') {
    //         return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat!');
    //     }
    
    //     // Jika pengguna adalah user biasa, arahkan ke halaman user
    //     return redirect()->route('user.administration.index')->with('success', 'Booking berhasil dibuat!');
    // }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'date' => 'required|date',
            'schedule_id' => 'required|exists:schedules,id',
            'duration' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'booking_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:13',
        ]);
    
        // Mendapatkan jadwal yang dipilih
        $schedule = Schedule::findOrFail($request->schedule_id);
        if ($schedule->is_available == 0) {
            return redirect()->back()->with('error', 'Jadwal sudah dipesan.');
        }
    
        // Ambil waktu mulai dari jadwal
        $startTime = $schedule->start_time;
    
        // Hitung waktu selesai berdasarkan durasi
        $durationInHours = (int)$request->duration;
        $endTime = date('H:i:s', strtotime("+{$durationInHours} hours", strtotime($startTime)));
    
        // Hitung total harga
        $field = Field::findOrFail($request->field_id);
        $pricePerHour = $field->price_per_hour;
        $totalPrice = $pricePerHour * $durationInHours;
    
        // Simpan data ke tabel booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'field_id' => $request->field_id,
            'schedule_id' => $schedule->id,
            'start_time' => $startTime, // Jam mulai
            'end_time' => $endTime, // Jam selesai
            'total_price' => $totalPrice, // Total harga
            'booking_name' => $request->booking_name,
            'phone_number' => $request->phone_number,
            'status' => 'pending',
        ]);
    
        // Update jadwal menjadi tidak tersedia
        $schedule->update([
            'is_available' => 0,
        ]);
    
        // Redirect ke halaman yang sesuai
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat!');
        }
    
        return redirect()->route('user.administration.index')->with('success', 'Booking berhasil dibuat!');
    }
    
        
    
    public function edit(Booking $booking)
    {
        // Pastikan hanya user terkait yang dapat mengedit atau admin
        if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('admin.bookings.index')->with('error', 'Anda tidak memiliki izin untuk mengedit booking ini.');
        }
        
        $booking = $booking->load('schedule'); 
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

        // Jika jadwal berubah, kembalikan jadwal lama menjadi tersedia
        if ($booking->schedule_id !== $validated['schedule_id']) {
            $oldSchedule = Schedule::find($booking->schedule_id);
            if ($oldSchedule) {
                $oldSchedule->update(['is_available' => true]);
            }
        }

        // Update booking dengan data baru
        $booking->update($validated);

        // Ambil jadwal baru
        $schedule = Schedule::find($validated['schedule_id']);
        if ($schedule) {
            // Perbarui status ketersediaan jadwal berdasarkan status booking
            switch ($validated['status']) {
                case 'pending':
                case 'confirmed':
                    $schedule->update(['is_available' => false]); // Jadwal tidak tersedia
                    break;
                case 'completed':
                case 'canceled':
                    $schedule->update(['is_available' => true]); // Jadwal tersedia kembali
                    break;
            }
        }

        // Redirect dengan pesan sukses
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
            'duration' => 'required|integer|min:1', // Validasi untuk durasi dalam jam
        ]);
    
        // Konversi tanggal yang dipilih menjadi nama hari
        $day = \Carbon\Carbon::parse($validated['date'])->locale('id')->isoFormat('dddd'); // "Senin", "Selasa", dst.
    
        // Ambil jadwal berdasarkan lapangan, hari, dan status tersedia
        $schedules = Schedule::where('field_id', $validated['field_id'])
                            ->where('day', ucfirst($day)) // Mencocokkan nama hari (case sensitive)
                            ->where('is_available', true) // Pastikan hanya jadwal yang tersedia yang diambil
                            ->get();
    
        // Filter jadwal berdasarkan durasi
        $filteredSchedules = $schedules->filter(function ($schedule) use ($validated) {
            $startTime = \Carbon\Carbon::parse($schedule->start_time);
            $endTime = \Carbon\Carbon::parse($schedule->end_time);
    
            // Hitung durasi yang tersedia dalam jam
            $availableDuration = $startTime->diffInHours($endTime);
    
            return $availableDuration >= $validated['duration']; // Cek apakah durasi cukup
        });
    
        return response()->json($filteredSchedules->values()); // Pastikan data direturn sebagai array
    }
    

    public function indexBookingsUser()
    {
        // Ambil semua booking yang hanya dimiliki oleh user yang sedang login
        $bookings = Booking::where('user_id', Auth::id())->get();

        // Kirim data booking ke view
        return view('user.administration.index', compact('bookings'));
    }

    public function cancel($bookingId)
    {
        // Mencari booking berdasarkan ID
        $booking = Booking::find($bookingId);

        // Pastikan booking ditemukan dan user yang login adalah pemilik booking
        if (!$booking || $booking->user_id !== auth()->id()) {
            return redirect()->route('user.administration.index')->with('error', 'Booking tidak ditemukan atau Anda tidak memiliki izin untuk membatalkannya.');
        }

        // Mengubah status booking menjadi 'canceled'
        $booking->update(['status' => 'canceled']);

        // Mengembalikan jadwal menjadi tersedia
        $schedule = Schedule::find($booking->schedule_id);
        if ($schedule) {
            $schedule->update(['is_available' => true]);
        }

        // Redirect ke halaman riwayat booking
        return redirect()->route('user.administration.index')->with('success', 'Booking berhasil dibatalkan.');
    }


}
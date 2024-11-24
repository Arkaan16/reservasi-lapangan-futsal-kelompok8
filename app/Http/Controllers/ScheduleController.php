<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Field;
use Illuminate\Http\Request;
use Carbon\Carbon;

// class ScheduleController extends Controller
// {
//     public function index()
//     {
//         $schedules = Schedule::with('field')->get();
//         return view('admin.schedules.index', compact('schedules'));
//     }

//     public function create()
//     {
//         $fields = Field::all();
//         return view('admin.schedules.create', compact('fields'));
//     }

//     public function store(Request $request)
//     {
//         // Validasi input
//         $request->validate([
//             'field_id' => 'required|exists:fields,id',
//             'date' => 'required|date',
//             'start_time' => 'required|date_format:H:i',
//             'end_time' => 'required|date_format:H:i|after:start_time',
//             'is_available' => 'boolean',
//         ]);

//         // Membuat jadwal baru
//         Schedule::create([
//             'field_id' => $request->field_id,
//             'date' => $request->date,
//             'start_time' => $request->start_time,
//             'end_time' => $request->end_time,
//             'is_available' => $request->is_available ? 1 : 0,
//         ]);

//         return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
//     }

//     public function show(Schedule $schedule)
//     {
//         $schedule->load('field'); // Load relasi field
//         return view('admin.schedules.show', compact('schedule'));
//     }

//     public function edit(Schedule $schedule)
//     {
//         $fields = Field::all();
//         return view('admin.schedules.edit', compact('schedule', 'fields'));
//     }

//     public function update(Request $request, Schedule $schedule)
//     {
//         $request->validate([
//             'field_id' => 'required',
//             'date' => 'required|date',
//             'start_time' => 'required',
//             'end_time' => 'required',
//             'is_available' => 'required|boolean',
//         ]);

//         $schedule->update($request->all());

//         return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
//     }

//     public function destroy(Schedule $schedule)
//     {
//         $schedule->delete();
//         return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted successfully.');
//     }
// }

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('field')->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $fields = Field::all();
        return view('admin.schedules.create', compact('fields'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'day' => 'required|in:0,1,2,3,4,5,6',  // 0 = Minggu, 1 = Senin, dst.
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'required|boolean',
        ]);

        // Tentukan hari yang dipilih
        $chosenDay = (int)$request->input('day');
        
        // Cari tanggal berikutnya yang sesuai dengan hari yang dipilih
        $nextDate = Carbon::now()->next($chosenDay)->format('Y-m-d');

        // Membuat jadwal baru
        Schedule::create([
            'field_id' => $request->input('field_id'),
            'date' => $nextDate,  // gunakan tanggal yang dihitung
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'is_available' => $request->input('is_available') ? 1 : 0,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load('field'); // Load relasi field
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $fields = Field::all();
        return view('admin.schedules.edit', compact('schedule', 'fields'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'day' => 'required|in:0,1,2,3,4,5,6',  // 0 = Minggu, 1 = Senin, dst.
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'required|boolean',
        ]);

        // Tentukan hari yang dipilih
        $chosenDay = (int)$request->input('day');
        
        // Hitung tanggal berikutnya untuk hari yang dipilih
        $nextDate = Carbon::now()->next($chosenDay)->format('Y-m-d');

        // Update jadwal yang sudah ada
        $schedule->update([
            'field_id' => $request->input('field_id'),
            'date' => $nextDate,
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'is_available' => $request->input('is_available') ? 1 : 0,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}

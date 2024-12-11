<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Field;
use Illuminate\Http\Request;

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

    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'field_id' => 'required|exists:fields,id',
    //         'day' => 'required|string|max:10',
    //         'start_time' => 'required|date_format:H:i',
    //         'duration' => 'required|integer|min:1', // Validasi durasi
    //         'is_available' => 'required|boolean',
    //     ]);
    
    //     // Hitung end_time berdasarkan start_time dan duration
    //     $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
    //     $endTime = $startTime->copy()->addHours($request->duration); // Tambah durasi dalam jam
    
    //     // Validasi tambahan untuk memastikan tidak ada jadwal tumpang tindih
    //     $existingSchedule = Schedule::where('field_id', $request->field_id)
    //         ->where('day', $request->day)
    //         ->where(function ($query) use ($startTime, $endTime) {
    //             $query->whereBetween('start_time', [$startTime->format('H:i'), $endTime->format('H:i')])
    //                 ->orWhereBetween('end_time', [$startTime->format('H:i'), $endTime->format('H:i')])
    //                 ->orWhereRaw('? BETWEEN start_time AND end_time', [$startTime->format('H:i')])
    //                 ->orWhereRaw('? BETWEEN start_time AND end_time', [$endTime->format('H:i')]);
    //         })
    //         ->exists();
    
    //     if ($existingSchedule) {
    //         return back()->withErrors(['msg' => 'Lapangan sudah terpesan pada jam yang dipilih.'])->withInput();
    //     }
    
    //     // Simpan jadwal baru
    //     Schedule::create([
    //         'field_id' => $request->field_id,
    //         'day' => $request->day,
    //         'start_time' => $startTime->format('H:i'),
    //         'end_time' => $endTime->format('H:i'),
    //         'is_available' => $request->is_available ? 1 : 0,
    //         'is_recurring' => $request->has('is_recurring') ? 1 : 0,
    //     ]);
    
    //     return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    // }

    public function store(Request $request)
    {
        // dd($schedules->toArray()); 
        // Validasi input
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'day' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1', // Validasi durasi
            'is_available' => 'required|boolean',
        ]);
    
        // Hitung end_time berdasarkan start_time dan duration
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = $startTime->copy()->addHours($request->duration); // Tambah durasi dalam jam
    
        // Validasi tambahan untuk memastikan tidak ada jadwal tumpang tindih
        $existingSchedule = Schedule::where('field_id', $request->field_id)
            ->where('day', ucfirst($request->day))  // Pastikan nama hari sesuai dengan format yang disimpan
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                      ->orWhereBetween('end_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                      ->orWhereRaw('? BETWEEN start_time AND end_time', [$startTime->format('H:i')])
                      ->orWhereRaw('? BETWEEN start_time AND end_time', [$endTime->format('H:i')]);
            })
            ->exists();
    
        if ($existingSchedule) {
            return back()->withErrors(['msg' => 'Lapangan sudah terpesan pada jam yang dipilih.'])->withInput();
        }
    
        // Simpan jadwal baru
        Schedule::create([
            'field_id' => $request->field_id,
            'day' => ucfirst($request->day),  // Pastikan format nama hari sesuai dengan yang digunakan di BookingController
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'is_available' => $request->is_available ? 1 : 0,
            'is_recurring' => $request->has('is_recurring') ? 1 : 0,
        ]);
    
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
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
        // Validasi Input
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'day' => 'required|string|max:10|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu', // Tambahkan validasi hari
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'required|boolean',
        ]);
    
        // Validasi Jadwal Tumpang Tindih
        $existingSchedule = Schedule::where('field_id', $request->field_id)
                                    ->where('day', $request->day)
                                    ->where('id', '!=', $schedule->id) // Kecualikan jadwal yang sedang diedit
                                    ->where(function ($query) use ($request) {
                                        $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                                              ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
                                    })
                                    ->exists();
    
        if ($existingSchedule) {
            return back()->withErrors(['msg' => 'Lapangan sudah terpesan pada jam yang dipilih.'])->withInput();
        }
    
        // Perbarui Jadwal
        $schedule->update([
            'field_id' => $request->field_id,
            'day' => $request->day,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_available' => $request->is_available,
            'is_recurring' => $request->has('is_recurring') ? 1 : 0, // Default ke 0 jika tidak diisi
        ]);
    
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }
    

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}

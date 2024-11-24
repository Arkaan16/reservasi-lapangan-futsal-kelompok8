<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Booking</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">
    @vite('resources/css/app.css')

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Content Wrapper -->
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Data Booking</h1>

                <div class="mb-4">
                    <a href="{{ route('admin.bookings.create') }}" class="inline-flex items-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i> Tambah Booking
                    </a>
                </div>

                <div class="w-full mt-6">
                    <div class="bg-white overflow-auto mx-auto rounded-lg" style="max-width: 1200px;">
                        <table class="min-w-full bg-white mx-auto text-center">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Atas Nama Booking</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Nama Pengguna</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Nomor Telepon</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Lapangan</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Tanggal Penyewaan</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Jadwal</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Status</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach($bookings as $booking)
                                <tr class="border-b">
                                    <td class="py-3 px-4">{{ $booking->booking_name }}</td> <!-- Atas Nama Booking -->
                                    <td class="py-3 px-4">{{ $booking->user->name }}</td>
                                    <td class="py-3 px-4">{{ $booking->phone_number }}</td>
                                    <td class="py-3 px-4">{{ $booking->field->name }}</td>
                                    <td class="py-3 px-4">
                                        @if($booking->schedule)
                                            {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d-m-Y') }} <!-- Tanggal Penyewaan -->
                                        @else
                                            Tidak ada jadwal
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($booking->schedule)
                                            {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                                        @else
                                            Tidak ada jadwal
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($booking->status == 'pending')
                                            <span class="text-yellow-500 font-semibold">Pending</span>
                                        @elseif($booking->status == 'comfirmed')
                                            <span class="text-green-500 font-semibold">Confirmed</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="text-blue-500 font-semibold">Completed</span>
                                        @else
                                            <span class="text-red-500 font-semibold">Canceled</span>
                                        @endif
                                    </td>
                                    
                                    
                                    <td class="py-3 px-4 flex justify-center space-x-2">
                                        <!-- Tombol View -->
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye mr-2"></i> View
                                        </a>
                                        
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </a>
                                        
                                        <!-- Tombol Hapus dengan konfirmasi -->
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash-alt mr-2"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>
</html>

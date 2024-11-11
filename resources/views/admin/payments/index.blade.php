<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Booking</title>
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
    @include('layouts.sidebar')

    <!-- Content Wrapper -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h2 class="text-2xl mb-6">Daftar Pembayaran</h2>

        {{-- <a href="{{ route('admin.payments.create', $booking->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Tambah Pembayaran</a>  --}}

        <table class="w-full mt-6 table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Booking ID</th>
                    <th class="px-4 py-2">Durasi Penyewaan</th> <!-- Kolom untuk Durasi Penyewaan -->
                    <th class="px-4 py-2">Jumlah Pembayaran</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Metode Pembayaran</th>
                    <th class="px-4 py-2">Bukti Pembayaran</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $index => $payment)
                    <tr>
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $payment->booking_id }}</td>

                        <!-- Menampilkan Durasi Penyewaan berdasarkan Jadwal -->
                        <td class="px-4 py-2">
                            @if($payment->booking->schedule)
                                @php
                                    $startTime = \Carbon\Carbon::parse($payment->booking->schedule->start_time);
                                    $endTime = \Carbon\Carbon::parse($payment->booking->schedule->end_time);
                                    $duration = $endTime->diffInHours($startTime); // Menghitung durasi dalam jam
                                @endphp
                                {{ $duration }} Jam
                            @else
                                Jadwal tidak tersedia
                            @endif
                        </td>

                        <td class="px-4 py-2">{{ $payment->amount }}</td>
                        <td class="px-4 py-2">{{ ucfirst($payment->status) }}</td>
                        <td class="px-4 py-2">{{ $payment->payment_method }}</td>
                        <td class="px-4 py-2">
                            @if($payment->payment_proof)
                                <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank">Lihat Bukti</a>
                            @else
                                Tidak ada bukti
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.payments.edit', $payment->id) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>

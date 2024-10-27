<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jadwal</title>
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
    @include('layouts.sidebar')

    <!-- Content Wrapper -->
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Detail Jadwal</h1>

                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-2xl font-semibold mb-4">Lapangan: {{ $schedule->field->name }}</h2>
                    
                    <div class="mb-4">
                        <span class="text-gray-700 font-bold">Tanggal: </span>
                        <span class="text-gray-900">{{ $schedule->date }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-gray-700 font-bold">Waktu Mulai: </span>
                        <span class="text-gray-900">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-gray-700 font-bold">Waktu Selesai: </span>
                        <span class="text-gray-900">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-gray-700 font-bold">Ketersediaan: </span>
                        <span class="text-gray-900">
                            @if ($schedule->is_available)
                                <span class="text-green-500">Tersedia</span>
                            @else
                                <span class="text-red-500">Tidak Tersedia</span>
                            @endif
                        </span>
                    </div>

                    <div class="flex space-x-4">
                        <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>
</html>

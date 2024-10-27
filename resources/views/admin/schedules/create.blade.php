<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Lapangan</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
    </style>
</head>

<body class="bg-gray-100 font-family-karla flex">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Content -->
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Tambah Jadwal Lapangan</h1>
                <form action="{{ route('admin.schedules.store') }}" method="POST">
                    @csrf
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                            <label for="field_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Lapangan:</label>
                            <select name="field_id" id="field_id" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">-- Pilih Lapangan --</option>
                                @foreach($fields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal:</label>
                            <input type="date" name="date" id="date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Jam Mulai:</label>
                            <input type="time" name="start_time" id="start_time" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">Jam Selesai:</label>
                            <input type="time" name="end_time" id="end_time" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="is_available" class="block text-gray-700 text-sm font-bold mb-2">Ketersediaan:</label>
                            <select name="is_available" id="is_available" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="1">Tersedia</option>
                                <option value="0">Tidak Tersedia</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
                    </div>
                </form>
            </main>
        </div>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>

</html>

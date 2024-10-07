<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">
    @vite('resources/css/app.css')

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
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

    @include('layouts.sidebar')

    <div class="w-full flex flex-col">
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">Dashboard Admin</h1>

            <!-- Bagian Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Total Pengguna -->
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-600">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-4 rounded-full">
                            <i class="fas fa-users text-blue-600 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Total Pengguna</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $users }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Lapangan -->
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-green-600">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-4 rounded-full">
                            <i class="fas fa-futbol text-green-600 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Total Lapangan</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $fields }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    


    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
</body>
</html>
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Users -->
            <a href="{{ route('admin.users.index') }}" class="block p-6 bg-white rounded-lg shadow-md hover:bg-gray-100">
                <h2 class="text-lg font-bold">Kelola Pengguna</h2>
                <p class="text-sm text-gray-600">Lihat dan kelola data pengguna.</p>
            </a>

            <!-- Fields -->
            <a href="{{ route('admin.fields.index') }}" class="block p-6 bg-white rounded-lg shadow-md hover:bg-gray-100">
                <h2 class="text-lg font-bold">Kelola Lapangan</h2>
                <p class="text-sm text-gray-600">Lihat dan kelola data lapangan.</p>
            </a>

            
        </div>
    </div>
</body>
</html> --}}

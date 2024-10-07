<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
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
    <div class="w-full overflow-x-hidden border-t flex flex-col">
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">Detail User</h1>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                    <p class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $user->name }}</p>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <p class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $user->email }}</p>
                </div>

                {{-- <div class="mb-4">
                    <label for="created_at" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Bergabung:</label>
                    <p class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $user->created_at->format('d-m-Y') }}</p>
                </div> --}}

                <div class="flex justify-end">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md">Kembali</a>
                </div>
            </div>
        </main>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>

</html>

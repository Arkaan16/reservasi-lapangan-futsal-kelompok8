<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
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
                <h1 class="text-3xl text-black pb-6">Data User</h1>

                {{-- <div class="mb-4">
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i> Tambah User
                    </a>
                </div> --}}

                <div class="w-full mt-6">
                    <div class="bg-white overflow-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach($users as $user)
                                <tr>
                                    <td class="w-1/3 text-left py-3 px-4">{{ $user->name }}</td>
                                    <td class="w-1/3 text-left py-3 px-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex space-x-4">
                                        <!-- Tombol View -->
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="flex items-center text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye mr-2"></i> View
                                        </a>
                                        
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="flex items-center text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </a>
                                        
                                        <!-- Tombol Hapus dengan konfirmasi -->
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center text-red-600 hover:text-red-900">
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

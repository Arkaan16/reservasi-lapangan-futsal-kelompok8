<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lapangan</title>
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

    <!-- Content -->
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Data Lapangan</h1>

                <div class="mb-4">
                    <a href="{{ route('admin.fields.create') }}" class="inline-flex items-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i> Tambah Lapangan
                    </a>
                </div>

                <div class="w-full mt-6">
                    <div class="bg-white overflow-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Lokasi</th>
                                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Deskripsi</th>
                                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Foto</th>
                                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Harga</th>
                                    <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach($fields as $field)
                                <tr>
                                    <td class="w-1/4 text-left py-3 px-4">{{ $field->name }}</td>
                                    <td class="w-1/4 text-left py-3 px-4">{{ $field->location }}</td>
                                    <td class="w-1/4 text-left py-3 px-4">{{ $field->description }}</td>
                                    <td class="w-1/4 text-left py-3 px-4">
                                        <img src="{{asset('storage/' . $field->photo) }}" alt="{{ $field->name }}" class="w-20 h-20 object-cover">
                                    </td>
                                    <td class="w-1/4 text-left py-3 px-4">{{ number_format($field->price_per_hour, 2) }}</td>
                                    <td class="w-1/4 text-left py-3 px-4">
                                        <a href="{{ route('admin.fields.show', $field->id) }}" class="flex items-center text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye mr-2"></i> View
                                        </a>
                                        <a href="{{ route('admin.fields.edit', $field->id) }}" class="flex items-center text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?');">
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

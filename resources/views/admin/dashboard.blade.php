@extends('layouts.admin')

@section('title', 'Dashboard Admin | Futsal')

@section('content')
    <div class="flex">
        @include('components.sidebar') <!-- Memanggil Sidebar -->
        <div class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">Dashboard Admin</h1>

            <!-- Konten dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                <!-- Total Jadwal -->
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-yellow-600">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-4 rounded-full">
                            <i class="fas fa-calendar-alt text-yellow-600 text-3xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Total Jadwal</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $schedules }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
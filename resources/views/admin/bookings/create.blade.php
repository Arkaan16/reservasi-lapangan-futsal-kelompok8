<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Booking</title>
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
                <h1 class="text-3xl text-black pb-6">Tambah Booking Baru</h1>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <form action="{{ route('admin.bookings.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Pengguna</label>
                            <select name="user_id" id="user_id" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="booking_name" class="block text-sm font-medium text-gray-700">Nama Pemesan</label>
                            <input type="text" name="booking_name" id="booking_name" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="text" name="phone_number" id="phone_number" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="field_id" class="block text-sm font-medium text-gray-700">Lapangan</label>
                            <select name="field_id" id="field_id" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                                <option value="">Pilih Lapangan</option>
                                @foreach($fields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="schedule_date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" id="schedule_date" name="schedule_date" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                        </div>

                        <!-- <div class="mb-4">
                            <label for="schedule_id" class="block text-sm font-medium text-gray-700">Jadwal</label>
                            <select name="schedule_id" id="schedule_id" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                                <option value="">Pilih Jadwal</option>
                            </select>
                        </div> -->

                        <div>
                            <label for="schedule_id" class="block text-sm font-medium text-gray-700"> Pilih Jadwal</label>
                            <select name="schedule_id" id="schedule_id" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm" required>
                                @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}">{{ $schedule->start_time }} - {{ $schedule->end_time }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i> Simpan Booking
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.getElementById('field_id').addEventListener('change', function() {
            updateSchedules();
        });

        document.getElementById('schedule_date').addEventListener('change', function() {
            updateSchedules();
        });

        function updateSchedules() {
            const fieldId = document.getElementById('field_id').value;
            const date = document.getElementById('schedule_date').value;
            const scheduleSelect = document.getElementById('schedule_id');

            // Kosongkan pilihan jadwal
            scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';

            if (fieldId && date) {
                // Filter jadwal berdasarkan lapangan dan tanggal
                const availableSchedules = @json($schedules).filter(schedule => 
                    schedule.field_id == fieldId && 
                    schedule.date === date && 
                    schedule.is_available
                );

                // Jika ada jadwal yang tersedia
                if (availableSchedules.length > 0) {
                    availableSchedules.forEach(schedule => {
                        const option = document.createElement('option');
                        option.value = schedule.id;
                        option.textContent = `${schedule.start_time} - ${schedule.end_time}`;
                        scheduleSelect.appendChild(option);
                    });
                } else {
                    // Tampilkan pesan jika tidak ada jadwal yang tersedia
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Tidak ada jadwal tersedia';
                    scheduleSelect.appendChild(option);
                }
            }
        }
    </script>

</body>
</html>

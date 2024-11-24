<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Booking</title>

    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

    <div class="w-full max-w-md mx-auto mt-10 bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">Pemesanan Lapangan Futsal</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.bookings.store') }}" method="POST">
            @csrf

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
                <select name="field_id" id="field_id" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Pilih Lapangan</option>
                    @foreach($fields as $field)
                        <option value="{{ $field->id }}">{{ $field->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="schedule_date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" id="schedule_date" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm" required>
            </div>
            
            <div>
                <label for="schedule_id" class="block text-sm font-medium text-gray-700"> Pilih Jadwal</label>
                <select name="schedule_id" id="schedule_id" class="block w-full mt-1 bg-gray-100 border border-gray-300 rounded-md shadow-sm" required>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->id }}">{{ $schedule->start_time }} - {{ $schedule->end_time }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan Booking
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('field_id').addEventListener('change', updateSchedules);
        document.getElementById('schedule_date').addEventListener('change', updateSchedules);

        function updateSchedules() {
            const field_id = document.getElementById('field_id').value;
            const date = document.getElementById('schedule_date').value;
            const scheduleSelect = document.getElementById('schedule_id');

            scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>'; // Clear previous options

            // Pastikan field_id dan date sudah benar
            console.log('Field ID:', field_id);
            console.log('Date:', date);

            if (field_id && date) {
                fetch(`/get-schedules?field_id=${field_id}&date=${date}`)
                    .then(response => {
                        console.log('Response:', response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Schedules:', data);
                        if (data.length > 0) {
                            data.forEach(schedule => {
                                const option = document.createElement('option');
                                option.value = schedule.id;
                                option.textContent = `${schedule.start_time} - ${schedule.end_time}`;
                                scheduleSelect.appendChild(option);
                            });
                        } else {
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'Tidak ada jadwal tersedia';
                            scheduleSelect.appendChild(option);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching schedules:', error);
                    });
            }
        }
    </script>
</body>
</html>

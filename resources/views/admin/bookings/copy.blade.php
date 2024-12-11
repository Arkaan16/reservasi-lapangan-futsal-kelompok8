@extends('layouts.admin')

@section('title', 'Tambah Booking | Futsal')

@section('content')
    <div class="flex">
        @include('components.sidebar') <!-- Sidebar -->

        <div class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">Tambah Booking</h1>

            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf

                <!-- Pilih Lapangan -->
                <div class="mb-4">
                    <label for="field_id" class="block text-sm font-medium text-gray-700">Pilih Lapangan</label>
                    <select name="field_id" id="field_id" class="mt-1 block w-full" required>
                        <option value="">Pilih Lapangan</option>
                        @foreach($fields as $field)
                            <option value="{{ $field->id }}">{{ $field->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Tanggal -->
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Pilih Tanggal</label>
                    <input type="date" name="date" id="date" class="mt-1 block w-full" required>
                </div>

                <!-- Input Waktu Mulai -->
                <div class="mb-4">
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                    <input type="time" name="start_time" id="start_time" class="mt-1 block w-full" required>
                </div>

                <!-- Pilih Durasi -->
                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700">Durasi (jam)</label>
                    <select name="duration" id="duration" class="mt-1 block w-full" required>
                        <option value="">Pilih Durasi</option>
                        <option value="1">1 Jam</option>
                        <option value="2">2 Jam</option>
                        <option value="3">3 Jam</option>
                        <option value="4">4 Jam</option>
                    </select>
                </div>

                <!-- Pilih Jadwal -->
                <div class="mb-4">
                    <label for="schedule_id" class="block text-sm font-medium text-gray-700">Jadwal Tersedia</label>
                    <select name="schedule_id" id="schedule_id" class="mt-1 block w-full" required>
                        <option value="">Pilih Jadwal</option>
                    </select>
                </div>

                <!-- Total Harga -->
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Total Harga</label>
                    <input type="text" id="price" name="price" class="mt-1 block w-full" readonly>
                </div>

                <!-- Nama Pemesan -->
                <div class="mb-4">
                    <label for="booking_name" class="block text-sm font-medium text-gray-700">Nama Pemesan</label>
                    <input type="text" name="booking_name" id="booking_name" class="mt-1 block w-full" required>
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" name="phone_number" id="phone_number" class="mt-1 block w-full" required>
                </div>

                <button type="submit" class="btn btn-primary">Buat Booking</button>
            </form>
        </div>
    </div>

    <script>
        const fieldSelect = document.getElementById('field_id');
        const dateInput = document.getElementById('date');
        const startTimeInput = document.getElementById('start_time');
        const durationSelect = document.getElementById('duration');
        const scheduleSelect = document.getElementById('schedule_id');
        const priceInput = document.getElementById('price');

        function updateSchedulesAndPrice() {
            const fieldId = fieldSelect.value;
            const date = dateInput.value;
            const startTime = startTimeInput.value;
            const duration = durationSelect.value;

            if (fieldId && date && startTime && duration) {
                // Fetch available schedules
                fetch(`/admin/bookings/getAvailableSchedules?field_id=${fieldId}&date=${date}&start_time=${startTime}&duration=${duration}`)
                    .then(response => response.json())
                    .then(data => {
                        scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';

                        if (data.length > 0) {
                            data.forEach(schedule => {
                                const option = document.createElement('option');
                                option.value = schedule.id;
                                option.textContent = `${schedule.day} - ${schedule.start_time} - ${schedule.end_time}`;
                                scheduleSelect.appendChild(option);
                            });
                            scheduleSelect.disabled = false;
                        } else {
                            const option = document.createElement('option');
                            option.textContent = 'Tidak ada jadwal tersedia';
                            scheduleSelect.appendChild(option);
                            scheduleSelect.disabled = true;
                        }
                    })
                    .catch(error => console.error('Error fetching schedules:', error));

                // Calculate total price
                fetch(`/admin/bookings/calculatePrice?field_id=${fieldId}&duration=${duration}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            priceInput.value = `Rp ${data.total_price.toLocaleString('id-ID')}`;
                        }
                    })
                    .catch(error => console.error('Error calculating price:', error));
            }
        }

        fieldSelect.addEventListener('change', updateSchedulesAndPrice);
        dateInput.addEventListener('change', updateSchedulesAndPrice);
        startTimeInput.addEventListener('change', updateSchedulesAndPrice);
        durationSelect.addEventListener('change', updateSchedulesAndPrice);
    </script>
@endsection

@extends('layouts.admin')

@section('title', 'Tambah Booking | Futsal')

@section('content')
    <div class="flex">
        @include('components.sidebar') <!-- Sidebar -->

        <!-- Content Wrapper -->
        <div class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">Tambah Booking</h1>

            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf

                <!-- Pilih Lapangan -->
                <div class="mb-4">
                    <label for="field_id" class="block text-sm font-medium text-gray-700">Pilih Lapangan</label>
                    <select name="field_id" id="field_id" class="mt-1 block w-full">
                        <option value="">Pilih Lapangan</option>
                        @foreach($fields as $field)
                            <option value="{{ $field->id }}" data-price="{{ $field->price_per_hour }}">
                                {{ $field->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Durasi -->
                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700">Pilih Durasi (jam)</label>
                    <select name="duration" id="duration" class="mt-1 block w-full">
                        <option value="">Pilih Durasi</option>
                        <option value="1">1 Jam</option>
                        <option value="2">2 Jam</option>
                        <option value="3">3 Jam</option>
                        <option value="4">4 Jam</option>
                    </select>
                </div>

                <!-- Pilih Tanggal -->
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Pilih Tanggal</label>
                    <input type="date" name="date" id="date" class="mt-1 block w-full" required>
                </div>

                <!-- Pilih Jadwal -->
                <div class="mb-4">
                    <label for="schedule_id" class="block text-sm font-medium text-gray-700">Pilih Jadwal</label>
                    <select name="schedule_id" id="schedule_id" class="mt-1 block w-full">
                        <option value="">Pilih Jadwal</option>
                    </select>
                </div>

                <!-- Total Harga -->
                <div class="mb-4">
                    <label for="display_total_price" class="block text-sm font-medium text-gray-700">Total Harga</label>
                    <input type="text" id="display_total_price" class="mt-1 block w-full" readonly>
                    <!-- Input hidden untuk mengirim total_price -->
                    <input type="hidden" name="total_price" id="total_price">
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
    // Fungsi untuk menghitung total harga
    function calculateTotalPrice() {
        const fieldSelect = document.getElementById('field_id');
        const durationSelect = document.getElementById('duration');
        const displayTotalPriceInput = document.getElementById('display_total_price');
        const totalPriceInput = document.getElementById('total_price');

        // Ambil harga per jam dari atribut data-price
        const selectedField = fieldSelect.options[fieldSelect.selectedIndex];
        const pricePerHour = selectedField ? selectedField.dataset.price : null;
        const duration = durationSelect.value;

        if (pricePerHour && duration) {
            const totalPrice = pricePerHour * duration; // Hitung total harga
            const formattedPrice = `Rp ${parseInt(totalPrice).toLocaleString('id-ID')}`; // Format ke Rupiah

            // Tampilkan harga di kolom readonly
            displayTotalPriceInput.value = formattedPrice;

            // Set nilai total_price untuk form
            totalPriceInput.value = totalPrice;
        } else {
            // Reset jika salah satu belum dipilih
            displayTotalPriceInput.value = '';
            totalPriceInput.value = '';
        }
    }

    // Fungsi untuk fetch jadwal
    function fetchSchedules() {
        let date = document.getElementById('date').value;
        let field_id = document.getElementById('field_id').value;
        let duration = document.getElementById('duration').value;

        if (date && field_id && duration) {
            let scheduleSelect = document.getElementById('schedule_id');
            scheduleSelect.innerHTML = '<option value="">Loading...</option>';

            fetch(`/admin/bookings/getSchedules?date=${date}&field_id=${field_id}&duration=${duration}`)
                .then(response => response.json())
                .then(data => {
                    scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';
                    if (data.length > 0) {
                        data.forEach(schedule => {
                            let option = document.createElement('option');
                            option.value = schedule.id;
                            option.textContent = `${schedule.day} - ${schedule.start_time} - ${schedule.end_time}`;
                            scheduleSelect.appendChild(option);
                        });
                    } else {
                        let option = document.createElement('option');
                        option.textContent = 'Tidak ada jadwal tersedia';
                        option.disabled = true;
                        scheduleSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error fetching schedules:', error);
                    scheduleSelect.innerHTML = '<option value="">Error loading schedules</option>';
                });
        }
    }

    // Event listener untuk kalkulasi total harga dan fetch jadwal
    document.getElementById('field_id').addEventListener('change', () => {
        calculateTotalPrice();
        fetchSchedules();
    });
    document.getElementById('duration').addEventListener('change', () => {
        calculateTotalPrice();
        fetchSchedules();
    });
    document.getElementById('date').addEventListener('change', fetchSchedules);

    // Pastikan total_price terisi saat pertama kali
    calculateTotalPrice();
</script>


@endsection

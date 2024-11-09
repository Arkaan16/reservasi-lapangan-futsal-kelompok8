<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Booking</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
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

    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Content Wrapper -->
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Tambah Booking</h1>

                <form action="{{ route('admin.bookings.store') }}" method="POST" enctype="multipart/form-data"> <!-- Tambahkan enctype -->
                    @csrf
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label for="user_id" class="block text-gray-700">User</label>
                            <select name="user_id" id="user_id" required class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50">
                                <option value="">Pilih User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="field_id" class="block text-gray-700">Lapangan</label>
                            <select name="field_id" id="field_id" required class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" onchange="updateSchedule()">
                                <option value="">Pilih Lapangan</option>
                                @foreach($fields as $field)
                                    <option value="{{ $field->id }}" data-price="{{ $field->price_per_hour }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="date" class="block text-gray-700">Tanggal</label>
                            <input type="date" name="date" id="date" required class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" onchange="updateSchedule()">
                        </div>

                        <div>
                            <label for="schedule_id" class="block text-gray-700">Jadwal Tersedia</label>
                            <select name="schedule_id" id="schedule_id" required class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50">
                                <option value="">Pilih Jadwal</option>
                            </select>
                        </div>

                        <div>
                            <label for="booking_name" class="block text-gray-700">Nama Booking</label>
                            <input type="text" name="booking_name" id="booking_name" required class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="phone_number" class="block text-gray-700">Nomor Telepon</label>
                            <input type="text" name="phone_number" id="phone_number" required class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="duration" class="block text-gray-700">Durasi (jam)</label>
                            <input type="number" name="duration" id="duration" value="1" min="1" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" onchange="updateAmount()">
                        </div>

                        <div>
                            <label for="amount" class="block text-gray-700">Jumlah Pembayaran</label>
                            <input type="number" name="amount" id="amount" required readonly class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="payment_method" class="block text-gray-700">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method" required class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" onchange="toggleBankDetails()">
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="bayar_langsung">Bayar Langsung</option>
                                <option value="transfer_bni">Transfer Bank BNI</option>
                            </select>
                        </div>
                    </div>

                    <!-- Informasi Bank -->
                    <div id="bank-details" class="hidden mt-4 p-4 bg-blue-50 border border-blue-200 rounded">
                        <h2 class="font-bold text-blue-600">Transfer Bank BNI</h2>
                        <img src="/assets/img/bank.png" alt="Logo BNI" class="h-10">
                        <p>Nomor Rekening: 123-456-789</p>
                        <div>
                            <label for="payment_proof" class="block text-gray-700">Bukti Pembayaran</label>
                            <input type="file" name="payment_proof" id="payment_proof" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50">
                        </div>
                    </div>

                    <button type="submit" class="mt-6 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Buat Booking</button>
                </form>
            </main>
        </div>
    </div>

    <script>
        const schedules = @json($schedules); // Mengambil data jadwal dari server

        function updateSchedule() {
            const fieldId = document.getElementById('field_id').value;
            const date = document.getElementById('date').value;
            const scheduleSelect = document.getElementById('schedule_id');

            // Kosongkan pilihan jadwal
            scheduleSelect.innerHTML = '<option value="">Pilih Jadwal</option>';

            if (fieldId && date) {
                // Filter jadwal berdasarkan lapangan dan tanggal
                const availableSchedules = schedules.filter(schedule => 
                    schedule.field_id == fieldId && 
                    schedule.date === date && 
                    schedule.is_available // Pastikan status ketersediaan
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

            updateAmount(); // Memperbarui jumlah pembayaran setiap kali jadwal diperbarui
        }

        function updateAmount() {
            const fieldSelect = document.getElementById('field_id');
            const duration = document.getElementById('duration').value;
            const amountInput = document.getElementById('amount');

            if (fieldSelect.selectedIndex > 0 && duration) {
                const selectedField = fieldSelect.options[fieldSelect.selectedIndex];
                const pricePerHour = selectedField.getAttribute('data-price');
                const amount = pricePerHour * duration;
                amountInput.value = amount; // Mengatur nilai jumlah pembayaran
            } else {
                amountInput.value = ''; // Reset nilai jika tidak ada lapangan atau durasi
            }
        }

        function toggleBankDetails() {
            const paymentMethod = document.getElementById('payment_method').value;
            const bankDetailsDiv = document.getElementById('bank-details');

            if (paymentMethod === 'transfer_bni') {
                bankDetailsDiv.classList.remove('hidden');
            } else {
                bankDetailsDiv.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
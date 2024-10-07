<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pemesanan Lapangan Futsal</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <!-- resources/views/bookings/create.blade.php -->

    <div class="container mx-auto p-6">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-8">Pemesanan Lapangan Futsal</h1>

            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilih Lapangan -->
                <div>
                    <label for="field_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Lapangan</label>
                    <select name="field_id" id="field_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Pilih Lapangan</option>
                        @foreach ($fields as $field)
                        <option value="{{ $field->id }}">{{ $field->name }} - Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Pemesanan -->
                <div>
                    <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pemesanan</label>
                    <input type="date" name="booking_date" id="booking_date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Waktu Mulai -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Waktu Mulai</label>
                    <input type="time" name="start_time" id="start_time" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Waktu Selesai -->
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">Waktu Selesai</label>
                    <input type="time" name="end_time" id="end_time" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="transfer">Transfer Bank</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300">Pesan Sekarang</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>

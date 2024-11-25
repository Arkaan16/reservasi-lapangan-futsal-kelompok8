@extends('layouts.landing')

@section('title', 'Riwayat Booking | Futsal')

@section('content')
@include('components.navbar')

<div class="flex flex-col p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Riwayat Booking</h1>

    <!-- Container Card Riwayat Booking -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($bookings as $booking)
        <div class="bg-white rounded-lg shadow-md p-4">
            <!-- Header Card -->
            <div class="mb-2">
                <h2 class="text-lg font-semibold text-gray-700">{{ $booking->field->name }}</h2>
                <p class="text-sm text-gray-500">
                    Tanggal Jadwal : {{ $booking->schedule->date }} <br>
                    Jam Mulai & Jam Selesai : ({{\Carbon\Carbon::parse ($booking->schedule->start_time)->format('H:i') }} s/d {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }})
                </p>
            </div>

            <!-- Detail Booking -->
            <div class="mb-4 space-y-2">
                <p class="text-gray-600"><span class="font-medium">Atas Nama:</span> {{ $booking->booking_name }}</p>
                <p class="text-gray-600"><span class="font-medium">No Telepon:</span> {{ $booking->phone_number }}</p>
                <p class="text-gray-600"><span class="font-medium">Harga:</span> Rp{{ number_format($booking->field->price_per_hour, 0, ',', '.') }} / jam</p>
                <p class="text-gray-600"><span class="font-medium">Status:</span> 
                    @if($booking->payment && $booking->payment->status == 'paid')
                        <span class="text-green-500 font-semibold">Sudah Dibayar</span>
                    @else
                        <span class="text-red-500 font-semibold">Belum Dibayar</span>
                    @endif
                </p>
            </div>

            <!-- Tombol Aksi Pembayaran -->
            @if($booking->status == 'pending' && (!$booking->payment || $booking->payment->status != 'paid'))
                <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg" onclick="openPaymentModal({{ $booking->id }})">
                    Bayar Sekarang
                </button>
            @elseif($booking->status == 'canceled')
                <button disabled class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
                    Booking Dibatalkan
                </button>
            @elseif($booking->payment && $booking->payment->status == 'paid')
                <button disabled class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
                    Sudah Dibayar
                </button>
            @endif


            <!-- Tombol Batalkan Pemesanan -->
            @if($booking->status == 'pending' && (!$booking->payment || $booking->payment->status == 'pending'))
                <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('POST') <!-- Pastikan metode POST digunakan -->
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded-lg">
                        Batalkan Booking
                    </button>
                </form>
            @endif

        </div>
        @endforeach
    </div>
</div>

<!-- Modal Pilih Metode Pembayaran -->
<div id="paymentModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-semibold mb-4">Pilih Metode Pembayaran</h2>
        <form action="{{ route('user.payments.store', $booking->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="booking_id" id="booking_id">
            <div class="mb-4">
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none">
                    <option value="cash">Cash (Bayar Langsung)</option>
                    <option value="transfer">Transfer ke Bank</option>
                </select>
            </div>

            <div id="bank_details_section" class="mb-4 hidden">
                <h2 class="font-bold text-blue-600">Transfer Bank BNI</h2>
                <p>Nomor Rekening: 123-456-789</p>
                <div class="mt-4">
                    <label for="payment_proof" class="block text-gray-700">Upload Bukti Pembayaran</label>
                    <input type="file" name="payment_proof" id="payment_proof" accept="image/*" class="mt-1 block w-full">
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">Simpan Pembayaran</button>
                <button type="button" onclick="closePaymentModal()" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded-lg">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk membuka modal
    function openPaymentModal(bookingId) {
        document.getElementById('booking_id').value = bookingId;
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    // Fungsi untuk toggle bagian detail bank
    document.querySelectorAll('select[name="payment_method"]').forEach(function (element) {
        element.addEventListener('change', function () {
            const bankDetailsSection = document.getElementById('bank_details_section');
            if (this.value === 'transfer') {
                bankDetailsSection.classList.remove('hidden');
            } else {
                bankDetailsSection.classList.add('hidden');
            }
        });
    });
</script>
@include('components.footer')

@endsection

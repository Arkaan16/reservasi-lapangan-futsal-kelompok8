<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Status Booking</title>
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

    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Edit Status Booking</h1>

                @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Pilih Pengguna</label>
                        <select name="user_id" id="user_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $booking->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="field_id" class="block text-sm font-medium text-gray-700">Pilih Lapangan</label>
                        <select name="field_id" id="field_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @foreach($fields as $field)
                                <option value="{{ $field->id }}" {{ $field->id == $booking->field_id ? 'selected' : '' }}>{{ $field->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="schedule_id" class="block text-sm font-medium text-gray-700">Pilih Jadwal</label>
                        <select name="schedule_id" id="schedule_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @foreach($schedules as $schedule)
                                <option value="{{ $schedule->id }}" {{ $schedule->id == $booking->schedule_id ? 'selected' : '' }}>{{ $schedule->date_time }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="booking_name" class="block text-sm font-medium text-gray-700">Nama Pemesan</label>
                        <input type="text" name="booking_name" id="booking_name" value="{{ old('booking_name', $booking->booking_name) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <div class="mb-4">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $booking->phone_number) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', $booking->payment->amount) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <div class="mb-4">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="cash" {{ $booking->payment->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="credit_card" {{ $booking->payment->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <!-- Tambahkan metode pembayaran lainnya sesuai kebutuhan -->
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Pembayaran (opsional)</label>
                        <input type="file" name="payment_proof" id="payment_proof" class="mt-1 block w-full text-sm text-gray-500 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                        <select name="status" id="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="pending" {{ $booking->payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->payment->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="completed" {{ $booking->payment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ $booking->payment->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>

                    <button type="submit" class="mt-4 w-full bg-blue-500 text-white font-semibold py-2 rounded-md hover:bg-blue-600">Update</button>
                </form>
                
            </main>
        </div>
    </div>

</body>
</html>

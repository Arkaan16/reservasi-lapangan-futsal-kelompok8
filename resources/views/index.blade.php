<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    @vite('resources/css/app.css')
</head>
<body>
    <nav class="flex flex-wrap items-center justify-between p-3 bg-[#e8e8e5]">
        <div class="flex items-center">
            <img src="/assets/img/logof.png" alt="Logo" class="h-10 mr-3"> <!-- Menambahkan logo -->
            <div class="text-xl">Wolf Field</div>
        </div>
        <div class="flex md:hidden">
            <button id="hamburger">
                <img class="toggle block" src="https://img.icons8.com/fluent-systems-regular/2x/menu-squared-2.png" width="40" height="40" />
                <img class="toggle hidden" src="https://img.icons8.com/fluent-systems-regular/2x/close-window.png" width="40" height="40" />
            </button>
        </div>
        <div class="toggle hidden w-full md:w-auto md:flex text-right text-bold mt-5 md:mt-0 md:border-none">
            <a href="#home" class="block md:inline-block hover:text-blue-500 px-3 py-3 md:border-none">Beranda</a>
            <a href="#aboutus" class="block md:inline-block hover:text-blue-500 px-3 py-3 md:border-none">Tentang Kami</a>
            <a href="#fields" class="block md:inline-block hover:text-blue-500 px-3 py-3 md:border-none">Lapangan</a>
            <a href="#layanan" class="block md:inline-block hover:text-blue-500 px-3 py-3 md:border-none">Layanan</a>
            <a href="#contactUs" class="block md:inline-block hover:text-blue-500 px-3 py-3 md:border-none">Lokasi</a>
        </div>
    
        <div class="toggle w-full text-end hidden md:flex md:w-auto px-2 py-2 md:rounded">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center h-10 w-30 rounded-md bg-blue-500 hover:bg-blue-700 text-white font-medium p-2">
                        Log Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex items-center h-10 w-30 rounded-md bg-blue-500 hover:bg-blue-700 text-white font-medium p-2">
                    Log In
                </a>
            @endauth
        </div>
    </nav>
    

    <div class="bg-cover bg-center h-screen" style="background-image: url('/assets/img/lapanganfutsal.jpg');">
        <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Reservasi Lapangan Futsal</h1>
                <p class="text-lg md:text-xl mb-6">Pesan lapangan futsal dengan mudah, cepat, dan aman.</p>
                <a href="#fields" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full text-lg">Lihat Lapangan</a>
            </div>
        </div>
    </div>

    <!-- about us -->
    <section class="bg-gray-100" id="aboutus">
        <div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
                <div class="max-w-lg">
                    <h2 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Tentang Kami</h2>
                    <p class="mt-4 text-gray-600 text-lg">
                        Sistem Reservasi Lapangan Futsal kami hadir untuk memberikan pengalaman bermain futsal terbaik bagi semua penggemar olahraga. 
                        Kami menawarkan berbagai lapangan futsal dengan fasilitas modern dan lokasi strategis. Tujuan kami adalah memberikan kemudahan bagi 
                        Anda dalam melakukan reservasi lapangan secara cepat dan efisien. Kami berkomitmen untuk menyediakan layanan pelanggan yang luar biasa, 
                        dengan tim yang siap membantu menjawab pertanyaan dan memberikan informasi yang Anda butuhkan. Selain harga yang kompetitif, kami memastikan 
                        transparansi dalam setiap transaksi, sehingga Anda bisa merasa aman saat melakukan reservasi. Dengan dukungan terhadap komunitas futsal lokal 
                        melalui turnamen dan acara, kami percaya bahwa olahraga bisa mempererat hubungan antar pemain. Jika Anda mencari layanan reservasi lapangan 
                        futsal yang terpercaya dan berkualitas, Anda telah berada di tempat yang tepat. Kami menantikan kesempatan untuk melayani Anda!
                    </p>
                </div>
                <div class="mt-12 md:mt-0">
                    <img src="https://images.unsplash.com/photo-1531973576160-7125cd663d86" alt="About Us Image" class="object-cover rounded-lg shadow-md">
                </div>
            </div>
        </div>
    </section>

    <!-- Lapangan Tersedia -->
    <div class="container mx-auto py-12">
        <h2 class="text-3xl font-extrabold text-center mb-12" id="fields">Lapangan Tersedia</h2>
    
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @if(isset($fields) && $fields->isNotEmpty())
                @foreach($fields as $field)
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $field->photo) }}" alt="{{ $field->name }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold">{{ $field->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $field->location }}</p>
                            <p class="text-gray-600">{{ $field->description }}</p>
                            <p class="text-blue-600 font-bold mt-4">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }} / jam</p>
                            {{-- {{ route('reservasi.create', $field->id) }} --}}
                            @auth
                                <a href="#" class="mt-4 block bg-blue-500 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded">
                                    Pesan Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="mt-4 block bg-blue-500 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded">
                                    Pesan Sekarang
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            @else
                <p>Tidak ada lapangan yang tersedia.</p>
            @endif
        </div>
    </div>
    

    <!-- Informasi Layanan -->
    <div class="bg-gray-100 py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-extrabold mb-8" id="layanan">Kenapa Pilih Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="p-10 bg-white shadow-lg rounded-lg transition-transform transform hover:scale-105">
                    <svg class="w-16 h-16 mx-auto mb-4 text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12 0 3.31 1.366 6.293 3.515 8.484l-.389 2.916 2.916-.389c2.191 2.149 5.174 3.515 8.484 3.515 6.627 0 12-5.373 12-12s-5.373-12-12-12zm1 19h-2v-2h2v2zm1.83-7.78l-.67.67c-.66.66-1.16 1.17-1.33 2.11-.07.39-.39.68-.79.68h-2c-.45 0-.82-.39-.74-.84.19-1.16.76-2.08 1.58-2.9l1-1c.39-.39.57-.97.47-1.54-.14-.67-.73-1.15-1.42-1.15-.77 0-1.39.63-1.39 1.39v.11c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-.11c0-2.21 1.79-4 4-4 1.97 0 3.61 1.41 3.96 3.32.3 1.45-.11 2.91-1.12 3.91z"/></svg>
                    <h3 class="text-2xl font-bold mb-2">Mudah & Cepat</h3>
                    <p class="text-lg text-gray-600">Proses reservasi lapangan futsal kami mudah dan cepat, hanya dengan beberapa klik.</p>
                </div>
                <div class="p-10 bg-white shadow-lg rounded-lg transition-transform transform hover:scale-105">
                    <svg class="w-16 h-16 mx-auto mb-4 text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12 0 3.31 1.366 6.293 3.515 8.484l-.389 2.916 2.916-.389c2.191 2.149 5.174 3.515 8.484 3.515 6.627 0 12-5.373 12-12s-5.373-12-12-12zm1 19h-2v-2h2v2zm1.83-7.78l-.67.67c-.66.66-1.16 1.17-1.33 2.11-.07.39-.39.68-.79.68h-2c-.45 0-.82-.39-.74-.84.19-1.16.76-2.08 1.58-2.9l1-1c.39-.39.57-.97.47-1.54-.14-.67-.73-1.15-1.42-1.15-.77 0-1.39.63-1.39 1.39v.11c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-.11c0-2.21 1.79-4 4-4 1.97 0 3.61 1.41 3.96 3.32.3 1.45-.11 2.91-1.12 3.91z"/></svg>
                    <h3 class="text-2xl font-bold mb-2">Jaminan Lapangan</h3>
                    <p class="text-lg text-gray-600">Kami menjamin lapangan yang dipesan tersedia sesuai dengan waktu yang dipilih.</p>
                </div>
                <div class="p-10 bg-white shadow-lg rounded-lg transition-transform transform hover:scale-105">
                    <svg class="w-16 h-16 mx-auto mb-4 text-blue-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12 0 3.31 1.366 6.293 3.515 8.484l-.389 2.916 2.916-.389c2.191 2.149 5.174 3.515 8.484 3.515 6.627 0 12-5.373 12-12s-5.373-12-12-12zm1 19h-2v-2h2v2zm1.83-7.78l-.67.67c-.66.66-1.16 1.17-1.33 2.11-.07.39-.39.68-.79.68h-2c-.45 0-.82-.39-.74-.84.19-1.16.76-2.08 1.58-2.9l1-1c.39-.39.57-.97.47-1.54-.14-.67-.73-1.15-1.42-1.15-.77 0-1.39.63-1.39 1.39v.11c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-.11c0-2.21 1.79-4 4-4 1.97 0 3.61 1.41 3.96 3.32.3 1.45-.11 2.91-1.12 3.91z"/></svg>
                    <h3 class="text-2xl font-bold mb-2">Pembayaran Aman</h3>
                    <p class="text-lg text-gray-600">Kami menyediakan metode pembayaran yang aman dan dapat dipercaya.</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Visit us section -->
    <section class="bg-white">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:py-20 lg:px-8">
            <div class="max-w-2xl lg:max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-extrabold text-gray-900" id="contactUs">Lokasi Kami</h2>
                {{-- <p class="mt-3 text-lg text-gray-500">Let us serve you the best</p> --}}
            </div>
            <div class="mt-8 lg:mt-20">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <div class="max-w-full mx-auto rounded-lg overflow-hidden">
                            <div class="border-t border-gray-200 px-6 py-4">
                                <h3 class="text-lg font-bold text-gray-900">Kontak</h3>
                                <p class="mt-1 font-bold text-gray-600"><a href="tel:+123">Phone: +62
                                        123456789</a></p>
                                <a class="flex m-1" href="tel:+919823331842">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="flex items-center justify-between h-10 w-30 rounded-md bg-blue-500 hover:bg-blue-700 text-white p-2">
                                            <!-- Heroicon name: phone -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                            </svg>
                                            Hubungi Sekarang
                                        </div>
                                    </div>

                                </a>
                            </div>
                            <div class="border-t border-gray-200 px-6 py-4">
                                <h3 class="text-lg font-medium text-gray-900">Alamat Kami</h3>
                                <p class="mt-1 text-gray-600">Jl. Pelita I, Labuhan Ratu, Kec. Kedaton, Kota Bandar Lampung, Lampung 35132</p>
                            </div>
                            <div class="border-t border-gray-200 px-6 py-4">
                                <h3 class="text-lg font-medium text-gray-900">Jam Operasional</h3>
                                <p class="mt-1 text-gray-600">Senin - Minggu : 07.00 Pagi - 22.00 Malam</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-lg overflow-hidden order-none sm:order-first">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.265900084063!2d105.25315567352052!3d-5.376367153772092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40dad012055e95%3A0x34e5c1b61b87c43b!2sGedung%20Futsal%20Srikandi!5e0!3m2!1sid!2sid!4v1730074072695!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            class="w-full" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Sistem Reservasi Lapangan Futsal. Semua hak dilindungi.</p>
        </div>
    </footer>
</body>
</html>
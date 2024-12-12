<p align="center">
  <a href="#">
    <img src="public/assets/img/logof.png" alt="Logo Wolf Field" height="128">
    <h1 align="center">Wolf Field - Sistem Reservasi Lapangan Futsal</h1>
  </a>
</p>

Wolf Field adalah aplikasi berbasis web yang memudahkan pengguna dalam melakukan reservasi lapangan futsal. Aplikasi ini dilengkapi dengan berbagai fitur untuk manajemen lapangan, pemesanan, pembayaran, serta riwayat reservasi yang dapat diakses oleh admin dan pengguna.

---

## Fitur

### Fitur Admin
- **Manajemen Lapangan**: Admin dapat mengelola data lapangan futsal seperti nama, lokasi, deskripsi, foto, dan harga per jam.
- **Jadwal Reservasi**: Admin dapat melihat dan mengelola jadwal reservasi lapangan.
- **Manajemen Pengguna**: Admin dapat melihat dan mengelola data pengguna.
- **Laporan Pembayaran**: Admin dapat melihat laporan pembayaran yang telah dilakukan oleh pengguna.

### Fitur Pengguna
- **Daftar Lapangan**: Pengguna dapat melihat daftar lapangan futsal yang tersedia.
- **Reservasi Lapangan**: Pengguna dapat melakukan reservasi lapangan dengan memilih jadwal yang diinginkan.
- **Riwayat Reservasi**: Pengguna dapat melihat riwayat reservasi yang telah dilakukan.
- **Pembayaran**: Pengguna dapat melakukan pembayaran untuk reservasi yang dilakukan melalui metode yang tersedia.

---

## Prasyarat

Sebelum memulai, pastikan Anda telah memenuhi persyaratan berikut:
- PHP >= 8.0
- Composer
- Laravel 10
- MySQL atau database lain yang didukung Laravel
- Node.js (untuk pengelolaan assets dan frontend)

---

## Instalasi

### 1. Clone Repository
Clone repository Wolf Field ke dalam direktori lokal Anda:
```bash
git clone https://github.com/username/wolf-field.git
```


### 2. Instal Dependensi
Masuk ke direktori proyek dan install dependensi menggunakan Composer:
```bash
cd wolf-field
composer install
```

Install dependensi frontend menggunakan npm:
```bash
npm install
```

### 3. Konfigurasi .env
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Kunci Aplikasi
Jalankan perintah berikut untuk menghasilkan kunci aplikasi:
```bash
php artisan key:generate
```

### 5. Migrasi dan Seeding Database
Jalankan migrasi untuk membuat tabel-tabel yang diperlukan di database:
```bash
php artisan migrate
```

Jika Anda ingin mengisi database dengan data dummy, jalankan:
```bash
php artisan db:seed
```

### 6. Menjalankan Aplikasi
Jalankan server lokal menggunakan Artisan:
```bash
php artisan serve
```
Akses aplikasi di browser pada `http://localhost:8000`.

---

## Penggunaan

### 1. Registrasi dan Login
Pengguna dapat melakukan registrasi dan login menggunakan email dan password. Admin dapat mengelola pengguna melalui dashboard yang tersedia.

### 2. Reservasi Lapangan
Pengguna dapat memilih lapangan futsal yang tersedia, melihat harga per jam, dan melakukan reservasi dengan memilih jadwal yang diinginkan.

### 3. Pembayaran
Setelah melakukan reservasi, pengguna dapat melakukan pembayaran melalui metode yang tersedia.

---

## Teknologi yang Digunakan
- **Backend**: Laravel 10
- **Frontend**: Tailwind CSS, Blade
- **Database**: MySQL
- **Queue**: Laravel Queues untuk pemrosesan background

---

## Kontribusi

Terima kasih telah mempertimbangkan untuk berkontribusi pada proyek ini! Anda dapat mengajukan pull request untuk meningkatkan aplikasi ini. Pastikan untuk mengikuti pedoman kontribusi yang ada dalam [dokumen kontribusi Laravel](https://laravel.com/docs/contributions).

---

## Lisensi

Wolf Field menggunakan lisensi **MIT**. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---

## Kontak

Jika Anda memiliki pertanyaan atau saran, silakan hubungi kami melalui email di: `support@wolf-field.com`.
```

README ini sudah disusun dengan lebih rapi, jelas, dan terstruktur agar memudahkan pemahaman pembaca tentang aplikasi, fitur-fitur yang disediakan, dan instruksi penggunaannya. Pastikan untuk mengganti informasi yang relevan seperti URL repositori dan email kontak sesuai dengan kebutuhan Anda.

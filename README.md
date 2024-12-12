Berikut adalah template README.md untuk aplikasi **Wolf Field - Sistem Reservasi Lapangan Futsal** yang sudah digabungkan dalam satu halaman:

```markdown
# Wolf Field - Sistem Reservasi Lapangan Futsal

Wolf Field adalah aplikasi berbasis web untuk memudahkan pengguna dalam melakukan reservasi lapangan futsal. Aplikasi ini dilengkapi dengan berbagai fitur untuk manajemen lapangan, pemesanan, pembayaran, serta riwayat reservasi yang dapat diakses oleh admin dan pengguna.

## Fitur

### 1. **Fitur Admin**
- Manajemen data lapangan futsal (nama, lokasi, deskripsi, foto, harga per jam).
- Melihat jadwal reservasi lapangan.
- Mengelola data pengguna.
- Melihat laporan pembayaran.

### 2. **Fitur Pengguna**
- Melihat daftar lapangan futsal yang tersedia.
- Melakukan reservasi lapangan.
- Melihat riwayat reservasi.
- Melakukan pembayaran untuk reservasi yang dilakukan.

## Prasyarat

Sebelum memulai, pastikan Anda memiliki hal-hal berikut:
- PHP >= 8.0
- Composer
- Laravel 10
- MySQL atau database lain yang didukung Laravel
- Node.js (untuk pengelolaan assets dan frontend)

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

Buka file `.env` dan sesuaikan konfigurasi database, seperti berikut:
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

## Penggunaan

### 1. Registrasi dan Login
Pengguna dapat melakukan registrasi dan login menggunakan email dan password. Admin dapat mengelola pengguna melalui dashboard.

### 2. Reservasi Lapangan
Pengguna dapat memilih lapangan futsal yang tersedia, melihat harga per jam, dan melakukan reservasi dengan memilih jadwal yang diinginkan.

### 3. Pembayaran
Setelah melakukan reservasi, pengguna dapat melakukan pembayaran melalui metode yang tersedia.

## Teknologi yang Digunakan
- **Backend:** Laravel 10
- **Frontend:** Tailwind CSS, Blade
- **Database:** MySQL
- **Queue:** Laravel Queues untuk pemrosesan background

## Kontribusi

Terima kasih telah mempertimbangkan untuk berkontribusi pada proyek ini! Anda dapat mengajukan pull request untuk meningkatkan aplikasi ini. Pastikan untuk mengikuti pedoman kontribusi yang ada dalam [dokumen kontribusi Laravel](https://laravel.com/docs/contributions).

## Lisensi

Wolf Field menggunakan lisensi **MIT**. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

## Kontak

Jika Anda memiliki pertanyaan atau saran, silakan hubungi kami melalui email di: `support@wolf-field.com`.
```

Pastikan untuk mengganti URL repositori GitHub dan informasi kontak sesuai kebutuhan Anda.

# Panduan Migrasi Proyek (Pindah PC)

Dokumen ini berisi langkah-langkah untuk menjalankan proyek ini di PC baru agar lancar tanpa error.

## Prasayarat (Prerequisites)
Pastikan PC baru sudah terinstall aplikasi berikut:
1.  **PHP 8.2** atau lebih tinggi.
2.  **MySQL/MariaDB** (biasanya sepaket dengan XAMPP).
3.  **Composer** (Pengatur dependensi PHP).
4.  **Node.js & NPM** (Untuk frontend/Vite).

## Langkah-Langkah Migrasi

### 1. Persiapan File Proyek
Copy seluruh folder `simdesa_sidodadi29` ke PC baru.

### 2. Aktifkan Extension PHP GD (Penting!)
Beberapa fitur (seperti cetak PDF) membutuhkan extension GD.
- Buka folder `php` di installasi XAMPP kamu.
- Cari file `php.ini`.
- Cari baris `;extension=gd`.
- Hapus tanda titik koma (`;`) di depannya sehingga menjadi `extension=gd`.
- Simpan file dan restart Apache di XAMPP.

### 3. Konfigurasi Environment
- Pastikan file `.env` sudah ada. Jika belum ada, copy dari `.env.example`.
- Sesuaikan konfigurasi database di `.env`:
    ```env
    DB_DATABASE=sid_sidodadi
    DB_USERNAME=root
    DB_PASSWORD=
    ```
- Sesuaikan `APP_URL` jika kamu menggunakan virtual host atau port berbeda.

### 4. Install Dependensi & Build
Buka terminal/CMD di folder proyek, lalu jalankan:
```bash
composer install
npm install
npm run build
```

### 5. Setup Database
- Di PC baru, buat database baru bernama `sid_sidodadi` (sesuai yang di `.env`).
- Impor database lama kamu ke database baru ini.
- Jalankan migrasi jika perlu (opsional):
    ```bash
    php artisan migrate
    ```

### 6. Generate Key & Link Storage
Jalankan perintah berikut di terminal:
```bash
php artisan key:generate
php artisan storage:link
```

### 7. Jalankan Aplikasi
```bash
php artisan serve
```

## Tips Agar Lancar
- Jangan memindahkan folder proyek ke path yang sangat dalam (misal: `C:\Users\Admin\Desktop\Folder1\Folder2\Folder3\...`) karena Windows punya batasan panjang path.
- Gunakan folder seperti `C:\laragon\www\` atau `C:\xampp\htdocs\`.
- Jika ada error "Interface Psr\Cache\CacheItemPoolInterface not found", coba jalankan `composer update`.

---
*Dibuat oleh Antigravity untuk membantu transisi PC Anda.*

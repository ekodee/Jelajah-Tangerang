# Backend - Jelajah Tangerang ⚙️

Backend dari aplikasi **Jelajah Tangerang** dibangun menggunakan **Laravel** dan berfungsi sebagai penyedia REST API untuk frontend. Backend menangani pengelolaan data, autentikasi, serta logika bisnis aplikasi.

## ⚙️ Teknologi yang Digunakan

- Laravel
- PHP
- MySQL
- Laravel Sanctum (Autentikasi)
- REST API

## 📂 Struktur Folder (Umum)

```text
be/
│
├── app/
│ ├── Http/
│ ├── Models/
│ └── Controllers/
├── database/
│ ├── migrations/
│ └── seeders/
├── routes/
│ └── api.php
└── .env
```

## 🚀 Fitur Utama

- Autentikasi pengguna
- CRUD destinasi wisata
- CRUD artikel
- CRUD kategori
- API data lokasi dan peta
- Manajemen data melalui dashboard admin

## ▶️ Menjalankan Backend

1. **Masuk ke folder backend**

```bash
cd jelajah-tangerang-be
```

2. **Install dependencies**

```bash
composer install
```

3. **Copy file environment**

```bash
cp .env.example .env
```

4. **Generate application key**

```bash
php artisan key:generate
```

5. **Konfigurasi database**
   Buka file `.env` dan sesuaikan koneksi database (`DB_DATABASE`, `DB_USERNAME`, dll).
   > **PENTING:** Pastikan juga mengubah `APP_URL` di file `.env` agar sesuai dengan alamat server Anda (biasanya `http://localhost:8000` atau `http://127.0.0.1:8000`). Ini sangat berpengaruh pada link gambar agar tidak *broken*.

6. **Jalankan migrasi database**
```bash
   php artisan migrate --seed
```

7. **Link Storage (Wajib agar gambar muncul)**
```bash
   php artisan storage:link
```

8. **Jalankan server**
   Backend akan berjalan di: http://localhost:8000

## 🔐 Login Super Admin (Demo)

> [!IMPORTANT]
> **AKSES SUPER ADMIN**
>
> Gunakan kredensial berikut untuk mengakses **Dashboard Admin** secara penuh. Akun ini dibuat otomatis saat Anda menjalankan `db:seed`.

| Key | Value | Salin Cepat |
| :--- | :--- | :--- |
| **Email** | `admin@jelajah.com` | `admin@jelajah.com` |
| **Password** | `password` | `password` |

<br>

> [!WARNING]
> **Catatan Keamanan:**
> Akun ini hanya untuk keperluan **Development** dan **Demo**. Pada lingkungan produksi (Production), **WAJIB** mengganti password atau menghapus akun default ini demi keamanan sistem.

<br>
## 📧 Konfigurasi Layanan Email

Fitur **Lupa Password** dan **Verifikasi Email** memerlukan konfigurasi pada file `.env`. Silakan pilih salah satu opsi di bawah ini agar fitur tersebut tidak error saat diuji:

### 🟢 Opsi 1: Mode Log (Disarankan untuk Pengujian)
Gunakan mode ini jika Anda hanya ingin menguji fungsi tanpa menggunakan akun email asli. Email tidak akan dikirim ke inbox, melainkan ditulis ke file log sistem.

1. Buka file `.env`.
2. Ubah konfigurasi mail menjadi:
   ```env
   MAIL_MAILER=log
   ```
3. Cara Melihat Email: Buka file `storage/logs/laravel.log.` Link reset password atau verifikasi akan muncul di bagian paling bawah file tersebut.

### 🟠 Opsi 2: Mode Live (SMTP Gmail)
Gunakan mode ini jika Anda ingin aplikasi mengirim email sungguhan.
1. Pastikan Anda memiliki Google App Password (bukan password login biasa).
2. Buka file .env dan isi konfigurasi berikut:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email_anda@gmail.com
MAIL_PASSWORD=app_password_anda_disini
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@jelajah-tangerang.com"
```


🔐 API
Endpoint API didefinisikan pada file: routes/api.php
API digunakan oleh frontend untuk mengambil dan mengelola data aplikasi.

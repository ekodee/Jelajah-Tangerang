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

1. Masuk ke folder backend

```bash
cd jelajah-tangerang-be
```

2. Install dependencies

```bash
composer install
```

3. Copy file environment

```bash
cp .env.example .env
```

4. Generate application key

```bash
php artisan key:generate
```

5. Konfigurasi database di file .env

6. Jalankan migrasi database

```bash
php artisan migrate
```

7. Jalankan server
   Backend akan berjalan di: http://localhost:8000

🔐 API
Endpoint API didefinisikan pada file: routes/api.php
API digunakan oleh frontend untuk mengambil dan mengelola data aplikasi.

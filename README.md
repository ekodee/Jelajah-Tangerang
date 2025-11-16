# 🗺️ Blog Pariwisata Kota Tangerang

Ini adalah repositori untuk proyek website blog pariwisata yang fokus pada destinasi, acara, dan informasi wisata terkini di Kota Tangerang. Dibangun menggunakan framework **Laravel** untuk backend dan dikembangkan dengan antarmuka yang ramah pengguna.

## 🌟 Fitur Utama

* **Daftar Destinasi:** Menampilkan daftar lengkap tempat-tempat wisata, lengkap dengan deskripsi, lokasi, dan galeri foto.
* **Artikel/Blog:** Menyajikan berbagai artikel mendalam mengenai *event*, kuliner, sejarah, dan perkembangan pariwisata di Kota Tangerang.
* **Pencarian & Filter:** Memungkinkan pengguna untuk mencari destinasi atau artikel berdasarkan kata kunci atau kategori.
* **Dasbor Admin:** Area khusus untuk pengelola untuk menambah, mengedit, dan menghapus destinasi serta artikel.

## 🛠️ Teknologi yang Digunakan

Proyek ini dikembangkan menggunakan stack teknologi berikut:

* **Backend:** **PHP** dengan **Laravel 12**
* **Database:** **MySQL** 
* **Frontend:** **React JS**

## 🚀 Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di mesin lokal Anda:

### Prasyarat

Pastikan Anda telah menginstal hal-hal berikut:

* **PHP** (Versi minimal yang dibutuhkan Laravel12)
* **Composer**
* **Node.js & npm/Yarn**
* **Git**

### Langkah-Langkah

1.  **Kloning Repositori:**
    ```bash
    git clone 
    cd nama-folder-proyek
    ```

2.  **Instal Dependensi PHP:**
    ```bash
    composer install
    ```

3.  **Pengaturan Environment:**
    * Duplikasi file `.env.example` menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
    * Buat *Application Key* baru:
        ```bash
        php artisan key:generate
        ```
    * Edit file `.env` dan konfigurasikan detail database Anda (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, dll.).

4.  **Migrasi Database:**
    ```bash
    php artisan migrate
    ```
    *(Opsional: Jika Anda memiliki *seeder* untuk data awal destinasi/artikel, jalankan:* `php artisan db:seed` *)

5.  **Instal dan Kompilasi Frontend Assets (Jika ada):**
    ```bash
    npm install
    npm run dev  # Atau npm run build / npm run watch
    ```

6.  **Jalankan Server Lokal:**
    ```bash
    php artisan serve
    ```

Proyek sekarang dapat diakses di `http://127.0.0.1:8000` (atau port lain yang ditunjukkan).


## ✍️ Pengembang

Proyek ini dikembangkan oleh:

* Ekoode

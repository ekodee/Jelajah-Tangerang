<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. BUAT USER (Penulis & Reviewer)
        // Kita buat beberapa user agar variatif
        $users = [
            [
                'name' => 'Admin Jelajah',
                'email' => 'admin@jelajahtangerang.com',
                'password' => Hash::make('password'),
                'role' => 'admin', // Sesuai enum
                'created_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'wisatawan', // DIPERBAIKI: sebelumnya 'user', harus sesuai enum migration
                'created_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'wisatawan', // DIPERBAIKI: sebelumnya 'user', harus sesuai enum migration
                'created_at' => now(),
            ],
        ];

        // Simpan user dan ambil ID-nya untuk relasi
        DB::table('users')->insert($users);
        $adminId = DB::table('users')->where('email', 'admin@jelajahtangerang.com')->first()->id;
        $userId1 = DB::table('users')->where('email', 'budi@gmail.com')->first()->id;
        $userId2 = DB::table('users')->where('email', 'siti@gmail.com')->first()->id;


        // 2. BUAT KATEGORI
        $categories = [
            ['name' => 'Wisata Kuliner', 'slug' => 'wisata-kuliner', 'created_at' => now()],
            ['name' => 'Wisata Alam', 'slug' => 'wisata-alam', 'created_at' => now()],
            ['name' => 'Wisata Sejarah', 'slug' => 'wisata-sejarah', 'created_at' => now()],
            ['name' => 'Taman Kota', 'slug' => 'taman-kota', 'created_at' => now()],
            ['name' => 'Belanja & Mall', 'slug' => 'belanja-mall', 'created_at' => now()],
        ];
        DB::table('categories')->insert($categories);

        // Ambil ID kategori untuk relasi
        $catKuliner = DB::table('categories')->where('slug', 'wisata-kuliner')->first()->id;
        $catAlam = DB::table('categories')->where('slug', 'wisata-alam')->first()->id;
        $catSejarah = DB::table('categories')->where('slug', 'wisata-sejarah')->first()->id;
        $catTaman = DB::table('categories')->where('slug', 'taman-kota')->first()->id;


        // 3. BUAT DESTINASI (Jelajah Tangerang Context)
        $destinations = [
            [
                'category_id' => $catKuliner,
                'name' => 'Pasar Lama Tangerang',
                'slug' => 'pasar-lama-tangerang', // DIPERBAIKI: Menambahkan slug
                'description' => 'Pusat kuliner legendaris di Kota Tangerang. Menawarkan berbagai jajanan tradisional hingga modern, mulai dari Sate Ayam H. Ishak hingga Laksa Tangerang.',
                'address' => 'Jl. Kisamaun, Pasar Lama, Kec. Tangerang, Kota Tangerang, Banten',
                'open_hours' => '16:00 - 23:00 WIB',
                'latitude' => '-6.178306',
                'longitude' => '106.629444',
                'photo' => 'destinations/pasar-lama.jpg',
                'created_at' => now(),
            ],
            [
                'category_id' => $catAlam,
                'name' => 'Situ Cipondoh',
                'slug' => 'situ-cipondoh', // DIPERBAIKI: Menambahkan slug
                'description' => 'Danau (Situ) yang menjadi tempat rekreasi keluarga. Terdapat wahana bebek air, pemancingan, dan spot foto dengan latar belakang danau yang luas.',
                'address' => 'Jl. KH Hasyim Ashari, Cipondoh, Kota Tangerang',
                'open_hours' => '07:00 - 18:00 WIB',
                'latitude' => '-6.1916',
                'longitude' => '106.6789',
                'photo' => 'destinations/situ-cipondoh.jpg',
                'created_at' => now(),
            ],
            [
                'category_id' => $catTaman,
                'name' => 'Scientia Square Park',
                'slug' => 'scientia-square-park', // DIPERBAIKI: Menambahkan slug
                'description' => 'Taman aktivitas outdoor yang cocok untuk keluarga dan anak muda. Memiliki wall climbing, skate park, sawah mini, dan interaksi dengan hewan.',
                'address' => 'Jl. Scientia Boulevard, Gading Serpong, Tangerang',
                'open_hours' => '08:00 - 20:00 WIB',
                'latitude' => '-6.2606',
                'longitude' => '106.6183',
                'photo' => 'destinations/sqp.jpg',
                'created_at' => now(),
            ],
            [
                'category_id' => $catSejarah,
                'name' => 'Museum Benteng Heritage',
                'slug' => 'museum-benteng-heritage', // DIPERBAIKI: Menambahkan slug
                'description' => 'Museum peranakan Tionghoa pertama di Indonesia. Bangunan ini merupakan restorasi bangunan tua berarsitektur tradisional Tionghoa.',
                'address' => 'Jalan Cilame No.20, Pasar Lama, Tangerang',
                'open_hours' => '10:00 - 17:00 WIB (Senin Tutup)',
                'latitude' => '-6.1794',
                'longitude' => '106.6297',
                'photo' => 'destinations/benteng-heritage.jpg',
                'created_at' => now(),
            ],
        ];
        DB::table('destinations')->insert($destinations);

        // Ambil ID Destinasi
        $destPasarLama = DB::table('destinations')->where('name', 'Pasar Lama Tangerang')->first()->id;
        $destSQP = DB::table('destinations')->where('name', 'Scientia Square Park')->first()->id;


        // 4. BUAT ARTIKEL
        $articles = [
            [
                'user_id' => $adminId,
                'title' => '5 Kuliner Wajib Coba di Pasar Lama Tangerang',
                'slug' => '5-kuliner-wajib-coba-di-pasar-lama-tangerang',
                'content' => 'Pasar Lama Tangerang tidak pernah tidur. Jika Anda berkunjung ke sini, jangan lupa mencicipi Sate Ayam H. Ishak yang legendaris, Es Podeng, dan Bubur Ayam Ko Iyo. Suasana malam hari semakin meriah dengan lampu-lampu jalanan...',
                'thumbnail' => 'articles/kuliner-pasar-lama.jpg',
                'published_at' => Carbon::now()->subDays(2),
                'created_at' => now(),
            ],
            [
                'user_id' => $adminId,
                'title' => 'Sejarah Panjang Sungai Cisadane',
                'slug' => 'sejarah-panjang-sungai-cisadane',
                'content' => 'Sungai Cisadane bukan sekadar aliran air, melainkan urat nadi kehidupan masyarakat Tangerang sejak masa kolonial. Festival Cisadane yang digelar setiap tahun menjadi bukti betapa pentingnya sungai ini...',
                'thumbnail' => 'articles/cisadane.jpg',
                'published_at' => Carbon::now()->subDays(5),
                'created_at' => now(),
            ],
            [
                'user_id' => $adminId,
                'title' => 'Liburan Seru Bareng Keluarga di Gading Serpong',
                'slug' => 'liburan-seru-bareng-keluarga-di-gading-serpong',
                'content' => 'Gading Serpong kini menjadi destinasi wisata modern. Mulai dari mall raksasa hingga taman terbuka hijau seperti Scientia Square Park tersedia di sini...',
                'thumbnail' => 'articles/gading-serpong.jpg',
                'published_at' => null, // Draft
                'created_at' => now(),
            ],
        ];
        DB::table('articles')->insert($articles);


        // 5. BUAT REVIEW
        $reviews = [
            [
                'user_id' => $userId1, // Budi
                'destination_id' => $destPasarLama,
                'rating' => 5,
                'comment' => 'Tempatnya asik banget buat kulineran malam. Harganya juga terjangkau. Tapi parkirnya agak susah kalau malam minggu.',
                'created_at' => Carbon::now()->subHour(2),
            ],
            [
                'user_id' => $userId2, // Siti
                'destination_id' => $destPasarLama,
                'rating' => 4,
                'comment' => 'Makanannya enak-enak, terutama satenya. Ramai sekali pengunjungnya.',
                'created_at' => Carbon::now()->subHour(5),
            ],
            [
                'user_id' => $userId1, // Budi
                'destination_id' => $destSQP,
                'rating' => 5,
                'comment' => 'Anak-anak senang banget main di sini. Hewan-hewannya terawat dan tempatnya bersih. Tiket masuk worth it.',
                'created_at' => Carbon::now()->subDay(1),
            ],
        ];
        DB::table('reviews')->insert($reviews);
    }
}

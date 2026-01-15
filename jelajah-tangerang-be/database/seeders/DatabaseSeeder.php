<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\Destination;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BERSIHKAN DATABASE (Agar ID kembali ke 1)
        Schema::disableForeignKeyConstraints();
        
        // Hapus data transaksi/konten dulu
        Review::truncate();
        Article::truncate();
        Destination::truncate();
        
        // Hapus data master
        Category::truncate();
        User::truncate();
        
        // Opsional: Reset Role jika perlu (hati-hati jika role sudah disetting manual di migrasi lain)
        // Role::truncate(); 
        
        Schema::enableForeignKeyConstraints();

        echo "Database cleaned. Siap untuk data asli.\n";

        // 2. SETUP ROLE (PENTING: Pastikan Role ada sebelum assign ke user)
        // Cek dulu apakah role sudah ada, kalau belum buat baru
        $roleAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $roleEditor = Role::firstOrCreate(['name' => 'editor']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);
        
        echo "Roles checked/created.\n";

        // 3. BUAT 1 AKUN SUPER ADMIN (Pegang akun ini baik-baik)
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@jelajah.com', // Ganti dengan email asli admin dinas
            'password' => bcrypt('password'), // Ganti dengan password kuat nanti
            'email_verified_at' => now(),
        ]);

        // Berikan jabatan Super Admin
        $admin->assignRole($roleAdmin);

        echo "✅ Admin Asli Created: admin@jelajah.com\n";

        // 4. BUAT KATEGORI STANDAR (Bisa ditambah/edit nanti di CMS)
        $categories = ['Wisata Alam', 'Kuliner', 'Sejarah', 'Religi', 'Edukasi', 'Belanja', 'Event'];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat)
            ]);
        }
        echo "✅ Default Categories Created.\n";

        echo "---------------------------------------------\n";
        echo "SYSTEM READY! Silakan login dan input data asli.\n";
    }
}
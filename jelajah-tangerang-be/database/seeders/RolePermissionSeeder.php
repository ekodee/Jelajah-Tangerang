<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset Cache (Wajib biar gak error)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Buat PERMISSIONS (Hak Akses Spesifik)
        $permissions = [
            'manage_users',       // Hapus/Blokir User
            'manage_destinations', // Tambah/Edit/Hapus Destinasi
            'manage_articles',     // Tambah/Edit/Hapus Artikel
            'manage_reviews',      // Hapus review toxic
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 3. Buat ROLES (Jabatan) & Assign Permission

        // A. ROLE USER (Pengunjung Biasa)
        // Gak perlu permission khusus, karena logic review dicek via verified email
        $roleUser = Role::create(['name' => 'user']);

        // B. ROLE EDITOR (Penulis Konten)
        $roleEditor = Role::create(['name' => 'editor']);
        $roleEditor->givePermissionTo(['manage_destinations', 'manage_articles']);

        // C. ROLE SUPER ADMIN (Dewa)
        $roleSuperAdmin = Role::create(['name' => 'super_admin']);
        // Kasih semua permission yang ada
        $roleSuperAdmin->givePermissionTo(Permission::all());

        // 4. BIKIN USER DUMMY SPESIFIK (Biar enak ngetes login)

        // Akun Super Admin
        $admin = User::firstOrCreate([
            'email' => 'admin@jelajah.com'
        ], [
            'name' => 'Super Admin Ganteng',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('super_admin');

        // Akun Editor
        $editor = User::firstOrCreate([
            'email' => 'editor@jelajah.com'
        ], [
            'name' => 'Mas Editor Rajin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $editor->assignRole('editor');

        // Akun User Biasa
        $user = User::firstOrCreate([
            'email' => 'user@jelajah.com'
        ], [
            'name' => 'Warga Tangerang',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('user');
    }
}

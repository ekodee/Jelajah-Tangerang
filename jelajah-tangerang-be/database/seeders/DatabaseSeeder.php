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

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BERSIHKAN DATABASE (Reset ID dari 1 lagi)
        Schema::disableForeignKeyConstraints();
        Review::truncate();
        Article::truncate();
        Destination::truncate();
        Category::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        echo "Database cleaned.\n";

        // 2. BUAT AKUN ADMIN
        $admin = User::factory()->create([
            'name' => 'Admin Jelajah',
            'email' => 'admin@jelajah.com',
            'password' => bcrypt('password'), // password login
        ]);
        echo "Admin created: admin@jelajah.com\n";

        // 3. BUAT 20 USER DUMMY (Untuk jadi komentator)
        $users = User::factory(20)->create();
        echo "20 Dummy Users created.\n";

        // 4. BUAT KATEGORI
        $categories = ['Wisata Alam', 'Kuliner', 'Sejarah', 'Religi', 'Edukasi', 'Belanja', 'Event'];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat)
            ]);
        }
        echo "Categories created.\n";

        // 5. BUAT 30 DESTINASI + REVIEW
        echo "Generating Destinations...\n";
        Destination::factory(30)->create()->each(function ($dest) use ($users) {
            // Setiap destinasi dikasih 3 s/d 8 review acak
            $randomReviewCount = rand(3, 8);

            for ($i = 0; $i < $randomReviewCount; $i++) {
                Review::factory()->create([
                    'destination_id' => $dest->id,
                    'article_id'     => null, // Pastikan article null
                    'user_id'        => $users->random()->id, // Pilih user acak
                    'rating'         => rand(3, 5),
                    'comment'        => 'Tempatnya bagus banget! ' . fake()->sentence(),
                ]);
            }
        });

        // 6. BUAT 50 ARTIKEL + KOMENTAR
        echo "Generating Articles...\n";
        Article::factory(50)->create()->each(function ($art) use ($users) {
            // Setiap artikel dikasih 0 s/d 5 komentar acak
            $randomCommentCount = rand(0, 5);

            for ($i = 0; $i < $randomCommentCount; $i++) {
                Review::factory()->create([
                    'destination_id' => null, // Pastikan dest null
                    'article_id'     => $art->id,
                    'user_id'        => $users->random()->id,
                    'rating'         => 5, // Komentar artikel biasanya ga pake rating, kasih 5 aja default
                    'comment'        => 'Artikel yang sangat informatif. ' . fake()->sentence(),
                ]);
            }
        });

        echo "✅ SEEDING COMPLETE! 🚀\n";
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DestinationFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->cityPrefix() . ' ' . $this->faker->company() . ' Tangerang';

        // List Fasilitas Random
        $facilitiesList = ['Parkir Luas', 'Toilet Bersih', 'Musholla', 'Spot Foto', 'Kantin', 'WiFi', 'Area Bermain', 'Gazebo'];
        // Ambil 3-6 fasilitas secara acak & gabungkan jadi string koma
        $facilities = implode(',', $this->faker->randomElements($facilitiesList, rand(3, 6)));

        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? 1, // Ambil kategori acak
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => $this->faker->paragraph(5), // Deskripsi panjang 5 paragraf
            'address'     => $this->faker->address(),
            'open_hours'  => '08:00 - 22:00 WIB',

            // Koordinat Acak Sekitar Tangerang (-6.1 s/d -6.3, 106.5 s/d 106.7)
            'latitude'    => $this->faker->latitude(-6.30, -6.10),
            'longitude'   => $this->faker->longitude(106.50, 106.75),

            'photo'       => 'https://placehold.co/800x600?text=' . urlencode($name),

            // Data Baru
            'ticket_price' => $this->faker->randomElement(['Gratis', 'Rp 5.000', 'Rp 10.000', 'Rp 25.000', 'Rp 50.000']),
            'facilities'   => $facilities,
        ];
    }
}

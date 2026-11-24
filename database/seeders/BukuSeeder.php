<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use Faker\Factory as Faker;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 20; $i++) {
            Buku::create([
                'judul' => $faker->sentence(3),
                'penulis' => $faker->name(),
                'harga' => $faker->numberBetween(10000, 50000),
                'tgl_terbit' => $faker->date(),
            ]);
        }
    }
}

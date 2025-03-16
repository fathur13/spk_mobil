<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mobil;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Mobil::create([
            'nama' => 'Toyota Avanza',
            'harga' => 150000000,
            'tahun' => 2020,
            'transmisi' => 'Manual',
            'bahan_bakar' => 'Bensin',
            'seater' => 7,
        ]);
        // Tambahkan data lainnya
    }
}

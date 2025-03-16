<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('mobils')->insert([
            [
                'nama' => 'Toyota Avanza',
                'harga' => 150000000,
                'tahun' => 2020,
                'transmisi' => 'Manual',
                'bahan_bakar' => 'Bensin',
                'seater' => 7,
                'c1' => 3,
                'c2' => 4,
                'c3' => 1,
                'c4' => 5,
                'c5' => 3,
            ],
            [
                'nama' => 'Honda Brio',
                'harga' => 120000000,
                'tahun' => 2019,
                'transmisi' => 'Manual',
                'bahan_bakar' => 'Bensin',
                'seater' => 5,
                'c1' => 4,
                'c2' => 4,
                'c3' => 1,
                'c4' => 5,
                'c5' => 3,
            ],
            [
                'nama' => 'Daihatsu Ayla',
                'harga' => 100000000,
                'tahun' => 2019,
                'transmisi' => 'Manual',
                'bahan_bakar' => 'Bensin',
                'seater' => 5,
                'c1' => 4,
                'c2' => 4,
                'c3' => 1,
                'c4' => 5,
                'c5' => 3,
            ],
            [
                'nama' => 'Mitsubishi Xpander',
                'harga' => 180000000,
                'tahun' => 2019,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Bensin',
                'seater' => 7,
                'c1' => 3,
                'c2' => 4,
                'c3' => 2,
                'c4' => 5,
                'c5' => 3,
            ],
            [
                'nama' => 'Toyota Fortuner',
                'harga' => 350000000,
                'tahun' => 2017,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Disel',
                'seater' => 7,
                'c1' => 2,
                'c2' => 3,
                'c3' => 2,
                'c4' => 1,
                'c5' => 3,
            ],
            [
                'nama' => 'Honda HR-V 2018',
                'harga' => 250000000,
                'tahun' => 2018,
                'transmisi' => 'CVT',
                'bahan_bakar' => 'Bensin',
                'seater' => 5,
                'c1' => 3,
                'c2' => 3,
                'c3' => 3,
                'c4' => 5,
                'c5' => 3,
            ],
            [
                'nama' => 'Mazda MX-5 2016',
                'harga' => 400000000,
                'tahun' => 2016,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Bensin',
                'seater' => 2,
                'c1' => 2,
                'c2' => 2,
                'c3' => 2,
                'c4' => 5,
                'c5' => 1,
            ],
            [
                'nama' => 'Tesla Model 3',
                'harga' => 700000000,
                'tahun' => 2021,
                'transmisi' => 'CVT',
                'bahan_bakar' => 'Listrik',
                'seater' => 5,
                'c1' => 1,
                'c2' => 5,
                'c3' => 3,
                'c4' => 3,
                'c5' => 3,
            ],
            [
                'nama' => 'Mazda MX-5 Miata',
                'harga' => 500000000,
                'tahun' => 2020,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Bensin',
                'seater' => 2,
                'c1' => 2,
                'c2' => 5,
                'c3' => 2,
                'c4' => 5,
                'c5' => 1,
            ],
            [
                'nama' => 'Wuling BingoEV',
                'harga' => 330000000,
                'tahun' => 2025,
                'transmisi' => 'Matic',
                'bahan_bakar' => 'Listrik',
                'seater' => 5,
                'c1' => 2,
                'c2' => 5,
                'c3' => 2,
                'c4' => 3,
                'c5' => 3,
            ],
        ]);
    
    }
}

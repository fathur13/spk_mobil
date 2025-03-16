<?php

return [
    /**
     * Konfigurasi bobot dan jenis kriteria dalam sistem SPK.
     *
     * type: Menentukan apakah kriteria bersifat "cost" (lebih kecil lebih baik)
     *       atau "benefit" (lebih besar lebih baik).
     * weight: Bobot kepentingan masing-masing kriteria dalam perhitungan akhir.
     */

    'c1' => [
        'type'   => 'cost',  // Harga lebih murah lebih baik
        'weight' => 5,       // Bobot kepentingan tinggi
    ], 

    'c2' => [
        'type'   => 'benefit', // Tahun lebih baru lebih baik
        'weight' => 4,         // Bobot kepentingan sedang
    ], 

    'c3' => [
        'type'   => 'benefit', // Transmisi lebih modern lebih baik
        'weight' => 3,         // Bobot kepentingan rendah
    ], 

    'c4' => [
        'type'   => 'benefit', // Jenis bahan bakar lebih efisien lebih baik
        'weight' => 3,         // Bobot kepentingan rendah
    ], 

    'c5' => [
        'type'   => 'benefit', // Jumlah seater lebih banyak lebih baik
        'weight' => 5,         // Bobot kepentingan tinggi
    ],
];

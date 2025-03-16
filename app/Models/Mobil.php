<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan dalam database.
     *
     * @var string
     */
    protected $table = 'mobils';

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'harga',
        'tahun',
        'transmisi',
        'bahan_bakar',
        'seater',
        'c1', // Kriteria harga (cost)
        'c2', // Kriteria tahun produksi (benefit)
        'c3', // Kriteria jenis transmisi (benefit)
        'c4', // Kriteria jenis bahan bakar (benefit)
        'c5', // Kriteria jumlah seater (benefit)
    ];
}

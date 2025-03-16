<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;

class RekomendasiController extends Controller
{
    public function index()
    {
        // Ambil semua data mobil
        $mobils = Mobil::all();

        // Cek apakah ada data mobil
        if ($mobils->isEmpty()) {
            return view('rekomendasi', ['normalized' => []])->with('error', 'Tidak ada data mobil tersedia.');
        }

        // Menentukan nilai min & max untuk normalisasi
        $minC1 = $mobils->min('c1'); // Harga (cost) -> semakin kecil semakin baik
        $maxC2 = $mobils->max('c2'); // Tahun produksi (benefit) -> semakin besar semakin baik
        $maxC3 = $mobils->max('c3'); // Transmisi (benefit)
        $maxC4 = $mobils->max('c4'); // Bahan bakar (benefit)
        $maxC5 = $mobils->max('c5'); // Seater (benefit)

        // Normalisasi data
        $normalized = [];
        foreach ($mobils as $mobil) {
            $normalized[] = [
                'nama' => $mobil->nama,
                'c1' => $minC1 / $mobil->c1, // Harga (cost minimization)
                'c2' => $mobil->c2 / $maxC2, // Tahun (benefit)
                'c3' => $mobil->c3 / $maxC3, // Transmisi (benefit)
                'c4' => $mobil->c4 / $maxC4, // Bahan bakar (benefit)
                'c5' => $mobil->c5 / $maxC5, // Seater (benefit)
            ];
        }

        // Bobot kriteria
        $bobot = [
            'c1' => 0.3,  // Harga (cost)
            'c2' => 0.2,  // Tahun (benefit)
            'c3' => 0.15, // Transmisi (benefit)
            'c4' => 0.2,  // Bahan Bakar (benefit)
            'c5' => 0.15  // Seater (benefit)
        ];

        // Hitung normalisasi terbobot
        foreach ($normalized as &$data) {
            $data['terbobot'] = [
                'c1' => $data['c1'] * $bobot['c1'],
                'c2' => $data['c2'] * $bobot['c2'],
                'c3' => $data['c3'] * $bobot['c3'],
                'c4' => $data['c4'] * $bobot['c4'],
                'c5' => $data['c5'] * $bobot['c5'],
            ];
        }
        unset($data);

        // Menentukan Solusi Ideal Positif (A+) dan Negatif (A-)
        $Aplus = [
            'c1' => min(array_column($normalized, 'c1')), // Min untuk cost
            'c2' => max(array_column($normalized, 'c2')),
            'c3' => max(array_column($normalized, 'c3')),
            'c4' => max(array_column($normalized, 'c4')),
            'c5' => max(array_column($normalized, 'c5')),
        ];

        $Amin = [
            'c1' => max(array_column($normalized, 'c1')), // Max untuk cost
            'c2' => min(array_column($normalized, 'c2')),
            'c3' => min(array_column($normalized, 'c3')),
            'c4' => min(array_column($normalized, 'c4')),
            'c5' => min(array_column($normalized, 'c5')),
        ];

        // Hitung jarak solusi ideal positif (D+) dan negatif (D-)
        foreach ($normalized as &$data) {
            $data['Dplus'] = sqrt(
                pow($Aplus['c1'] - $data['c1'], 2) +
                pow($Aplus['c2'] - $data['c2'], 2) +
                pow($Aplus['c3'] - $data['c3'], 2) +
                pow($Aplus['c4'] - $data['c4'], 2) +
                pow($Aplus['c5'] - $data['c5'], 2)
            );

            $data['Dmin'] = sqrt(
                pow($data['c1'] - $Amin['c1'], 2) +
                pow($data['c2'] - $Amin['c2'], 2) +
                pow($data['c3'] - $Amin['c3'], 2) +
                pow($data['c4'] - $Amin['c4'], 2) +
                pow($data['c5'] - $Amin['c5'], 2)
            );

            // Hitung nilai preferensi (CCi)
            $data['skor'] = $data['Dmin'] / ($data['Dmin'] + $data['Dplus']);
        }
        unset($data);

        // Urutkan berdasarkan skor tertinggi
        usort($normalized, fn($a, $b) => $b['skor'] <=> $a['skor']);

        // Kirim data ke view
        return view('rekomendasi', compact('normalized'));
    }
}

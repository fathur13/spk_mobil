<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;

class SPKController extends Controller
{
    /**
     * Melakukan normalisasi data menggunakan metode normalisasi vektor.
     *
     * @return \Illuminate\View\View
     */
    public function normalisasi()
    {
        // Ambil semua data mobil
        $mobils = Mobil::all();

        // Pastikan ada data sebelum dilakukan normalisasi
        if ($mobils->isEmpty()) {
            return redirect()->route('mobils.index')->with('error', 'Data mobil tidak ditemukan.');
        }

        // Hitung sum kuadrat untuk setiap kriteria
        $sum_c1 = sqrt($mobils->sum(fn($m) => pow($m->c1, 2))) ?: 1;
        $sum_c2 = sqrt($mobils->sum(fn($m) => pow($m->c2, 2))) ?: 1;
        $sum_c3 = sqrt($mobils->sum(fn($m) => pow($m->c3, 2))) ?: 1;
        $sum_c4 = sqrt($mobils->sum(fn($m) => pow($m->c4, 2))) ?: 1;
        $sum_c5 = sqrt($mobils->sum(fn($m) => pow($m->c5, 2))) ?: 1;

        // Lakukan normalisasi
        foreach ($mobils as $mobil) {
            $mobil->n_c1 = round($mobil->c1 / $sum_c1, 4);
            $mobil->n_c2 = round($mobil->c2 / $sum_c2, 4);
            $mobil->n_c3 = round($mobil->c3 / $sum_c3, 4);
            $mobil->n_c4 = round($mobil->c4 / $sum_c4, 4);
            $mobil->n_c5 = round($mobil->c5 / $sum_c5, 4);
        }

        // Kirim data ke view
        return view('spk.normalisasi', compact('mobils'));
    }
}

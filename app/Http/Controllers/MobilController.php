<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;

class MobilController extends Controller
{
    /**
     * Menampilkan daftar mobil.
     */
    public function index(Request $request)
    {
        $query = Mobil::query();

        // Filter berdasarkan input pencarian
        if ($request->has('min_harga')) {
            $query->where('harga', '>=', $request->min_harga);
        }
        if ($request->has('max_harga')) {
            $query->where('harga', '<=', $request->max_harga);
        }
        if ($request->has('min_tahun')) {
            $query->where('tahun', '>=', $request->min_tahun);
        }
        if ($request->has('max_tahun')) {
            $query->where('tahun', '<=', $request->max_tahun);
        }
        if ($request->has('transmisi')) {
            $query->where('transmisi', $request->transmisi);
        }
        if ($request->has('bahan_bakar')) {
            $query->where('bahan_bakar', $request->bahan_bakar);
        }
        if ($request->has('seater')) {
            $query->where('seater', $request->seater);
        }

        $mobils = Mobil::all(); // Mengambil semua data tanpa pagination

        return view('mobil.index', compact('mobils'));
    }

    /**
     * Fungsi untuk menghitung ranking menggunakan metode Fuzzy TOPSIS
     */
    private function topsisRanking($mobils)
    {
        // Matriks Keputusan
        $matrix = $mobils->map(function ($mobil) {
            return [
                $mobil->c1,
                $mobil->c2,
                $mobil->c3,
                $mobil->c4,
                $mobil->c5
            ];
        });

        // Normalisasi Matriks
        $normalizedMatrix = $this->normalizeMatrix($matrix);

        // Menghitung solusi ideal positif dan negatif
        list($positiveIdeal, $negativeIdeal) = $this->calculateIdealSolutions($normalizedMatrix);

        // Menghitung jarak ke solusi positif dan negatif
        $positiveDistance = $this->calculateDistance($normalizedMatrix, $positiveIdeal);
        $negativeDistance = $this->calculateDistance($normalizedMatrix, $negativeIdeal);

        // Menghitung peringkat berdasarkan jarak
        $ranking = $this->ranking($positiveDistance, $negativeDistance);

        // Menggabungkan peringkat dengan mobil
        foreach ($mobils as $key => $mobil) {
            $mobil->ranking = $ranking[$key];
        }

        // Urutkan berdasarkan ranking
        return $mobils->sortByDesc('ranking');
    }

    /**
     * Normalisasi Matriks Keputusan
     */
    private function normalizeMatrix($matrix)
    {
        $normalizedMatrix = [];
        $columns = count($matrix[0]);
        $rows = count($matrix);

        for ($j = 0; $j < $columns; $j++) {
            $sum = 0;
            for ($i = 0; $i < $rows; $i++) {
                $sum += pow($matrix[$i][$j], 2);
            }
            $normFactor = sqrt($sum);

            for ($i = 0; $i < $rows; $i++) {
                $normalizedMatrix[$i][$j] = $matrix[$i][$j] / $normFactor;
            }
        }

        return $normalizedMatrix;
    }

    /**
     * Menghitung solusi ideal (positif dan negatif)
     */
    private function calculateIdealSolutions($normalizedMatrix)
    {
        $positiveIdeal = [];
        $negativeIdeal = [];

        foreach ($normalizedMatrix[0] as $index => $value) {
            $positiveIdeal[] = max(array_column($normalizedMatrix, $index));
            $negativeIdeal[] = min(array_column($normalizedMatrix, $index));
        }

        return [$positiveIdeal, $negativeIdeal];
    }

    /**
     * Menghitung jarak ke solusi ideal
     */
    private function calculateDistance($normalizedMatrix, $idealSolution)
    {
        $distances = [];
        foreach ($normalizedMatrix as $index => $mobil) {
            $distance = 0;
            foreach ($mobil as $j => $value) {
                $distance += pow($value - $idealSolution[$j], 2);
            }
            $distances[$index] = sqrt($distance);
        }
        return $distances;
    }

    /**
     * Menghitung perankingan berdasarkan jarak
     */
    private function ranking($positiveDistance, $negativeDistance)
    {
        $ranking = [];
        foreach ($positiveDistance as $key => $positive) {
            $ranking[] = $negativeDistance[$key] / ($positive + $negativeDistance[$key]);
        }

        // Urutkan berdasarkan perankingan (nilai tertinggi)
        arsort($ranking);
        return $ranking;
    }


    /**
     * Menampilkan form untuk menambahkan mobil baru.
     */
    public function create()
    {
        return view('mobil.create');
    }

    /**
     * Menyimpan data mobil ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'harga' => 'required|numeric|min:0',
            'tahun' => 'required|numeric|between:1900,' . date('Y'),
            'transmisi' => 'required|string',
            'bahan_bakar' => 'required|string',
            'seater' => 'required|integer|min:2|max:10', // Menyesuaikan dengan pilihan seater
        ]);

        // Pastikan harga tidak mengandung simbol 'Rp' dan titik
        $harga = str_replace(['Rp', '.'], '', $request->harga);
        $harga = (int) $harga; // Ubah menjadi integer jika diperlukan

        // Konversi ke bobot kriteria
        $c1 = $this->convertHargaToC1($harga);
        $c2 = $this->convertTahunToC2($request->tahun);
        $c3 = $this->convertTransmisiToC3($request->transmisi);
        $c4 = $this->convertBahanBakarToC4($request->bahan_bakar);
        $c5 = $this->convertSeaterToC5($request->seater);

        // Simpan ke database
        Mobil::create([
            'nama'        => $request->nama,
            'harga'       => $harga, // Menyimpan harga yang sudah diproses
            'tahun'       => $request->tahun,
            'transmisi'   => $request->transmisi,
            'bahan_bakar' => $request->bahan_bakar,
            'seater'      => $request->seater,
            'c1'          => $c1,
            'c2'          => $c2,
            'c3'          => $c3,
            'c4'          => $c4,
            'c5'          => $c5,
        ]);

        // Redirect ke halaman daftar mobil dengan pesan sukses
        return redirect()->route('mobils.index')->with('success', 'Mobil berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $mobil = Mobil::findOrFail($id);
        return view('mobil.edit', compact('mobil'));
    }

    /**
     * Menyimpan perubahan data mobil.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required',
            'harga'       => 'required|numeric',
            'tahun'       => 'required|numeric',
            'transmisi'   => 'required',
            'bahan_bakar' => 'required',
            'seater'      => 'required|numeric',
        ]);

        $mobil = Mobil::findOrFail($id);

        $mobil->update([
            'nama'        => $request->nama,
            'harga'       => $request->harga,
            'tahun'       => $request->tahun,
            'transmisi'   => $request->transmisi,
            'bahan_bakar' => $request->bahan_bakar,
            'seater'      => $request->seater,
            'c1'          => $this->convertHargaToC1($request->harga),
            'c2'          => $this->convertTahunToC2($request->tahun),
            'c3'          => $this->convertTransmisiToC3($request->transmisi),
            'c4'          => $this->convertBahanBakarToC4($request->bahan_bakar),
            'c5'          => $this->convertSeaterToC5($request->seater),
        ]);

        return redirect()->route('mobils.index')->with('success', 'Data mobil berhasil diperbarui!');
    }

    /**
     * Menghapus data mobil dari database.
     */
    public function destroy($id)
    {
        $mobil = Mobil::findOrFail($id);
        $mobil->delete();

        return redirect()->route('mobils.index')->with('success', 'Mobil berhasil dihapus!');
    }

    /**
     * Mencari dan memfilter mobil berdasarkan kriteria.
     */
    public function search(Request $request)
    {
        $query = Mobil::query(); // Query untuk pencarian data mobil

        // Filter berdasarkan harga
        if ($request->min_harga) $query->where('harga', '>=', $request->min_harga);
        if ($request->max_harga) $query->where('harga', '<=', $request->max_harga);

        // Filter berdasarkan tahun
        if ($request->min_tahun) $query->where('tahun', '>=', $request->min_tahun);
        if ($request->max_tahun) $query->where('tahun', '<=', $request->max_tahun);

        // Filter berdasarkan transmisi
        if ($request->transmisi) $query->where('transmisi', $request->transmisi);

        // Filter berdasarkan bahan bakar
        if ($request->bahan_bakar) $query->where('bahan_bakar', $request->bahan_bakar);

        // Filter berdasarkan jumlah seater
        if ($request->seater) $query->where('seater', $request->seater);

        // Urutkan berdasarkan total bobot (c1 + c2 + c3 + c4 + c5)
        $mobils = $query->get()->sortByDesc(fn($mobil) => $mobil->c1 + $mobil->c2 + $mobil->c3 + $mobil->c4 + $mobil->c5);

        return view('mobil.index', compact('mobils'));
    }

    /**
     * Konversi harga menjadi bobot kriteria C1
     */
    private function convertHargaToC1($harga)
    {
        return match (true) {
            $harga < 50000000     => 5,
            $harga <= 100000000   => 4,
            $harga <= 200000000   => 3,
            $harga <= 500000000   => 2,
            default               => 1,
        };
    }

    /**
     * Konversi tahun produksi menjadi bobot kriteria C2
     */
    private function convertTahunToC2($tahun)
    {
        return match (true) {
            $tahun <= 2005  => 1,
            $tahun <= 2010  => 2,
            $tahun <= 2015  => 3,
            $tahun <= 2020  => 4,
            default         => 5,
        };
    }

    /**
     * Konversi jenis transmisi menjadi bobot kriteria C3
     */
    private function convertTransmisiToC3($transmisi)
    {
        return [
            'Manual' => 1,
            'Matic'  => 2,
            'CVT'    => 3,
        ][$transmisi] ?? 1;
    }

    /**
     * Konversi jenis bahan bakar menjadi bobot kriteria C4
     */
    private function convertBahanBakarToC4($bahan_bakar)
    {
        return [
            'Bensin'  => 5,
            'Listrik' => 3,
            'Diesel'  => 1,
        ][$bahan_bakar] ?? 1;
    }

    /**
     * Konversi jumlah seater menjadi bobot kriteria C5
     */
    private function convertSeaterToC5($seater)
    {
        return match ($seater) {
            2  => 1,
            3  => 2,
            4  => 3,
            6  => 4,
            default => 5,
        };
    }
}

@extends('layouts.app')

@section('title', 'Tambah Mobil')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-primary fw-bold">🚗 Tambah Mobil</h1>

        {{-- Tampilkan error validasi jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Tambah Mobil --}}
        <form action="{{ route('mobils.store') }}" method="POST">
            @csrf

            {{-- Input Nama Mobil --}}
            <div class="form-floating mb-3">
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama mobil"
                    required>
                <label for="nama">Nama Mobil</label>
            </div>

            {{-- Input Harga --}}
            <div class="form-floating mb-3">
                <input type="text" id="harga_format" class="form-control" placeholder="Masukkan harga (Rp)" required>
                <label for="harga_format">Harga (Rp)</label>
                <input type="hidden" name="harga" id="harga"> {{-- Input hidden untuk mengirim data tanpa titik --}}
            </div>

            {{-- Input Tahun --}}
            <div class="form-floating mb-3">
                <input type="number" name="tahun" id="tahun" class="form-control"
                    placeholder="Masukkan tahun produksi" min="1900" max="{{ date('Y') }}" required>
                <label for="tahun">Tahun Produksi</label>
            </div>

            {{-- Pilihan Transmisi --}}
            <div class="form-floating mb-3">
                <select name="transmisi" id="transmisi" class="form-select" required>
                    <option value="" disabled selected>Pilih jenis transmisi</option>
                    <option value="Manual">Manual</option>
                    <option value="Matic">Matic</option>
                    <option value="CVT">CVT</option>
                </select>
                <label for="transmisi">Transmisi</label>
            </div>

            {{-- Pilihan Bahan Bakar --}}
            <div class="form-floating mb-3">
                <select name="bahan_bakar" id="bahan_bakar" class="form-select" required>
                    <option value="" disabled selected>Pilih jenis bahan bakar</option>
                    <option value="Bensin">Bensin</option>
                    <option value="Listrik">Listrik</option>
                    <option value="Diesel">Diesel</option>
                </select>
                <label for="bahan_bakar">Bahan Bakar</label>
            </div>

            {{-- Pilihan Seater --}}
            <div class="form-floating mb-3">
                <select name="seater" id="seater" class="form-select" required>
                    <option value="" disabled selected>Pilih jumlah kursi</option>
                    <option value="2">2 Kursi</option>
                    <option value="4">4 Kursi</option>
                    <option value="5">5 Kursi</option>
                    <option value="7">7 Kursi</option>
                    <option value="8">8 Kursi</option>
                    <option value="9">9 Kursi</option>
                    <option value="10">10+ Kursi</option>
                </select>
                <label for="seater">Jumlah Kursi</label>
            </div>

            {{-- Tombol Submit & Kembali --}}
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-success w-50">✔ Simpan</button>
                <a href="{{ route('mobils.index') }}" class="btn btn-secondary w-50">🔙 Kembali</a>
            </div>
        </form>
    </div>

    {{-- Script untuk format harga --}}
    <script>
        document.getElementById('harga_format').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Hapus karakter non-angka
            let formattedValue = new Intl.NumberFormat('id-ID').format(value); // Format angka ke ribuan
            e.target.value = 'Rp ' + formattedValue; // Tambahkan simbol Rp
            document.getElementById('harga').value = value; // Simpan nilai asli tanpa titik ke input hidden
        });
    </script>
@endsection

@extends('layouts.app')

@section('title', 'Tambah Mobil')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
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
        <form action="{{ route('mobils.store') }}" method="POST" onsubmit="cleanHarga()">
            @csrf

            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Fitur</th>
                        <th>Input Data</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Input Nama Mobil --}}
                    <tr>
                        <td>Nama Mobil</td>
                        <td>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama mobil" required>
                        </td>
                    </tr>

                    {{-- Input Harga --}}
                    <tr>
                        <td>Harga (Rp)</td>
                        <td>
                            <input type="text" name="harga" id="harga" class="form-control" placeholder="Masukkan harga mobil" value="{{ old('harga') }}" oninput="formatHarga(this)" required>
                        </td>
                    </tr>

                    {{-- Input Tahun --}}
                    <tr>
                        <td>Tahun Produksi</td>
                        <td>
                            <input type="number" name="tahun" min="1900" max="{{ date('Y') }}" class="form-control" required>
                        </td>
                    </tr>

                    {{-- Pilihan Transmisi --}}
                    <tr>
                        <td>Transmisi</td>
                        <td>
                            <select name="transmisi" id="transmisi" class="form-select" required>
                                <option value="" disabled selected>Pilih jenis transmisi</option>
                                <option value="Manual">Manual</option>
                                <option value="Matic">Matic</option>
                                <option value="CVT">CVT</option>
                            </select>
                        </td>
                    </tr>

                    {{-- Pilihan Bahan Bakar --}}
                    <tr>
                        <td>Bahan Bakar</td>
                        <td>
                            <select name="bahan_bakar" id="bahan_bakar" class="form-select" required>
                                <option value="" disabled selected>Pilih jenis bahan bakar</option>
                                <option value="Bensin">Bensin</option>
                                <option value="Listrik">Listrik</option>
                                <option value="Diesel">Diesel</option>
                            </select>
                        </td>
                    </tr>

                    {{-- Pilihan Seater --}}
                    <tr>
                        <td>Jumlah Kursi</td>
                        <td>
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
                        </td>
                    </tr>

                </tbody>
            </table>

            {{-- Tombol Submit & Kembali --}}
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-success w-50">✔ Simpan</button>
                <a href="{{ route('mobils.index') }}" class="btn btn-secondary w-50">🔙 Kembali</a>
            </div>
        </form>

        <script>
            // Fungsi untuk memformat harga dan menghapus simbol Rp dan titik
            function formatHarga(input) {
                let value = input.value;

                // Hapus simbol 'Rp' dan titik
                value = value.replace(/[^\d]/g, ''); // Hanya biarkan angka
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Format dengan titik ribuan

                input.value = 'Rp ' + value; // Menambahkan simbol 'Rp' kembali
            }

            // Fungsi untuk membersihkan simbol 'Rp' sebelum mengirimkan data
            function cleanHarga() {
                let hargaInput = document.getElementById('harga');
                hargaInput.value = hargaInput.value.replace(/[^\d]/g, ''); // Menghapus simbol 'Rp' dan titik
            }
        </script>
    </div>
@endsection

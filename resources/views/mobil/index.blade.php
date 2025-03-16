@extends('layouts.app')

@section('content')
    <div class="container p-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✅ Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2 class="mb-4 fw-bold">📋 Daftar Mobil</h2>

        <!-- Tombol Tambah Data, Normalisasi & Rekomendasi -->
        <div class="mb-3 d-flex">
            <a href="{{ route('mobils.create') }}" class="btn btn-primary me-2">
                ➕ Tambah Data
            </a>
            <a href="{{ route('normalisasi') }}" class="btn btn-success me-2">
                📊 Lihat Normalisasi
            </a>
            <a href="{{ route('rekomendasi.index') }}" class="btn btn-warning">
                🔮 Lihat Rekomendasi
            </a>
        </div>

        <!-- Form Pencarian Mobil -->
        <div class="card p-4 mb-4 shadow">
            <h4 class="fw-bold">🔎 Cari Mobil</h4>
            <form action="{{ route('mobils.search') }}" method="GET">
                <div class="row g-3">
                    <!-- Input Min Harga -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="min_harga" name="min_harga" class="form-control"
                                placeholder="Min Harga">
                        </div>
                    </div>
                    <!-- Input Max Harga -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="max_harga" name="max_harga" class="form-control"
                                placeholder="Max Harga">
                        </div>
                    </div>
                    <!-- Input Min Tahun -->
                    <div class="col-md-4">
                        <input type="number" name="min_tahun" class="form-control" placeholder="Min Tahun">
                    </div>
                    <!-- Input Max Tahun -->
                    <div class="col-md-4">
                        <input type="number" name="max_tahun" class="form-control" placeholder="Max Tahun">
                    </div>
                    <!-- Pilihan Transmisi -->
                    <div class="col-md-4">
                        <select name="transmisi" class="form-select">
                            <option value="">Semua Transmisi</option>
                            <option value="Manual">Manual</option>
                            <option value="Matic">Matic</option>
                            <option value="CVT">CVT</option>
                        </select>
                    </div>
                    <!-- Pilihan Bahan Bakar -->
                    <div class="col-md-4">
                        <select name="bahan_bakar" class="form-select">
                            <option value="">Semua Bahan Bakar</option>
                            <option value="Bensin">Bensin</option>
                            <option value="Listrik">Listrik</option>
                            <option value="Diesel">Diesel</option>
                        </select>
                    </div>
                    <!-- Pilihan Seater -->
                    <div class="col-md-4">
                        <select name="seater" class="form-select">
                            <option value="">Semua Seater</option>
                            <option value="2">2 Seater</option>
                            <option value="4">4 Seater</option>
                            <option value="5">5 Seater</option>
                            <option value="7">7 Seater</option>
                            <option value="8">8 Seater</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">
                    🔍 Cari Mobil
                </button>
            </form>
        </div>

        <!-- Tabel Data Mobil -->
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Tahun</th>
                        <th>Transmisi</th>
                        <th>Bahan Bakar</th>
                        <th>Seater</th>
                        <th>Bobot</th>
                        <th>Aksi</th> <!-- Tambahkan Kolom Aksi -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mobils as $mobil)
                        <tr class="{{ $loop->first ? 'table-warning fw-bold' : '' }}">
                            <td>{{ $mobil->nama }}</td>
                            <td>Rp{{ number_format($mobil->harga, 0, ',', '.') }}</td>
                            <td>{{ $mobil->tahun }}</td>
                            <td>{{ $mobil->transmisi }}</td>
                            <td>{{ $mobil->bahan_bakar }}</td>
                            <td>{{ $mobil->seater }}</td>
                            <td class="fw-bold">{{ $mobil->c1 + $mobil->c2 + $mobil->c3 + $mobil->c4 + $mobil->c5 }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('mobils.edit', $mobil->id) }}" class="btn btn-warning btn-sm">
                                    ✏ Edit
                                </a>

                                <!-- Tombol Hapus dengan Konfirmasi -->
                                <form action="{{ route('mobils.destroy', $mobil->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus mobil ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        ❌ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-danger">❌ Tidak ada mobil yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tombol Reset Pencarian -->
        @if (request()->has('min_harga') ||
                request()->has('max_harga') ||
                request()->has('min_tahun') ||
                request()->has('max_tahun') ||
                request()->has('transmisi') ||
                request()->has('bahan_bakar') ||
                request()->has('seater'))
            <div class="text-center mt-3">
                <a href="{{ route('mobils.index') }}" class="btn btn-danger">
                    🔄 Reset Pencarian
                </a>
            </div>
        @endif

        <!-- Format Harga dengan Titik -->
        <script>
            function formatRupiah(element) {
                element.addEventListener('input', function(e) {
                    let value = this.value.replace(/\D/g, '');
                    value = new Intl.NumberFormat('id-ID').format(value);
                    this.value = value;
                });
            }

            formatRupiah(document.getElementById('min_harga'));
            formatRupiah(document.getElementById('max_harga'));
        </script>
    </div>
@endsection

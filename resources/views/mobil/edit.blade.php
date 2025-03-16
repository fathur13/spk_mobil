@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <h2 class="mb-4 fw-bold">✏ Edit Data Mobil</h2>

        <div class="card p-4 shadow">
            <form action="{{ route('mobils.update', $mobil->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Mobil</label>
                    <input type="text" id="nama" name="nama" class="form-control" value="{{ $mobil->nama }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" id="harga" name="harga" class="form-control" value="{{ $mobil->harga }}" required>
                </div>

                <div class="mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="number" id="tahun" name="tahun" class="form-control" value="{{ $mobil->tahun }}" required>
                </div>

                <div class="mb-3">
                    <label for="transmisi" class="form-label">Transmisi</label>
                    <select id="transmisi" name="transmisi" class="form-select" required>
                        <option value="Manual" {{ $mobil->transmisi == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Matic" {{ $mobil->transmisi == 'Matic' ? 'selected' : '' }}>Matic</option>
                        <option value="CVT" {{ $mobil->transmisi == 'CVT' ? 'selected' : '' }}>CVT</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="bahan_bakar" class="form-label">Bahan Bakar</label>
                    <select id="bahan_bakar" name="bahan_bakar" class="form-select" required>
                        <option value="Bensin" {{ $mobil->bahan_bakar == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                        <option value="Listrik" {{ $mobil->bahan_bakar == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                        <option value="Diesel" {{ $mobil->bahan_bakar == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="seater" class="form-label">Jumlah Seater</label>
                    <input type="number" id="seater" name="seater" class="form-control" value="{{ $mobil->seater }}" required>
                </div>

                <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
                <a href="{{ route('mobils.index') }}" class="btn btn-secondary">🔙 Kembali</a>
            </form>
        </div>
    </div>
@endsection

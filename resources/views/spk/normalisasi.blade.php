@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-center mb-4 fw-bold text-primary">📊 Hasil Normalisasi</h1>

        <!-- Notifikasi Error -->
        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>🚗 Nama Mobil</th>
                                <th>C1 (Harga)</th>
                                <th>C2 (Tahun)</th>
                                <th>C3 (Transmisi)</th>
                                <th>C4 (Bahan Bakar)</th>
                                <th>C5 (Seater)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mobils as $mobil)
                                <tr class="fw-semibold">
                                    <td class="text-primary">{{ $mobil->nama }}</td>
                                    <td class="text-success">{{ number_format($mobil->n_c1, 4) }}</td>
                                    <td class="text-warning">{{ number_format($mobil->n_c2, 4) }}</td>
                                    <td class="text-info">{{ number_format($mobil->n_c3, 4) }}</td>
                                    <td class="text-danger">{{ number_format($mobil->n_c4, 4) }}</td>
                                    <td class="text-secondary">{{ number_format($mobil->n_c5, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center mt-4">
            <a href="{{ route('mobils.index') }}" class="btn btn-primary shadow-sm">
                ⬅ Kembali ke Index
            </a>
        </div>
    </div>
@endsection

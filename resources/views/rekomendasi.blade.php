@extends('layouts.app')

@section('content')

    <div class="container py-4">
        <h2 class="text-center fw-bold text-primary mb-4">🚗 Rekomendasi Mobil Terbaik</h2>

        <!-- Notifikasi Kesalahan -->
        @if (session('error'))
            <div class="alert alert-warning text-center">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if (count($normalized) > 0)
            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>🏆 Peringkat</th>
                                    <th>🚘 Nama Mobil</th>
                                    <th>⭐ Skor Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($normalized as $key => $mobil)
                                    <tr class="{{ $key === 0 ? 'table-warning fw-bold' : '' }}">
                                        <td class="fw-bold text-danger">{{ $key + 1 }}</td>
                                        <td class="text-primary">{{ $mobil['nama'] }}</td>
                                        <td class="text-success">{{ number_format($mobil['skor'], 4) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                ❌ Tidak ada data mobil yang tersedia.
            </div>
        @endif

        <!-- Tombol Kembali -->
        <div class="text-center mt-4">
            <a href="{{ route('mobils.index') }}" class="btn btn-primary shadow-sm">
                🔙 Kembali ke Daftar Mobil
            </a>
        </div>
    </div>

@endsection

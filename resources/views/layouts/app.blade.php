<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Konfigurasi Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Judul Halaman dengan Fallback -->
    <title>@yield('title', 'SPK Mobil')</title>

    <!-- CDN Bootstrap 5 untuk Styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Tambahan CSS Kustom Jika Diperlukan -->
    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">🚗 SPK Mobil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mobils.index') }}">Daftar Mobil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('normalisasi') }}">Normalisasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rekomendasi.index') }}">Rekomendasi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Kontainer Utama -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- CDN Bootstrap 5 untuk Interaksi -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tambahan JavaScript Kustom Jika Diperlukan -->
    @stack('scripts')

</body>
</html>

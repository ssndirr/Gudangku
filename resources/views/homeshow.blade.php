<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang - GudangKu</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Warehouse Theme CSS -->
    <link href="{{ asset('css/warehouse-theme.css') }}" rel="stylesheet">
</head>
<body>

<!-- Background Overlay -->
<div class="overlay-gradient"></div>

<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-warehouse shadow-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-boxes me-2"></i>GudangKu
            </a>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-5">

        <!-- Page Header -->
        <div class="text-center mb-4 page-header">
            <h2 class="fw-bold">
                <i class="bi bi-info-circle me-2"></i>Detail Barang
            </h2>
            <p class="mb-0 opacity-75">Informasi lengkap tentang barang</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card shadow-lg">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-box-seam me-2"></i>
                            {{ $customData['nama_barang'] }}
                        </h4>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">

                            @isset($customData['kategori'])
                            <li class="list-group-item">
                                <div class="info-item">
                                    <i class="bi bi-tag text-warehouse-primary"></i>
                                    <div class="info-content">
                                        <strong>Kategori</strong>
                                        <div class="mt-1">{{ $customData['kategori'] }}</div>
                                    </div>
                                </div>
                            </li>
                            @endisset

                            @isset($customData['ruangan'])
                            <li class="list-group-item">
                                <div class="info-item">
                                    <i class="bi bi-door-open text-warehouse-secondary"></i>
                                    <div class="info-content">
                                        <strong>Ruangan</strong>
                                        <div class="mt-1">{{ $customData['ruangan'] }}</div>
                                    </div>
                                </div>
                            </li>
                            @endisset

                            @isset($customData['lokasi'])
                            <li class="list-group-item">
                                <div class="info-item">
                                    <i class="bi bi-geo-alt text-warehouse-danger"></i>
                                    <div class="info-content">
                                        <strong>Alamat Lokasi</strong>
                                        <div class="mt-1">{{ $customData['lokasi'] }}</div>
                                    </div>
                                </div>
                            </li>
                            @endisset

                            @isset($customData['stok'])
                            <li class="list-group-item">
                                <div class="info-item">
                                    <i class="bi bi-box2 text-warehouse-success"></i>
                                    <div class="info-content">
                                        <strong>Stok Tersedia</strong>
                                        <div class="mt-2">
                                            @if($customData['stok'] > 10)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-boxes me-1"></i>{{ $customData['stok'] }} Unit
                                                </span>
                                            @elseif($customData['stok'] > 0)
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-boxes me-1"></i>{{ $customData['stok'] }} Unit
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-boxes me-1"></i>{{ $customData['stok'] }} Unit - Habis
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endisset

                        </ul>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Katalog
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
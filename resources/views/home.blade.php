<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GudangKu - Sistem Manajemen Inventori</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-boxes me-2"></i>GudangKu
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i>Beranda
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav">
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
    </div>
</nav>

<!-- Main Content -->
<div class="container py-4">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold mb-1">Katalog Barang</h2>
            <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('home') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-10">
                        <label for="search" class="form-label fw-semibold">Cari Barang</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Ketik nama barang..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>Cari
                        </button>
                    </div>
                </div>

                <div class="mt-2">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Items List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Daftar Barang</h5>
                <span class="badge bg-primary rounded-pill">{{ $barangs->total() }} Item</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($barangs as $barang)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="mb-2">
                                <i class="bi bi-box-seam text-primary me-2"></i>{{ $barang->nama_barang }}
                            </h5>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-info">
                                    <i class="bi bi-tag me-1"></i>{{ $barang->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                </span>
                                <span class="badge bg-secondary">
                                    <i class="bi bi-door-open me-1"></i>{{ $barang->ruangan->nama_ruangan ?? 'Tanpa Ruangan' }}
                                </span>
                            </div>
                        </div>
                        <div class="ms-3">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>Detail
                        </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="list-group-item text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Tidak ada barang ditemukan</h5>
                    <p class="text-muted mb-0">Coba ubah pencarian atau tambahkan barang baru</p>
                </div>
                @endforelse
            </div>
        </div>

        @if($barangs->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-center">
                {{ $barangs->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

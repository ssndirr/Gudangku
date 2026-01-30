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
    <!-- Warehouse Theme CSS -->
    <link href="{{ asset('css/warehouse-theme.css') }}" rel="stylesheet">
    <style>
        .nav-pills .nav-link {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .nav-pills .nav-link:hover {
            background-color: rgba(13, 110, 253, 0.1);
            transform: translateY(-2px);
        }
        .nav-pills .nav-link.active {
            background-color: #0d6efd;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.3);
        }
        .ruangan-badge {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
        }
    </style>
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
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    @endif
                    @if(Auth::check() && Auth::user()->role === 'staff' && Auth::user()->ruangan_id)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.order') }}">
                            <i class="bi bi-cart-check me-1"></i>Transaksi
                        </a>
                    </li>
                    @endif
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
                <h2 class="fw-bold mb-2 page-title">
                    <i class="bi bi-collection me-2"></i>Katalog Barang
                </h2>
                <p class="text-warehouse mb-0">
                    <i class="bi bi-person-badge me-1"></i>Selamat datang, <strong>{{ Auth::user()->name }}</strong>
                    @if(Auth::user()->role === 'staff' && Auth::user()->ruangan)
                        <span class="badge bg-info ms-2">
                            <i class="bi bi-door-open me-1"></i>Ruangan Anda: {{ Auth::user()->ruangan->nama_ruangan }}
                        </span>
                    @elseif(Auth::user()->role === 'admin')
                        <span class="badge bg-purple ms-2">
                            <i class="bi bi-shield-check me-1"></i>Administrator
                        </span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Search/Filter Section -->
        <div class="card shadow-lg mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('home') }}" id="filterForm">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-10">
                            <label for="search" class="form-label fw-semibold">
                                <i class="bi bi-search me-2"></i>Cari Barang
                            </label>
                            <input type="text" name="search" id="search" class="form-control" placeholder="Ketik nama barang..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Cari
                            </button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Filter
                        </a>
                        @if(request('search'))
                            <span class="badge bg-primary ms-2">
                                <i class="bi bi-funnel me-1"></i>Filter Aktif: "{{ request('search') }}"
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabs untuk Lihat Semua Ruangan (Staff & Admin) -->
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-gradient">
                <h5 class="mb-0">
                    <i class="bi bi-building me-2"></i>
                    @if(Auth::user()->role === 'staff')
                        Lihat Stok Barang
                    @else
                        Daftar Barang Per Ruangan
                    @endif
                </h5>
            </div>
            <div class="card-body">
                
                <ul class="nav nav-pills mb-3 flex-wrap gap-2" role="tablist">
                    @foreach($ruangans as $index => $ruangan)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ Auth::user()->role === 'staff' ? ($ruangan->id == Auth::user()->ruangan_id ? 'active' : '') : ($index == 0 ? 'active' : '') }} ruangan-badge" 
                                    id="ruangan-{{ $ruangan->id }}-tab" 
                                    data-bs-toggle="pill" 
                                    data-bs-target="#ruangan-{{ $ruangan->id }}" 
                                    type="button" 
                                    role="tab">
                                <i class="bi {{ Auth::user()->role === 'staff' && $ruangan->id == Auth::user()->ruangan_id ? 'bi-house-check-fill' : 'bi-building' }} me-2"></i>
                                {{ $ruangan->nama_ruangan }}
                                @if(Auth::user()->role === 'staff' && $ruangan->id == Auth::user()->ruangan_id)
                                    <span class="badge bg-success ms-2">Ruangan Anda</span>
                                @endif
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($ruangans as $index => $ruangan)
                        <div class="tab-pane fade {{ Auth::user()->role === 'staff' ? ($ruangan->id == Auth::user()->ruangan_id ? 'show active' : '') : ($index == 0 ? 'show active' : '') }}" 
                             id="ruangan-{{ $ruangan->id }}" 
                             role="tabpanel">
                            
                            <!-- Info Ruangan -->
                            <div class="alert {{ Auth::user()->role === 'staff' && $ruangan->id == Auth::user()->ruangan_id ? 'alert-info' : 'alert-secondary' }} mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">
                                            <i class="bi bi-geo-alt me-2"></i>{{ $ruangan->nama_ruangan }}
                                        </h6>
                                        <small>
                                            <i class="bi bi-pin-map me-1"></i>{{ $ruangan->lokasi }}
                                        </small>
                                    </div>
                                    @if(Auth::user()->role === 'staff')
                                        @if($ruangan->id == Auth::user()->ruangan_id)
                                            <span class="badge bg-primary">
                                                <i class="bi bi-check-circle me-1"></i>Ruangan Anda
                                            </span>
                                        @else
                                            <span class="badge bg-primary">
                                                <i class="bi bi-check-circle me-1"></i>Ruangan Lain
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <!-- List Barang per Ruangan -->
                            <div class="list-group">
                                @php
                                    $searchTerm = request('search');
                                    $queryBarang = \App\Models\Barang::with(['kategori'])
                                        ->where('ruangan_id', $ruangan->id);
                                    
                                    if ($searchTerm) {
                                        $queryBarang->where('nama_barang', 'like', "%{$searchTerm}%");
                                    }
                                    
                                    $barangsRuangan = $queryBarang->orderBy('nama_barang')->get();
                                @endphp

                                @forelse($barangsRuangan as $barang)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-2 fw-bold">
                                                    <i class="bi bi-box-seam me-2"></i>{{ $barang->nama_barang }}
                                                </h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge bg-info">
                                                        <i class="bi bi-tag me-1"></i>{{ $barang->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                                    </span>
                                                    @if($barang->stok > 10)
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-boxes me-1"></i>Stok: {{ $barang->stok }}
                                                        </span>
                                                    @elseif($barang->stok > 0)
                                                        <span class="badge bg-warning">
                                                            <i class="bi bi-boxes me-1"></i>Stok: {{ $barang->stok }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="bi bi-boxes me-1"></i>Stok: {{ $barang->stok }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <a href="{{ route('home.show', $barang) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>Detail
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox display-6"></i>
                                        @if($searchTerm)
                                            <p class="mb-0 mt-2">Tidak ada barang yang cocok dengan pencarian "{{ $searchTerm }}"</p>
                                        @else
                                            <p class="mb-0 mt-2">Belum ada barang di ruangan ini</p>
                                        @endif
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
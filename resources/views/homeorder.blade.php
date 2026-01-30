<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Barang - GudangKu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home.order') }}">
                            <i class="bi bi-cart-check me-1"></i>Transaksi
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
                <h2 class="fw-bold mb-2 page-title">
                    <i class="bi bi-cart-check me-2"></i>Transaksi Barang
                </h2>
                <p class="text-warehouse mb-0">
                    <i class="bi bi-door-open me-1"></i>Ruangan: <strong>{{ Auth::user()->ruangan->nama_ruangan }}</strong>
                    <span class="badge bg-info ms-2">{{ Auth::user()->ruangan->lokasi }}</span>
                </p>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Transaction Forms -->
        <div class="row mb-4">
            <!-- Barang Masuk Form -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-lg h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-arrow-down-circle me-2"></i>Barang Masuk
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('home.order.masuk') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="barang_masuk" class="form-label fw-semibold">
                                    Pilih Barang <span class="text-danger">*</span>
                                </label>
                                <select name="barang_id" id="barang_masuk" class="form-select select2-barang-masuk @error('barang_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih atau Cari Barang --</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" 
                                                data-stok="{{ $barang->stok }}"
                                                data-kategori="{{ $barang->kategori->nama_kategori }}"
                                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang }} - {{ $barang->kategori->nama_kategori }} (Stok: {{ $barang->stok }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="stok-masuk-info" class="mt-2 text-muted small" style="display: none;">
                                    <i class="bi bi-info-circle me-1"></i>Stok saat ini: <strong id="stok-masuk-value">0</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_masuk" class="form-label fw-semibold">
                                    Tanggal Masuk <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jumlah_masuk" class="form-label fw-semibold">
                                    Jumlah Masuk <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="jumlah" id="jumlah_masuk" class="form-control @error('jumlah') is-invalid @enderror" min="1" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah" required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Barang Masuk
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Barang Keluar Form -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-lg h-100">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-arrow-up-circle me-2"></i>Barang Keluar
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('home.order.keluar') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="barang_keluar" class="form-label fw-semibold">
                                    Pilih Barang <span class="text-danger">*</span>
                                </label>
                                <select name="barang_id" id="barang_keluar" class="form-select select2-barang-keluar @error('barang_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih atau Cari Barang --</option>
                                    @foreach($barangs->where('stok', '>', 0) as $barang)
                                        <option value="{{ $barang->id }}" 
                                                data-stok="{{ $barang->stok }}"
                                                data-kategori="{{ $barang->kategori->nama_kategori }}"
                                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang }} - {{ $barang->kategori->nama_kategori }} (Stok: {{ $barang->stok }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="stok-keluar-info" class="mt-2 text-muted small" style="display: none;">
                                    <i class="bi bi-info-circle me-1"></i>Stok tersedia: <strong id="stok-keluar-value">0</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_keluar" class="form-label fw-semibold">
                                    Tanggal Keluar <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror" value="{{ old('tanggal_keluar', date('Y-m-d')) }}" required>
                                @error('tanggal_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jumlah_keluar" class="form-label fw-semibold">
                                    Jumlah Keluar <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="jumlah" id="jumlah_keluar" class="form-control @error('jumlah') is-invalid @enderror" min="1" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah" required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-dash-circle me-2"></i>Tambah Barang Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="row">
            <!-- Riwayat Barang Masuk -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history me-2"></i>Riwayat Barang Masuk (10 Terakhir)
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto;">
                            @forelse($barangMasuks as $masuk)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $masuk->barang->nama_barang }}</h6>
                                            <p class="mb-1 small text-muted">
                                                <i class="bi bi-tag me-1"></i>{{ $masuk->barang->kategori->nama_kategori }}
                                            </p>
                                            <p class="mb-0 small text-muted">
                                                <i class="bi bi-calendar me-1"></i>{{ $masuk->tanggal_masuk->format('d M Y') }}
                                                <span class="ms-2">
                                                    <i class="bi bi-person me-1"></i>{{ $masuk->user->name ?? 'System' }}
                                                </span>
                                            </p>
                                        </div>
                                        <span class="badge bg-success">
                                            <i class="bi bi-arrow-up me-1"></i>+{{ $masuk->jumlah }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item text-center py-4">
                                    <i class="bi bi-inbox display-6 text-muted"></i>
                                    <p class="mb-0 mt-2 text-muted">Belum ada transaksi</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Barang Keluar -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history me-2"></i>Riwayat Barang Keluar (10 Terakhir)
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto;">
                            @forelse($barangKeluars as $keluar)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $keluar->barang->nama_barang }}</h6>
                                            <p class="mb-1 small text-muted">
                                                <i class="bi bi-tag me-1"></i>{{ $keluar->barang->kategori->nama_kategori }}
                                            </p>
                                            <p class="mb-0 small text-muted">
                                                <i class="bi bi-calendar me-1"></i>{{ $keluar->tanggal_keluar->format('d M Y') }}
                                                <span class="ms-2">
                                                    <i class="bi bi-person me-1"></i>{{ $keluar->user->name ?? 'System' }}
                                                </span>
                                            </p>
                                        </div>
                                        <span class="badge bg-danger">
                                            <i class="bi bi-arrow-down me-1"></i>-{{ $keluar->jumlah }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item text-center py-4">
                                    <i class="bi bi-inbox display-6 text-muted"></i>
                                    <p class="mb-0 mt-2 text-muted">Belum ada transaksi</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for Barang Masuk
        $('.select2-barang-masuk').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: '-- Ketik untuk mencari barang --',
            allowClear: true,
            language: {
                noResults: function() {
                    return "Barang tidak ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            }
        }).on('change', function() {
            updateStokMasuk();
        });

        // Initialize Select2 for Barang Keluar
        $('.select2-barang-keluar').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: '-- Ketik untuk mencari barang --',
            allowClear: true,
            language: {
                noResults: function() {
                    return "Barang tidak ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            }
        }).on('change', function() {
            updateStokKeluar();
        });
    });

    function updateStokMasuk() {
        const select = document.getElementById('barang_masuk');
        const stokInfo = document.getElementById('stok-masuk-info');
        const stokValue = document.getElementById('stok-masuk-value');
        
        if (select.value) {
            const selectedOption = select.options[select.selectedIndex];
            const stok = selectedOption.getAttribute('data-stok');
            
            stokValue.textContent = stok;
            stokInfo.style.display = 'block';
        } else {
            stokInfo.style.display = 'none';
        }
    }

    function updateStokKeluar() {
        const select = document.getElementById('barang_keluar');
        const stokInfo = document.getElementById('stok-keluar-info');
        const stokValue = document.getElementById('stok-keluar-value');
        const jumlahInput = document.getElementById('jumlah_keluar');
        
        if (select.value) {
            const selectedOption = select.options[select.selectedIndex];
            const stok = selectedOption.getAttribute('data-stok');
            
            stokValue.textContent = stok;
            stokInfo.style.display = 'block';
            jumlahInput.setAttribute('max', stok);
        } else {
            stokInfo.style.display = 'none';
            jumlahInput.removeAttribute('max');
        }
    }

    // Auto-focus jumlah setelah pilih barang
    $('.select2-barang-masuk').on('select2:select', function() {
        setTimeout(function() {
            $('#jumlah_masuk').focus();
        }, 100);
    });

    $('.select2-barang-keluar').on('select2:select', function() {
        setTimeout(function() {
            $('#jumlah_keluar').focus();
        }, 100);
    });
</script>
</body>
</html>
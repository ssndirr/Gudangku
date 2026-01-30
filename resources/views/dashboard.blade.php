<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total User -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Pengguna</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Kategori -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Kategori</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalKategori }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Ruangan -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Ruangan</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalRuangan }}</p>
                        </div>
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-full">
                            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Barang -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Barang</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalBarang }}</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Barang Masuk -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Barang Masuk (Bulan Ini)</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $barangMasukBulanIni }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Barang Keluar -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Barang Keluar (Bulan Ini)</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $barangKeluarBulanIni }}</p>
                        </div>
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Per Ruangan -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <i class="bi bi-building mr-2"></i>Statistik Per Ruangan
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Ruangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total Stok</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Masuk (Bulan Ini)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Keluar (Bulan Ini)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($statsPerRuangan as $stat)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $stat->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $stat->lokasi }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $stat->total_barang }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $stat->total_stok }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            +{{ $stat->barang_masuk }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            -{{ $stat->barang_keluar }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Tidak ada data ruangan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Row 2: Recent Transactions + Low Stock + Top Contributors -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Transactions -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat Transaksi Terbaru</h3>
                        <div class="space-y-3">
                            @forelse($recentTransactions as $transaction)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center space-x-3 flex-1">
                                    <div class="p-2 {{ $transaction->type == 'masuk' ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900' }} rounded">
                                        <svg class="w-4 h-4 {{ $transaction->type == 'masuk' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $transaction->type == 'masuk' ? 'M19 14l-7 7m0 0l-7-7m7 7V3' : 'M5 10l7-7m0 0l7 7m-7-7v18' }}"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->barang_name }}</p>
                                        <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                {{ $transaction->ruangan }}
                                            </span>
                                            <span>•</span>
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                {{ $transaction->user_name }}
                                            </span>
                                            <span>•</span>
                                            <span>{{ $transaction->tanggal->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <span class="text-sm font-semibold {{ $transaction->type == 'masuk' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $transaction->type == 'masuk' ? '+' : '-' }}{{ $transaction->jumlah }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                Belum ada transaksi
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Low Stock + Top Contributors -->
                <div class="space-y-6">
                    <!-- Low Stock Alert -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Stok Menipis</h3>
                            <div class="space-y-3">
                                @forelse($lowStockItems as $item)
                                <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->nama }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->ruangan }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-red-600 dark:text-red-400">{{ $item->stok }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">unit</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Semua stok aman!
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Top Contributors -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Staff Aktif</h3>
                            <div class="space-y-3">
                                @forelse($topContributors as $contributor)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                            <span class="text-indigo-600 dark:text-indigo-300 font-medium text-sm">
                                                {{ strtoupper(substr($contributor->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $contributor->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $contributor->ruangan }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $contributor->total_transaksi }}</p>
                                        <div class="flex items-center space-x-1 text-xs">
                                            <span class="text-green-600 dark:text-green-400">+{{ $contributor->barang_masuk }}</span>
                                            <span class="text-gray-400">|</span>
                                            <span class="text-red-600 dark:text-red-400">-{{ $contributor->barang_keluar }}</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    Belum ada aktivitas
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
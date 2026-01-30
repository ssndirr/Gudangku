<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('barangmasuk.index') }}" class="mr-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tambah Barang Masuk</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($barangs->isEmpty())
                <div class="mb-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-yellow-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Belum Ada Barang</h3>
                            <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                                Anda perlu menambahkan barang terlebih dahulu.
                            </p>
                            <div class="mt-3">
                                <a href="{{ route('barang.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-md transition">
                                    Tambah Barang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('barangmasuk.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="barang_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pilih Barang <span class="text-red-500">*</span>
                            </label>
                            <select id="barang_id" name="barang_id" required
                                    {{ $barangs->isEmpty() ? 'disabled' : '' }}
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('barang_id') border-red-500 @enderror">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }} ({{ $barang->kategori->nama_kategori }}) - Stok: {{ $barang->stok }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Masuk <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('tanggal_masuk') border-red-500 @enderror">
                            @error('tanggal_masuk')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jumlah Masuk <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required min="1"
                                   placeholder="Masukkan jumlah barang yang masuk"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('jumlah') border-red-500 @enderror">
                            @error('jumlah')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('barangmasuk.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 rounded-md transition">
                                Batal
                            </a>
                            <button type="submit" 
                                    {{ $barangs->isEmpty() ? 'disabled' : '' }}
                                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition disabled:opacity-50 disabled:cursor-not-allowed">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
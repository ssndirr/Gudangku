<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('barangkeluar.index') }}"
               class="mr-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Data Barang Keluar') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('barangkeluar.store') }}">
                        @csrf

                        {{-- Tanggal Keluar --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Keluar
                            </label>
                            <input type="date"
                                   name="tanggal_keluar"
                                   value="{{ old('tanggal_keluar') }}"
                                   required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700
                                          dark:bg-gray-900 dark:text-gray-300
                                          focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- Barang --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Barang
                            </label>
                            <select name="barang_id" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700
                                           dark:bg-gray-900 dark:text-gray-300
                                           focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barang as $data)
                                    <option value="{{ $data->id_barang }}">
                                        {{ $data->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jumlah Keluar
                            </label>
                            <input type="number"
                                   name="jumlah"
                                   value="{{ old('jumlah') }}"
                                   required
                                   min="1"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700
                                          dark:bg-gray-900 dark:text-gray-300
                                          focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('barangkeluar.index') }}"
                               class="px-4 py-2 bg-gray-300 dark:bg-gray-700
                                      rounded-md text-xs font-semibold text-gray-700 dark:text-gray-300
                                      hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 rounded-md
                                           text-xs font-semibold text-white
                                           hover:bg-indigo-700 transition">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

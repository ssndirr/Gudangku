<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('barang.index') }}"
               class="mr-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Data Barang') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('barang.store') }}">
                        @csrf

                        <!-- Nama Barang -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Barang
                            </label>
                            <input
                                type="text"
                                name="nama_barang"
                                value="{{ old('nama_barang') }}"
                                required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700
                                       dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kategori
                            </label>
                            <select
                                name="kategori_id"
                                required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700
                                       dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $data)
                                    <option value="{{ $data->id_kategori }}">
                                        {{ $data->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ruangan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ruangan
                            </label>
                            <select
                                name="ruangan_id"
                                required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700
                                       dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach ($ruangan as $data)
                                    <option value="{{ $data->id_ruangan }}">
                                        {{ $data->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('barang.index') }}"
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

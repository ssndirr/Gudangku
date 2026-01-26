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
                {{ __('Detail Barang Keluar') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">

                    {{-- Nama Barang --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Barang
                        </label>
                        <input type="text"
                               value="{{ $barangkeluar->barang->nama_barang ?? '-' }}"
                               disabled
                               class="w-full rounded-md border-gray-300 dark:border-gray-700
                                      dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    {{-- Tanggal Keluar --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tanggal Keluar
                        </label>
                        <input type="text"
                               value="{{ $barangkeluar->tanggal_keluar }}"
                               disabled
                               class="w-full rounded-md border-gray-300 dark:border-gray-700
                                      dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    {{-- Jumlah Keluar --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Jumlah Keluar
                        </label>
                        <input type="number"
                               value="{{ $barangkeluar->jumlah }}"
                               disabled
                               class="w-full rounded-md border-gray-300 dark:border-gray-700
                                      dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    {{-- Keterangan (jika ada) --}}
                    @if(isset($barangkeluar->keterangan))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Keterangan
                        </label>
                        <textarea disabled
                                  class="w-full rounded-md border-gray-300 dark:border-gray-700
                                         dark:bg-gray-900 dark:text-gray-300">{{ $barangkeluar->keterangan }}</textarea>
                    </div>
                    @endif

                    {{-- Tombol Kembali --}}
                    <div class="flex justify-end">
                        <a href="{{ route('barangkeluar.index') }}"
                           class="px-4 py-2 bg-indigo-600 rounded-md
                                  text-xs font-semibold text-white
                                  hover:bg-indigo-700 transition">
                            Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('kategori.index') }}"
               class="mr-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Kategori') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">

                    {{-- Nama Kategori --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Kategori
                        </label>
                        <input type="text"
                               value="{{ $kategori->nama_kategori }}"
                               disabled
                               class="w-full rounded-md border-gray-300 dark:border-gray-700
                                      dark:bg-gray-900 dark:text-gray-300">
                    </div>

                    {{-- Tombol Kembali --}}
                    <div class="flex justify-end">
                        <a href="{{ route('kategori.index') }}"
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

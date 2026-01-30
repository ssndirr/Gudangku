<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('ruangan.index') }}" class="mr-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tambah Ruangan Baru</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('ruangan.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="nama_ruangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Ruangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama_ruangan" name="nama_ruangan" value="{{ old('nama_ruangan') }}" required autofocus
                                   placeholder="Contoh: Ruang Meeting, Gudang A, Lab Komputer"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('nama_ruangan') border-red-500 @enderror">
                            @error('nama_ruangan')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="lokasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Lokasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required
                                   placeholder="Contoh: Lantai 1, Gedung A, Wing Timur"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('lokasi') border-red-500 @enderror">
                            @error('lokasi')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('ruangan.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 rounded-md transition">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
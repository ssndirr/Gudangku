<!-- ========================================
     FILE: resources/views/auth/login.blade.php
     ======================================== -->
     <x-guest-layout>
    <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8">
        
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl mb-4 shadow-lg">
                <img src="{{ asset('images/logogk.png') }}"
                    alt="Logo GudangKu"
                    class="w-14 h-14 object-contain">
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">GudangKu</h2>
            <p class="text-gray-600">Sistem Inventaris Mebel</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="nama@email.com"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition-all">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input 
                    id="password" 
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition-all">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Login Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-semibold py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
                Masuk
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-6">
            © 2024 GudangKu
        </p>
    </div>
</x-guest-layout>
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-4 text-center">
        <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">Login Sistem Fotokopi AI</h3>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="block mt-4 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- TOMBOL LOG IN UTAMA (TEKS DIPAKSA MUNCUL DENGAN BACKGROUND DARK/AMBER) -->
        <div class="mt-4">
            <button type="submit" 
                    style="width: 100%; background-color: #f59e0b !important; color: #ffffff !important; padding: 10px 16px; font-weight: bold; border-radius: 6px; border: none; cursor: pointer; font-size: 14px;">
                {{ __('Log in') }}
            </button>
        </div>

        <!-- PEMBATAS (ATAU) -->
        <div class="my-4 flex items-center justify-center">
            <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">ATAU</span>
        </div>

        <!-- TOMBOL GOOGLE LOGIN -->
        <div>
            <a href="{{ route('google.login') }}" 
               style="width: 100%; display: flex; align-items: center; justify-content: center; background-color: #ffffff !important; color: #374151 !important; border: 1px solid #d1d5db; padding: 10px 16px; font-weight: 600; border-radius: 6px; text-decoration: none; font-size: 14px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" style="width: 20px; height: 20px; margin-right: 8px;">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                Sign in with Google
            </a>
        </div>
    </form>
</x-guest-layout>
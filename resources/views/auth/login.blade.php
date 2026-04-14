<x-guest-layout>
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Masuk</h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password" :value="'Password'" />
            <x-text-input id="password" name="password" type="password" class="block mt-1 w-full" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="remember_me" class="text-sm text-gray-600">Ingat saya</label>
        </div>

        <x-primary-button class="w-full justify-center">Masuk</x-primary-button>
    </form>

    <div class="mt-5 text-center text-sm text-gray-500 space-y-1">
        @if (Route::has('password.request'))
            <p><a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">Lupa password?</a></p>
        @endif
        <p>Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar</a></p>
    </div>
</x-guest-layout>

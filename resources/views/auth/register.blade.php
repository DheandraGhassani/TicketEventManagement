<x-guest-layout>
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Buat Akun</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="'Nama'" />
            <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password" :value="'Password'" />
            <x-text-input id="password" name="password" type="password" class="block mt-1 w-full" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="'Konfirmasi Password'" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                class="block mt-1 w-full" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <x-primary-button class="w-full justify-center">Daftar</x-primary-button>
    </form>

    <p class="mt-5 text-center text-sm text-gray-500">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Masuk</a>
    </p>
</x-guest-layout>

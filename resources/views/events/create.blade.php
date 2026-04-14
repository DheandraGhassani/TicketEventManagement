<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">← Kembali</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Event Baru</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="title" :value="'Judul Event *'" />
                        <x-text-input id="title" name="title" type="text" class="w-full mt-1 text-sm"
                            :value="old('title')" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="'Deskripsi'" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="banner" :value="'Banner (maks 2MB)'" />
                        <input id="banner" type="file" name="banner" accept="image/*"
                            class="mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <x-input-error :messages="$errors->get('banner')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="venue_name" :value="'Nama Venue *'" />
                            <x-text-input id="venue_name" name="venue_name" type="text" class="w-full mt-1 text-sm"
                                :value="old('venue_name')" required />
                            <x-input-error :messages="$errors->get('venue_name')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="city" :value="'Kota *'" />
                            <x-text-input id="city" name="city" type="text" class="w-full mt-1 text-sm"
                                :value="old('city')" required />
                            <x-input-error :messages="$errors->get('city')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="address" :value="'Alamat Lengkap'" />
                        <textarea id="address" name="address" rows="2"
                            class="mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="start_date" :value="'Tanggal & Waktu *'" />
                            <x-text-input id="start_date" name="start_date" type="datetime-local"
                                class="w-full mt-1 text-sm" :value="old('start_date')" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="categories_id" :value="'Kategori *'" />
                            <select id="categories_id" name="categories_id" required
                                class="mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('categories_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('categories_id')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="status" :value="'Status *'" />
                            <select id="status" name="status" required
                                class="mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="draft"
                                    {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published"
                                    {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="cancelled"
                                    {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="completed"
                                    {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-1" />
                        </div>
                        <div class="flex items-center mt-6">
                            <input type="checkbox" name="is_featured" value="1" id="is_featured"
                                {{ old('is_featured') ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <x-input-label for="is_featured" :value="'Tampilkan sebagai Featured'" class="ml-2" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('events.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <x-primary-button>Simpan Event</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

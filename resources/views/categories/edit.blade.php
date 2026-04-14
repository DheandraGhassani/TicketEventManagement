<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">← Kembali</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kategori</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="'Nama Kategori *'" />
                        <x-text-input id="name" name="name" type="text" class="w-full mt-1 text-sm"
                            :value="old('name', $category->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="'Deskripsi'" />
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('description', $category->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="icon" :value="'Icon'" />
                        <x-text-input id="icon" name="icon" type="text" class="w-full mt-1 text-sm"
                            :value="old('icon', $category->icon)" />
                        <x-input-error :messages="$errors->get('icon')" class="mt-1" />
                    </div>

                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                            {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        <x-input-label for="is_active" :value="'Aktif'" class="ml-2" />
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('categories.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <x-primary-button>Update</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

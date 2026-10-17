<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Foto Profil</h2>
        <p class="mt-1 text-sm text-gray-600">
            Unggah foto profil Anda. Format JPG, PNG, atau WEBP, maksimal 2 MB.
        </p>
    </header>

    <div class="mt-6 flex items-center gap-4">
        @if($user->profile_photo_url)
            <img src="{{ $user->profile_photo_url }}" alt="Foto profil"
                 class="h-20 w-20 rounded-full object-cover border">
        @else
            <div class="h-20 w-20 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
    </div>

    <form method="post" action="{{ route('profile.photo.update') }}"
          enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf

        <div>
            <input type="file" name="profile_photo" accept="image/png,image/jpeg,image/webp"
                   class="block w-full text-sm text-gray-700" required>
            <x-input-error :messages="$errors->updatePhoto->get('profile_photo')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan Foto</x-primary-button>

            @if (session('status') === 'photo-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2500)"
                   class="text-sm text-gray-600">Foto disimpan.</p>
            @endif

            @if (session('status') === 'photo-deleted')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2500)"
                   class="text-sm text-gray-600">Foto dihapus.</p>
            @endif
        </div>
    </form>

    @if($user->profile_photo)
        <form method="post" action="{{ route('profile.photo.destroy') }}" class="mt-3">
            @csrf
            @method('delete')
            <button type="submit" class="text-sm text-red-600 underline">Hapus foto</button>
        </form>
    @endif
</section>
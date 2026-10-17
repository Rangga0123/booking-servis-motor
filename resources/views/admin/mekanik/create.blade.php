
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mekanik - Royal Motor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 p-5 md:p-10">
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('admin.mekanik.index') }}" class="text-sm text-blue-700 hover:underline">
            ← Kembali ke Data Mekanik
        </a>

        <div class="mt-5 rounded-2xl bg-white p-6 shadow-sm md:p-8">
            <h1 class="text-2xl font-bold">Tambah Mekanik</h1>
            <p class="mt-2 text-slate-500">Isi informasi mekanik baru.</p>

            @if($errors->any())
                <div class="mt-5 rounded-lg bg-red-50 p-4 text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.mekanik.store') }}" method="POST" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block font-medium">Nama Mekanik</label>
                    <input type="text" name="nama_mekanik" value="{{ old('nama_mekanik') }}"
                           required maxlength="255"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-2 block font-medium">Spesialisasi</label>
                    <input type="text" name="spesialisasi" value="{{ old('spesialisasi') }}"
                           required maxlength="255" placeholder="Contoh: Servis mesin"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-2 block font-medium">Status</label>
                    <select name="status" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none">
                        <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                    </select>
                </div>

                <div class="flex flex-wrap gap-3 pt-3">
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700">
                        Simpan Mekanik
                    </button>
                    <a href="{{ route('admin.mekanik.index') }}" class="rounded-xl border px-5 py-3 hover:bg-slate-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
@extends('admin.layouts.app')

@section('title', 'Kelola Informasi Bengkel')

@section('content')
@php
    $info = $informasiBengkel ?? null;
    $daftarPengumuman = $pengumuman ?? collect();
@endphp

<style>
    .info-page {
        display: grid;
        gap: 22px;
        color: var(--text, #172033);
    }

    .info-heading h1 {
        margin: 0 0 7px;
        font-size: 26px;
        font-weight: 800;
    }

    .info-heading p {
        margin: 0;
        color: var(--muted, #718096);
        line-height: 1.7;
    }

    .info-card {
        padding: 24px;
        background: #fff;
        border: 1px solid var(--border, #e5eaf1);
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .info-card h2 {
        margin: 0 0 7px;
        font-size: 19px;
        font-weight: 800;
    }

    .info-description {
        margin: 0 0 22px;
        color: var(--muted, #718096);
        font-size: 13px;
        line-height: 1.7;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .info-field {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 0;
    }

    .info-field.full {
        grid-column: 1 / -1;
    }

    .info-field label {
        font-size: 13px;
        font-weight: 700;
    }

    .info-field input,
    .info-field select,
    .info-field textarea {
        width: 100%;
        padding: 12px 14px;
        color: #172033;
        background: #fff;
        border: 1px solid #dce3ed;
        border-radius: 10px;
        outline: none;
        font: inherit;
        font-size: 14px;
    }

    .info-field input:focus,
    .info-field select:focus,
    .info-field textarea:focus {
        border-color: #3977ed;
        box-shadow: 0 0 0 3px rgba(57, 119, 237, .12);
    }

    .info-field textarea {
        min-height: 110px;
        resize: vertical;
    }

    .info-help {
        color: #718096;
        font-size: 12px;
        line-height: 1.6;
    }

    .info-photo {
        width: 100%;
        max-width: 340px;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e5eaf1;
        background: #f1f5f9;
    }

    .info-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
    }

    .info-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 11px 17px;
        border: 0;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 750;
        text-decoration: none;
        cursor: pointer;
    }

    .info-btn-primary {
        background: #2563eb;
        color: #fff;
    }

    .info-btn-danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .info-alert {
        padding: 13px 16px;
        border-radius: 11px;
        font-size: 13px;
        line-height: 1.7;
    }

    .info-alert-success {
        color: #166534;
        background: #dcfce7;
    }

    .info-alert-error {
        color: #991b1b;
        background: #fee2e2;
    }

    .announcement-item {
        padding: 18px 0;
        border-top: 1px solid #e5eaf1;
    }

    .announcement-item:first-of-type {
        border-top: 0;
    }

    .announcement-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 14px;
    }

    .announcement-item h3 {
        margin: 0 0 7px;
        font-size: 15px;
        font-weight: 800;
    }

    .announcement-item p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
        white-space: pre-line;
    }

    .announcement-status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-active {
        color: #166534;
        background: #dcfce7;
    }

    .status-inactive {
        color: #92400e;
        background: #fef3c7;
    }

    .announcement-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 13px;
    }

    .announcement-actions form {
        margin: 0;
    }

    @media (max-width: 700px) {
        .info-card {
            padding: 17px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .info-field.full {
            grid-column: auto;
        }

        .info-heading h1 {
            font-size: 22px;
        }

        .announcement-top {
            flex-direction: column;
        }
    }
</style>

<div class="info-page">
    <header class="info-heading">
        <h1>Kelola Informasi Bengkel</h1>
        <p>
            Atur informasi Bengkel Royal Motor yang ditampilkan kepada pelanggan,
            termasuk jam operasional, foto bengkel, dan pengumuman.
        </p>
    </header>

    @if (session('success'))
        <div class="info-alert info-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="info-alert info-alert-error">
            <strong>Data belum berhasil disimpan:</strong>
            <ul style="margin: 8px 0 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- INFORMASI UTAMA --}}
    <section class="info-card">
        <h2>Informasi Utama Bengkel</h2>
        <p class="info-description">
            Informasi ini digunakan untuk menampilkan identitas dan jam operasional
            bengkel di dashboard pelanggan.
        </p>

        <form action="{{ route('admin.informasi-bengkel.update') }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="info-grid">
                <div class="info-field full">
                    <label for="nama_bengkel">Nama Bengkel</label>
                    <input
                        type="text"
                        id="nama_bengkel"
                        name="nama_bengkel"
                        value="{{ old('nama_bengkel', $info?->nama_bengkel ?? 'Bengkel Royal Motor') }}"
                        required
                    >
                </div>

                <div class="info-field full">
                    <label for="deskripsi">Deskripsi Bengkel</label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        placeholder="Ceritakan secara singkat tentang bengkel..."
                    >{{ old('deskripsi', $info?->deskripsi) }}</textarea>
                </div>

                <div class="info-field">
                    <label for="hari_operasional">Hari Operasional</label>
                    <input
                        type="text"
                        id="hari_operasional"
                        name="hari_operasional"
                        value="{{ old('hari_operasional', $info?->hari_operasional ?? 'Senin–Minggu') }}"
                        placeholder="Contoh: Senin–Minggu"
                        required
                    >
                </div>

                <div class="info-field">
                    <label for="status_operasional">Status Operasional</label>
                    <select id="status_operasional" name="status_operasional" required>
                        <option value="buka"
                            @selected(old('status_operasional', $info?->status_operasional) === 'buka')>
                            Buka
                        </option>
                        <option value="tutup"
                            @selected(old('status_operasional', $info?->status_operasional) === 'tutup')>
                            Tutup
                        </option>
                    </select>
                </div>

                <div class="info-field">
                    <label for="jam_buka">Jam Buka</label>
                    <input
                        type="time"
                        id="jam_buka"
                        name="jam_buka"
                        value="{{ old('jam_buka', $info?->jam_buka ?? '13:00') }}"
                        required
                    >
                </div>

                <div class="info-field">
                    <label for="jam_tutup">Jam Tutup</label>
                    <input
                        type="time"
                        id="jam_tutup"
                        name="jam_tutup"
                        value="{{ old('jam_tutup', $info?->jam_tutup ?? '22:00') }}"
                        required
                    >
                </div>
            </div>

            <div class="info-actions">
                <button type="submit" class="info-btn info-btn-primary">
                    Simpan Informasi
                </button>
            </div>
        </form>
    </section>

    {{-- FOTO BENGKEL --}}
    <section class="info-card">
        <h2>Foto Bengkel</h2>
        <p class="info-description">
            Foto pertama untuk tampilan bengkel. Foto kedua untuk aktivitas servis.
            Foto ditampilkan di dashboard pelanggan tanpa judul atau keterangan tambahan.
        </p>

        <form action="{{ route('admin.informasi-bengkel.update') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Pertahankan data informasi utama saat form foto dikirim --}}
            <input type="hidden" name="nama_bengkel"
                value="{{ $info?->nama_bengkel ?? 'Bengkel Royal Motor' }}">
            <input type="hidden" name="deskripsi"
                value="{{ $info?->deskripsi }}">
            <input type="hidden" name="hari_operasional"
                value="{{ $info?->hari_operasional ?? 'Senin–Minggu' }}">
            <input type="hidden" name="jam_buka"
                value="{{ $info?->jam_buka ?? '13:00' }}">
            <input type="hidden" name="jam_tutup"
                value="{{ $info?->jam_tutup ?? '22:00' }}">
            <input type="hidden" name="status_operasional"
                value="{{ $info?->status_operasional ?? 'buka' }}">

            <div class="info-grid">
                <div class="info-field">
                    <label for="foto_1">Foto 1 — Tampilan Bengkel</label>

                    @if ($info?->foto_1)
                        <img
                            class="info-photo"
                            src="{{ asset('storage/' . $info->foto_1) }}"
                            alt="Foto bengkel"
                        >
                    @endif

                    <input
                        type="file"
                        id="foto_1"
                        name="foto_1"
                        accept="image/*"
                    >
                    <span class="info-help">
                        Pilih foto baru jika ingin mengganti foto pertama.
                    </span>
                </div>

                <div class="info-field">
                    <label for="foto_2">Foto 2 — Aktivitas Servis</label>

                    @if ($info?->foto_2)
                        <img
                            class="info-photo"
                            src="{{ asset('storage/' . $info->foto_2) }}"
                            alt="Aktivitas servis bengkel"
                        >
                    @endif

                    <input
                        type="file"
                        id="foto_2"
                        name="foto_2"
                        accept="image/*"
                    >
                    <span class="info-help">
                        Pilih foto aktivitas montir atau proses servis.
                    </span>
                </div>
            </div>

            <div class="info-actions">
                <button type="submit" class="info-btn info-btn-primary">
                    Simpan Foto
                </button>
            </div>
        </form>
    </section>

    {{-- TAMBAH PENGUMUMAN --}}
    <section class="info-card">
        <h2>Tambah Pengumuman</h2>
        <p class="info-description">
            Buat pengumuman untuk pelanggan. Pengumuman aktif akan ditampilkan
            di bagian Pengumuman Terbaru pada dashboard pelanggan.
        </p>

        <form action="{{ route('admin.pengumuman.store') }}" method="POST">
            @csrf

            <div class="info-grid">
                <div class="info-field full">
                    <label for="judul">Judul Pengumuman</label>
                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        value="{{ old('judul') }}"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="info-field full">
                    <label for="isi">Isi Pengumuman</label>
                    <textarea
                        id="isi"
                        name="isi"
                        required
                        placeholder="Tulis informasi yang ingin disampaikan..."
                    >{{ old('isi') }}</textarea>
                </div>

                <div class="info-field">
                    <label for="aktif">Status Pengumuman</label>
                    <select id="aktif" name="aktif" required>
                        <option value="1">Aktif — tampil ke pelanggan</option>
                        <option value="0">Nonaktif — disembunyikan</option>
                    </select>
                </div>
            </div>

            <div class="info-actions">
                <button type="submit" class="info-btn info-btn-primary">
                    Tambah Pengumuman
                </button>
            </div>
        </form>
    </section>

    {{-- DAFTAR PENGUMUMAN --}}
    <section class="info-card">
        <h2>Daftar Pengumuman</h2>
        <p class="info-description">
            Kamu bisa mengubah isi pengumuman, mengaktifkannya, atau menghapusnya.
        </p>

        @forelse ($daftarPengumuman as $item)
            <article class="announcement-item">
                <div class="announcement-top">
                    <div>
                        <h3>{{ $item->judul }}</h3>
                        <p>{{ $item->isi }}</p>
                    </div>

                    <span class="announcement-status {{ $item->aktif ? 'status-active' : 'status-inactive' }}">
                        {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="announcement-actions">
                    <button
                        type="button"
                        class="info-btn info-btn-primary"
                        onclick="document.getElementById('edit-pengumuman-{{ $item->id }}').hidden = !document.getElementById('edit-pengumuman-{{ $item->id }}').hidden"
                    >
                        Edit
                    </button>

                    <form
                        action="{{ route('admin.pengumuman.destroy', $item->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="info-btn info-btn-danger">
                            Hapus
                        </button>
                    </form>
                </div>

                <form
                    id="edit-pengumuman-{{ $item->id }}"
                    action="{{ route('admin.pengumuman.update', $item->id) }}"
                    method="POST"
                    hidden
                    style="margin-top: 18px;"
                >
                    @csrf
                    @method('PUT')

                    <div class="info-grid">
                        <div class="info-field full">
                            <label>Judul Pengumuman</label>
                            <input
                                type="text"
                                name="judul"
                                value="{{ $item->judul }}"
                                maxlength="255"
                                required
                            >
                        </div>

                        <div class="info-field full">
                            <label>Isi Pengumuman</label>
                            <textarea name="isi" required>{{ $item->isi }}</textarea>
                        </div>

                        <div class="info-field">
                            <label>Status</label>
                            <select name="aktif" required>
                                <option value="1" @selected((bool) $item->aktif)>Aktif</option>
                                <option value="0" @selected(!(bool) $item->aktif)>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="info-actions">
                        <button type="submit" class="info-btn info-btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </article>
        @empty
            <p class="info-description" style="margin-bottom: 0;">
                Belum ada pengumuman. Silakan buat pengumuman pertama.
            </p>
        @endforelse
    </section>
</div>
@endsection
@extends('admin.layouts.app')

@section('title', 'Kelola Informasi Bengkel')

@push('styles')
<style>
    .info-page { max-width: 960px; color: var(--text); font-size: 14px; }

    /* Notifikasi */
    .info-page .alert { padding: 14px 16px; margin-bottom: 18px; border-radius: 11px; font-size: 13px; line-height: 1.7; }
    .info-page .alert.success { color: #137849; background: #e8f8ef; border: 1px solid #bcebd0; }
    .info-page .alert.error { color: #bd263e; background: #fff0f2; border: 1px solid #ffd1d8; }

    /* Judul tiap bagian */
    .info-page .section-heading { margin: 30px 0 14px; }
    .info-page .section-heading:first-of-type { margin-top: 0; }
    .info-page .section-heading h3 { font-size: 18px; font-weight: 800; color: var(--text); }
    .info-page .section-heading p { margin-top: 6px; color: var(--muted); font-size: 13px; line-height: 1.6; }

    /* Kartu */
    .info-page .card,
    .info-page .announcement {
        padding: 24px;
        margin-bottom: 18px;
        border: 1px solid var(--border);
        border-radius: 14px;
        background: white;
        box-shadow: 0 5px 16px #273d630b;
    }

    .info-page .card-title {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 18px;
        margin-bottom: 22px;
        border-bottom: 1px solid #e6edf7;
    }
    .info-page .symbol {
        width: 44px; height: 44px;
        display: grid; place-items: center; flex-shrink: 0;
        border-radius: 12px;
        background: #e7efff;
        color: var(--blue);
        font-size: 20px;
    }
    .info-page .card-title h4 { font-size: 16px; font-weight: 800; }
    .info-page .card-title p { margin-top: 5px; color: var(--muted); font-size: 13px; line-height: 1.6; }

    /* Form */
    .info-page .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }
    .info-page .field { min-width: 0; }
    .info-page .field.full { grid-column: 1 / -1; }
    .info-page label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 700; color: #1b2a47; }

    .info-page input:not([type="checkbox"]):not([type="hidden"]):not([type="file"]),
    .info-page textarea,
    .info-page select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d8e1ed;
        border-radius: 10px;
        background: #fbfcfe;
        color: var(--text);
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .info-page input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px dashed #b9c8de;
        border-radius: 10px;
        background: #f7faff;
        font-size: 13px;
        color: #465b7c;
    }
    .info-page input[type="file"]::file-selector-button {
        margin-right: 12px;
        padding: 8px 14px;
        border: 0;
        border-radius: 8px;
        background: var(--blue);
        color: white;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
    }
    .info-page input:focus,
    .info-page textarea:focus,
    .info-page select:focus { border-color: var(--blue); box-shadow: 0 0 0 3px #3264d81a; background: white; }
    .info-page textarea { min-height: 110px; resize: vertical; line-height: 1.7; }

    .info-page .hint { display: block; margin-top: 7px; color: var(--muted); font-size: 12px; line-height: 1.6; }

    .info-page .photo-preview {
        display: block;
        width: 100%;
        max-width: 300px;
        height: 180px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid var(--border);
        margin-bottom: 12px;
        background: #edf2f8;
    }

    /* Tombol (menimpa ukuran .btn bawaan layout agar sesuai halaman ini) */
    .info-page .btn { padding: 12px 18px; font-size: 13px; cursor: pointer; }
    .info-page .btn:active { transform: scale(.98); }
    .info-page .btn-light { color: #536682; background: white; border: 1px solid var(--border); }
    .info-page .btn-light:hover { background: #f5f8fc; }
    .info-page .btn-danger { color: white; background: #e5384f; }
    .info-page .btn-danger:hover { background: #c92a40; }

    .info-page .form-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 10px;
        padding-top: 20px;
        margin-top: 24px;
        border-top: 1px solid #e8edf5;
    }

    .info-page .check-row {
        display: flex; align-items: center; gap: 10px;
        margin-top: 18px;
        font-size: 14px; font-weight: 600; cursor: pointer;
    }
    .info-page .check-row input { width: 17px; height: 17px; accent-color: var(--blue); }

    /* Pengumuman */
    .info-page .announcement-head {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
        padding-bottom: 16px; margin-bottom: 18px;
        border-bottom: 1px solid #e6edf7;
    }
    .info-page .announcement-head h4 { font-size: 16px; font-weight: 800; }

    .info-page .status { display: inline-block; padding: 6px 12px; border-radius: 30px; font-size: 12px; font-weight: 700; }
    .info-page .status.on { color: #0f7a4d; background: #d6f5e5; }
    .info-page .status.off { color: #5f6c82; background: #e6eaf1; }

    .info-page .announcement-actions { display: flex; justify-content: flex-end; flex-wrap: wrap; gap: 8px; margin-top: 16px; }

    .info-page .empty {
        padding: 40px 20px;
        border: 1px dashed #cbd7e8;
        border-radius: 14px;
        background: white;
        color: var(--muted);
        text-align: center;
        font-size: 14px;
        line-height: 1.8;
    }
    .info-page .empty-icon { display: block; margin-bottom: 8px; font-size: 30px; }
    .info-page .footer-note { padding: 22px 0 0; color: var(--muted); text-align: center; font-size: 12px; }

    @media (max-width: 700px) {
        .info-page .card, .info-page .announcement { padding: 18px 15px; }
        .info-page .form-grid { grid-template-columns: minmax(0, 1fr); gap: 16px; }
        .info-page .field.full { grid-column: auto; }
        .info-page .form-actions { flex-direction: column-reverse; }
        .info-page .form-actions .btn,
        .info-page .announcement-actions .btn { width: 100%; }
        .info-page .photo-preview { max-width: 100%; }
    }
</style>
@endpush

@section('content')
    <section class="page-heading">
        <div>
            <div class="breadcrumb">Admin / Informasi Bengkel</div>
            <h1 class="page-title">Informasi Bengkel Royal Motor</h1>
            <p class="page-description">Perbarui profil, jam operasional, foto, dan pengumuman bengkel dari satu halaman.</p>
        </div>
    </section>

<div class="info-page">

    @if (session('success'))
        <div class="alert success">✓ {{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert error">
            <strong>Data belum berhasil disimpan.</strong>
            <ul style="padding-left:20px; margin-top:8px; line-height:1.8">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ====================== PROFIL DAN OPERASIONAL ====================== --}}
    <div class="section-heading">
        <div>
            <h3>Profil dan Operasional</h3>
            <p>Informasi dasar yang dapat diperbarui oleh admin.</p>
        </div>
    </div>

    <section class="card">
        <div class="card-title">
            <div class="symbol">▣</div>
            <div>
                <h4>Informasi Utama Bengkel</h4>
                <p>Nama, deskripsi, jadwal, dan status operasional.</p>
            </div>
        </div>

        <form action="{{ route('admin.informasi-bengkel.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="field full">
                    <label for="nama_bengkel">Nama Bengkel</label>
                    <input id="nama_bengkel" name="nama_bengkel" type="text" maxlength="255"
                        value="{{ old('nama_bengkel', $informasiBengkel->nama_bengkel) }}" required>
                </div>

                <div class="field full">
                    <label for="deskripsi">Deskripsi Bengkel</label>
                    <textarea id="deskripsi" name="deskripsi">{{ old('deskripsi', $informasiBengkel->deskripsi) }}</textarea>
                </div>

                <div class="field full">
                    <label for="hari_operasional">Hari Operasional</label>
                    <input id="hari_operasional" name="hari_operasional" type="text" maxlength="255"
                        value="{{ old('hari_operasional', $informasiBengkel->hari_operasional) }}"
                        placeholder="Contoh: Senin–Minggu" required>
                </div>

                <div class="field">
                    <label for="jam_buka">Jam Buka</label>
                    <input id="jam_buka" name="jam_buka" type="time"
                        value="{{ old('jam_buka', substr($informasiBengkel->jam_buka ?? '13:00', 0, 5)) }}" required>
                </div>

                <div class="field">
                    <label for="jam_tutup">Jam Tutup</label>
                    <input id="jam_tutup" name="jam_tutup" type="time"
                        value="{{ old('jam_tutup', substr($informasiBengkel->jam_tutup ?? '22:00', 0, 5)) }}" required>
                </div>

                <div class="field full">
                    <label for="status_operasional">Status Operasional</label>
                    <select id="status_operasional" name="status_operasional" required>
                        <option value="otomatis" @selected(old('status_operasional', $informasiBengkel->status_operasional) === 'otomatis')>Otomatis berdasarkan jam</option>
                        <option value="buka" @selected(old('status_operasional', $informasiBengkel->status_operasional) === 'buka')>Buka</option>
                        <option value="tutup" @selected(old('status_operasional', $informasiBengkel->status_operasional) === 'tutup')>Tutup</option>
                        <option value="libur" @selected(old('status_operasional', $informasiBengkel->status_operasional) === 'libur')>Libur</option>
                    </select>
                </div>

                <div class="field full">
                    <label for="informasi_layanan">Informasi Layanan</label>
                    <textarea id="informasi_layanan" name="informasi_layanan"
                        placeholder="Tuliskan informasi layanan bengkel...">{{ old('informasi_layanan', $informasiBengkel->informasi_layanan) }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="reset" class="btn btn-light">Reset Form</button>
                <button type="submit" class="btn btn-primary">Simpan Informasi ↗</button>
            </div>
        </form>
    </section>

    {{-- ====================== FOTO BENGKEL (UPLOAD FILE) ====================== --}}
    <div class="section-heading">
        <div>
            <h3>Foto dan Informasi Tambahan</h3>
            <p>Pilih foto dari komputer atau HP, lalu simpan. Foto otomatis tampil di dashboard pelanggan.</p>
        </div>
    </div>

    <section class="card">
        <div class="card-title">
            <div class="symbol">▧</div>
            <div>
                <h4>Foto Bengkel</h4>
                <p>Unggah foto bengkel dan layanan beserta keterangannya.</p>
            </div>
        </div>

        <form action="{{ route('admin.informasi-bengkel.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="nama_bengkel" value="{{ $informasiBengkel->nama_bengkel }}">
            <input type="hidden" name="deskripsi" value="{{ $informasiBengkel->deskripsi }}">
            <input type="hidden" name="hari_operasional" value="{{ $informasiBengkel->hari_operasional }}">
            <input type="hidden" name="jam_buka" value="{{ substr($informasiBengkel->jam_buka ?? '13:00', 0, 5) }}">
            <input type="hidden" name="jam_tutup" value="{{ substr($informasiBengkel->jam_tutup ?? '22:00', 0, 5) }}">
            <input type="hidden" name="status_operasional" value="{{ $informasiBengkel->status_operasional ?? 'otomatis' }}">
            <input type="hidden" name="informasi_layanan" value="{{ $informasiBengkel->informasi_layanan }}">

            <div class="form-grid">
                <div class="field full">
                    <label for="foto_1">Foto 1 (Profil Bengkel)</label>
                    @if ($informasiBengkel->foto_1)
                        <img src="{{ asset($informasiBengkel->foto_1) }}" alt="Foto 1" class="photo-preview">
                    @endif
                    <input id="foto_1" name="foto_1" type="file" accept="image/jpeg,image/png,image/webp">
                    <span class="hint">JPG/PNG/WebP, maksimal 2 MB. Kosongkan jika tidak ingin mengganti foto.</span>
                </div>

                <div class="field full">
                    <label for="deskripsi_foto_1">Keterangan Foto 1</label>
                    <textarea id="deskripsi_foto_1" name="deskripsi_foto_1">{{ old('deskripsi_foto_1', $informasiBengkel->deskripsi_foto_1) }}</textarea>
                </div>

                <div class="field full">
                    <label for="foto_2">Foto 2 (Informasi Layanan)</label>
                    @if ($informasiBengkel->foto_2)
                        <img src="{{ asset($informasiBengkel->foto_2) }}" alt="Foto 2" class="photo-preview">
                    @endif
                    <input id="foto_2" name="foto_2" type="file" accept="image/jpeg,image/png,image/webp">
                    <span class="hint">JPG/PNG/WebP, maksimal 2 MB. Kosongkan jika tidak ingin mengganti foto.</span>
                </div>

                <div class="field full">
                    <label for="deskripsi_foto_2">Keterangan Foto 2</label>
                    <textarea id="deskripsi_foto_2" name="deskripsi_foto_2">{{ old('deskripsi_foto_2', $informasiBengkel->deskripsi_foto_2) }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Foto dan Keterangan ↗</button>
            </div>
        </form>
    </section>

    {{-- ====================== TAMBAH PENGUMUMAN ====================== --}}
    <div class="section-heading">
        <div>
            <h3>Kelola Pengumuman</h3>
            <p>Buat pengumuman yang bisa ditampilkan kepada pelanggan.</p>
        </div>
    </div>

    <section class="card">
        <div class="card-title">
            <div class="symbol">▤</div>
            <div>
                <h4>Tambah Pengumuman</h4>
                <p>Pengumuman dapat diaktifkan atau dinonaktifkan.</p>
            </div>
        </div>

        <form action="{{ route('admin.pengumuman.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="field full">
                    <label for="judul_baru">Judul Pengumuman</label>
                    <input id="judul_baru" name="judul" type="text" maxlength="255"
                        value="{{ old('judul') }}"
                        placeholder="Contoh: Perubahan Jam Operasional" required>
                </div>

                <div class="field full">
                    <label for="isi_baru">Isi Pengumuman</label>
                    <textarea id="isi_baru" name="isi"
                        placeholder="Tuliskan isi pengumuman..." required>{{ old('isi') }}</textarea>
                </div>
            </div>

            <label class="check-row">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" name="aktif" value="1" checked>
                Aktifkan pengumuman setelah disimpan
            </label>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">+ Tambah Pengumuman</button>
            </div>
        </form>
    </section>

    {{-- ====================== DAFTAR PENGUMUMAN ====================== --}}
    <div class="section-heading">
        <div>
            <h3>Daftar Pengumuman</h3>
            <p>{{ $pengumuman->count() }} pengumuman tersimpan.</p>
        </div>
    </div>

    @forelse ($pengumuman as $item)
        <section class="announcement">
            <div class="announcement-head">
                <h4>Pengumuman #{{ $item->id }}</h4>
                <span class="status {{ $item->aktif ? 'on' : 'off' }}">
                    {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <form action="{{ route('admin.pengumuman.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="field full">
                        <label for="judul_{{ $item->id }}">Judul</label>
                        <input id="judul_{{ $item->id }}" name="judul" type="text"
                            maxlength="255" value="{{ $item->judul }}" required>
                    </div>

                    <div class="field full">
                        <label for="isi_{{ $item->id }}">Isi Pengumuman</label>
                        <textarea id="isi_{{ $item->id }}" name="isi" required>{{ $item->isi }}</textarea>
                    </div>
                </div>

                <label class="check-row">
                    <input type="hidden" name="aktif" value="0">
                    <input type="checkbox" name="aktif" value="1" {{ $item->aktif ? 'checked' : '' }}>
                    Tampilkan pengumuman kepada pelanggan
                </label>

                <div class="announcement-actions">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>

            <form action="{{ route('admin.pengumuman.destroy', $item->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                @csrf
                @method('DELETE')

                <div class="announcement-actions">
                    <button type="submit" class="btn btn-danger">Hapus Pengumuman</button>
                </div>
            </form>
        </section>
    @empty
        <div class="empty">
            <span class="empty-icon">▤</span>
            <strong>Belum ada pengumuman</strong>
            <p>Pengumuman yang kamu tambahkan akan muncul di bagian ini.</p>
        </div>
    @endforelse

    <div class="footer-note">Bengkel Royal Motor · Panel Pengelolaan Informasi</div>

</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.info-page form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (form.hasAttribute('onsubmit')) {
                return;
            }

            const button = event.submitter;

            if (button && button.type === 'submit') {
                button.style.opacity = '0.75';
                button.style.cursor = 'wait';
                button.textContent = 'Menyimpan...';
            }
        });
    });
</script>
@endpush
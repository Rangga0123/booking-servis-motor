@extends('admin.layouts.app')

@section('title', 'Kelola Informasi Bengkel - Bengkel Royal Motor')

@push('styles')
<style>
    :root {
        --info-blue: #3264d8;
        --info-bg: #f4f7fb;
        --info-text: #14213d;
        --info-muted: #7182a3;
        --info-border: #dce5f1;
    }

    .info-page {
        color: var(--info-text);
        font-size: 13px;
    }

    .info-page .intro {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 22px 24px;
        margin-bottom: 23px;
        border: 1px solid #c9defc;
        border-radius: 14px;
        background: linear-gradient(110deg, #e1ecff, #e8f6ff);
        animation: infoRise .35s ease both;
    }

    .info-page .intro h2 {
        font-size: 21px;
        line-height: 1.4;
        margin-bottom: 7px;
    }

    .info-page .intro p {
        max-width: 700px;
        color: #405b83;
        font-size: 12px;
        line-height: 1.8;
    }

    .info-page .intro-mark {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 13px;
        background: #ffffffbd;
        color: var(--info-blue);
        font-size: 24px;
    }

    .info-page .alert {
        padding: 13px 16px;
        margin-bottom: 17px;
        border-radius: 9px;
        font-size: 12px;
        line-height: 1.8;
    }

    .info-page .alert.success {
        color: #17734c;
        background: #e7f8ef;
        border: 1px solid #c3ead3;
    }

    .info-page .alert.error {
        color: #a52e3c;
        background: #fff0f0;
        border: 1px solid #f4cdd1;
    }

    .info-page .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 24px 0 13px;
    }

    .info-page .section-heading h3 {
        font-size: 15px;
        font-weight: 800;
    }

    .info-page .section-heading p {
        margin-top: 5px;
        color: var(--info-muted);
        font-size: 11px;
        line-height: 1.7;
    }

    .info-page .card,
    .info-page .announcement {
        padding: 21px;
        margin-bottom: 18px;
        border: 1px solid var(--info-border);
        border-radius: 13px;
        background: white;
        box-shadow: 0 3px 12px #17254108;
        animation: infoRise .35s ease both;
    }

    .info-page .card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 16px;
        margin-bottom: 19px;
        border-bottom: 1px solid #e6edf7;
    }

    .info-page .symbol {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border-radius: 11px;
        background: #eaf2ff;
        color: var(--info-blue);
        font-size: 19px;
    }

    .info-page .card-title h4 {
        font-size: 13px;
        font-weight: 800;
    }

    .info-page .card-title p {
        margin-top: 5px;
        color: var(--info-muted);
        font-size: 11px;
        line-height: 1.6;
    }

    .info-page .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 17px;
    }

    .info-page .field {
        min-width: 0;
    }

    .info-page .field.full {
        grid-column: 1 / -1;
    }

    .info-page label {
        display: block;
        margin-bottom: 7px;
        font-size: 11px;
        font-weight: 700;
    }

    .info-page input:not([type="checkbox"]):not([type="hidden"]),
    .info-page textarea,
    .info-page select {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d8e1ef;
        border-radius: 8px;
        background: white;
        color: var(--info-text);
        font-family: inherit;
        font-size: 12px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .info-page input:focus,
    .info-page textarea:focus,
    .info-page select:focus {
        border-color: var(--info-blue);
        box-shadow: 0 0 0 3px #3564cc14;
    }

    .info-page textarea {
        min-height: 100px;
        resize: vertical;
        line-height: 1.7;
    }

    .info-page .hint {
        display: block;
        margin-top: 6px;
        color: var(--info-muted);
        font-size: 10px;
        line-height: 1.7;
    }

    .info-page .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 11px 16px;
        border: 0;
        border-radius: 8px;
        font-family: inherit;
        font-size: 11px;
        font-weight: 750;
        cursor: pointer;
        transition: background .2s, transform .2s;
    }

    .info-page .btn:active {
        transform: scale(.98);
    }

    .info-page .btn-primary {
        color: white;
        background: var(--info-blue);
    }

    .info-page .btn-primary:hover {
        background: #244fae;
    }

    .info-page .btn-light {
        color: #263b5c;
        background: #edf2f9;
    }

    .info-page .btn-light:hover {
        background: #dfe8f5;
    }

    .info-page .btn-danger {
        color: #c53342;
        background: #fff0f0;
    }

    .info-page .btn-danger:hover {
        background: #ffdddd;
    }

    .info-page .form-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 9px;
        padding-top: 17px;
        margin-top: 20px;
        border-top: 1px solid #e8edf5;
    }

    .info-page .check-row {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-top: 14px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }

    .info-page .check-row input {
        width: 15px;
        height: 15px;
        accent-color: var(--info-blue);
    }

    .info-page .announcement-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
    }

    .info-page .announcement-head h4 {
        font-size: 13px;
    }

    .info-page .status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 800;
    }

    .info-page .status.on {
        color: #16814f;
        background: #e0f7eb;
    }

    .info-page .status.off {
        color: #6b7688;
        background: #edf0f5;
    }

    .info-page .announcement-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 14px;
    }

    .info-page .empty {
        padding: 32px 20px;
        border: 1px dashed #cbd7e8;
        border-radius: 12px;
        background: white;
        color: var(--info-muted);
        text-align: center;
        font-size: 12px;
        line-height: 1.8;
    }

    .info-page .empty-icon {
        display: block;
        margin-bottom: 8px;
        font-size: 28px;
    }

    .info-page .footer-note {
        padding: 20px 0 0;
        color: var(--info-muted);
        text-align: center;
        font-size: 10px;
    }

    @keyframes infoRise {
        from {
            opacity: 0;
            transform: translateY(7px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 700px) {
        .info-page .intro {
            padding: 17px 15px;
            border-radius: 11px;
        }

        .info-page .intro h2 {
            font-size: 17px;
        }

        .info-page .intro p {
            font-size: 10px;
        }

        .info-page .intro-mark {
            width: 38px;
            height: 38px;
            font-size: 20px;
        }

        .info-page .card {
            padding: 16px 13px;
        }

        .info-page .form-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 15px;
        }

        .info-page .field.full {
            grid-column: auto;
        }

        .info-page .form-actions {
            flex-direction: column-reverse;
        }

        .info-page .form-actions .btn,
        .info-page .announcement-actions .btn {
            width: 100%;
        }

        .info-page .announcement {
            padding: 14px 12px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .info-page *,
        .info-page *::before,
        .info-page *::after {
            animation-duration: .01ms !important;
            transition-duration: .01ms !important;
        }
    }
</style>
@endpush

@section('content')
<div class="info-page">

    <section class="intro">
        <div>
            <h2>Informasi Bengkel Royal Motor</h2>
            <p>
                Perbarui profil, jam operasional, foto, dan pengumuman
                bengkel dari satu halaman.
            </p>
        </div>
        <div class="intro-mark">⚙</div>
    </section>

    @if (session('success'))
        <div class="alert success">
            ✓ {{ session('success') }}
        </div>
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
                    <input id="nama_bengkel" name="nama_bengkel" type="text"
                        maxlength="255"
                        value="{{ old('nama_bengkel', $informasiBengkel->nama_bengkel) }}"
                        required>
                </div>

                <div class="field full">
                    <label for="deskripsi">Deskripsi Bengkel</label>
                    <textarea id="deskripsi" name="deskripsi">{{ old('deskripsi', $informasiBengkel->deskripsi) }}</textarea>
                </div>

                <div class="field full">
                    <label for="hari_operasional">Hari Operasional</label>
                    <input id="hari_operasional" name="hari_operasional" type="text"
                        maxlength="255"
                        value="{{ old('hari_operasional', $informasiBengkel->hari_operasional) }}"
                        placeholder="Contoh: Senin–Minggu" required>
                </div>

                <div class="field">
                    <label for="jam_buka">Jam Buka</label>
                    <input id="jam_buka" name="jam_buka" type="time"
                        value="{{ old('jam_buka', substr($informasiBengkel->jam_buka ?? '13:00', 0, 5)) }}"
                        required>
                </div>

                <div class="field">
                    <label for="jam_tutup">Jam Tutup</label>
                    <input id="jam_tutup" name="jam_tutup" type="time"
                        value="{{ old('jam_tutup', substr($informasiBengkel->jam_tutup ?? '22:00', 0, 5)) }}"
                        required>
                </div>

                <div class="field full">
                    <label for="status_operasional">Status Operasional</label>
                    <select id="status_operasional" name="status_operasional" required>
                        <option value="otomatis" @selected(old('status_operasional', $informasiBengkel->status_operasional) === 'otomatis')>
                            Otomatis berdasarkan jam
                        </option>
                        <option value="buka" @selected(old('status_operasional', $informasiBengkel->status_operasional) === 'buka')>
                            Buka
                        </option>
                        <option value="tutup" @selected(old('status_operasional', $informasiBengkel->status_operasional) === 'tutup')>
                            Tutup
                        </option>
                        <option value="libur" @selected(old('status_operasional', $informasiBengkel->status_operasional) === 'libur')>
                            Libur
                        </option>
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

    <div class="section-heading">
        <div>
            <h3>Foto dan Informasi Tambahan</h3>
            <p>Atur alamat foto dan keterangan yang berkaitan dengan bengkel.</p>
        </div>
    </div>

    <section class="card">
        <div class="card-title">
            <div class="symbol">▧</div>
            <div>
                <h4>Foto Bengkel</h4>
                <p>Masukkan path gambar yang tersedia di folder project.</p>
            </div>
        </div>

        <form action="{{ route('admin.informasi-bengkel.update') }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="nama_bengkel" value="{{ $informasiBengkel->nama_bengkel }}">
            <input type="hidden" name="deskripsi" value="{{ $informasiBengkel->deskripsi }}">
            <input type="hidden" name="hari_operasional" value="{{ $informasiBengkel->hari_operasional }}">
            <input type="hidden" name="jam_buka" value="{{ substr($informasiBengkel->jam_buka ?? '13:00', 0, 5) }}">
            <input type="hidden" name="jam_tutup" value="{{ substr($informasiBengkel->jam_tutup ?? '22:00', 0, 5) }}">
            <input type="hidden" name="status_operasional" value="{{ $informasiBengkel->status_operasional }}">
            <input type="hidden" name="informasi_layanan" value="{{ $informasiBengkel->informasi_layanan }}">

            <div class="form-grid">
                <div class="field full">
                    <label for="foto_1">Alamat Foto 1</label>
                    <input id="foto_1" name="foto_1" type="text" maxlength="255"
                        value="{{ old('foto_1', $informasiBengkel->foto_1) }}"
                        placeholder="images/bengkel-royal.jpg">
                    <span class="hint">Contoh: images/bengkel-royal.jpg, jika file berada di public/images/.</span>
                </div>

                <div class="field full">
                    <label for="deskripsi_foto_1">Keterangan Foto 1</label>
                    <textarea id="deskripsi_foto_1" name="deskripsi_foto_1">{{ old('deskripsi_foto_1', $informasiBengkel->deskripsi_foto_1) }}</textarea>
                </div>

                <div class="field full">
                    <label for="foto_2">Alamat Foto 2</label>
                    <input id="foto_2" name="foto_2" type="text" maxlength="255"
                        value="{{ old('foto_2', $informasiBengkel->foto_2) }}"
                        placeholder="images/ruang-servis.jpg">
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
                    {{ $item->aktif ? 'AKTIF' : 'NONAKTIF' }}
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

            <form action="{{ route('admin.pengumuman.destroy', $item->id) }}"
                method="POST"
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

    <div class="footer-note">
        Bengkel Royal Motor · Panel Pengelolaan Informasi
    </div>

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
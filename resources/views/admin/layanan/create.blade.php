@extends('admin.layouts.app')

@section('title', 'Tambah Layanan')

@push('styles')
<style>
    /* HEADER HALAMAN */
    .service-page-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
    }

    .service-breadcrumb {
        margin-bottom: 8px;
        color: #7b8492;
        font-size: 12px;
    }

    .service-page-heading .page-title {
        margin-bottom: 8px;
    }

    /* PANEL FORM */
    .service-form-panel {
        padding: 24px;
    }

    .service-form-header {
        margin-bottom: 24px;
        padding-bottom: 18px;
        border-bottom: 1px solid #e5e7eb;
    }

    .service-form-title {
        margin: 0 0 7px;
        color: #1e293b;
        font-size: 18px;
        font-weight: 700;
    }

    .service-form-subtitle {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
    }

    /* SUSUNAN INPUT */
    .service-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .service-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 0;
    }

    .service-form-group.full-width {
        grid-column: 1 / -1;
    }

    .service-form-group label {
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .service-form-group label .required {
        color: #dc2626;
    }

    .service-form-control {
        display: block;
        width: 100%;
        min-height: 43px;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        color: #1e293b;
        font: inherit;
        font-size: 13px;
        box-sizing: border-box;
        transition: border-color .2s, box-shadow .2s;
    }

    .service-form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
    }

    .service-form-control::placeholder {
        color: #9ca3af;
    }

    textarea.service-form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.7;
    }

    .service-form-help {
        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
    }

    .service-field-error {
        color: #b91c1c;
        font-size: 12px;
    }

    .service-form-control.is-invalid {
        border-color: #dc2626;
    }

    /* RINCIAN HARGA */
    .service-price-section {
        grid-column: 1 / -1;
        padding: 20px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
    }

    .service-price-heading {
        margin: 0 0 6px;
        color: #1e293b;
        font-size: 15px;
        font-weight: 700;
    }

    .service-price-description {
        margin: 0 0 18px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
    }

    .service-price-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .service-total-card {
        grid-column: 1 / -1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 18px;
        padding: 18px;
        border: 1px solid #bfdbfe;
        border-radius: 9px;
        background: #eff6ff;
    }

    .service-total-label {
        margin-bottom: 5px;
        color: #1e40af;
        font-size: 13px;
        font-weight: 700;
    }

    .service-total-note {
        color: #64748b;
        font-size: 11px;
        line-height: 1.5;
    }

    .service-total-value {
        color: #1d4ed8;
        font-size: 23px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* NOTIFIKASI */
    .service-form-alert {
        margin-bottom: 20px;
        padding: 14px 16px;
        border: 1px solid #fecaca;
        border-radius: 8px;
        background: #fef2f2;
        color: #991b1b;
        font-size: 13px;
        line-height: 1.7;
    }

    .service-form-alert ul {
        margin: 6px 0 0;
        padding-left: 20px;
    }

    /* TOMBOL FORM */
    .service-form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .service-form-actions .btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-height: 40px;
        padding: 10px 17px;
        font-size: 13px;
        text-decoration: none;
    }

    @media (max-width: 700px) {
        .service-page-heading {
            flex-direction: column;
            gap: 14px;
        }

        .service-form-panel {
            padding: 17px;
        }

        .service-form-grid,
        .service-price-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 18px;
        }

        .service-form-group.full-width,
        .service-price-section,
        .service-total-card {
            grid-column: auto;
        }

        .service-total-card {
            align-items: flex-start;
            flex-direction: column;
        }

        .service-total-value {
            font-size: 21px;
        }

        .service-form-actions {
            align-items: stretch;
            flex-direction: column-reverse;
        }

        .service-form-actions .btn {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>
@endpush

@section('content')
<div class="content">

    {{-- HEADER HALAMAN --}}
    <section class="service-page-heading">
        <div>
            <div class="service-breadcrumb">
                Admin / Data Master / Kelola Layanan / Tambah
            </div>

            <h1 class="page-title">Tambah Layanan</h1>

            <p class="page-description">
                Tambahkan layanan servis beserta rincian harga Bengkel Royal Motor.
            </p>
        </div>

        <a href="{{ route('admin.layanan.index') }}" class="btn btn-light">
            Kembali
        </a>
    </section>

    {{-- PESAN VALIDASI --}}
    @if ($errors->any())
        <div class="service-form-alert" role="alert">
            <strong>Periksa kembali data yang kamu masukkan.</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM TAMBAH LAYANAN --}}
    <section class="panel service-form-panel">

        <div class="service-form-header">
            <h2 class="service-form-title">Informasi Layanan</h2>

            <p class="service-form-subtitle">
                Isi informasi layanan, harga barang, biaya jasa, dan estimasi pengerjaan.
            </p>
        </div>

        <form action="{{ route('admin.layanan.store') }}" method="POST">
            @csrf

            <div class="service-form-grid">

                {{-- NAMA LAYANAN --}}
                <div class="service-form-group">
                    <label for="nama_servis">
                        Nama Layanan <span class="required">*</span>
                    </label>

                    <input
                        id="nama_servis"
                        name="nama_servis"
                        type="text"
                        class="service-form-control @error('nama_servis') is-invalid @enderror"
                        value="{{ old('nama_servis') }}"
                        placeholder="Contoh: Ganti Oli Mesin"
                        maxlength="255"
                        required
                    >

                    @error('nama_servis')
                        <small class="service-field-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- ESTIMASI --}}
                <div class="service-form-group">
                    <label for="estimasi_waktu">
                        Estimasi Pengerjaan <span class="required">*</span>
                    </label>

                    <input
                        id="estimasi_waktu"
                        name="estimasi_waktu"
                        type="number"
                        class="service-form-control @error('estimasi_waktu') is-invalid @enderror"
                        min="1"
                        step="1"
                        value="{{ old('estimasi_waktu', 30) }}"
                        placeholder="Contoh: 30"
                        required
                    >

                    <small class="service-form-help">
                        Masukkan perkiraan waktu pengerjaan dalam menit.
                    </small>

                    @error('estimasi_waktu')
                        <small class="service-field-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- DESKRIPSI --}}
                <div class="service-form-group full-width">
                    <label for="deskripsi">
                        Deskripsi Layanan <span class="required">*</span>
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        class="service-form-control @error('deskripsi') is-invalid @enderror"
                        rows="4"
                        placeholder="Jelaskan layanan atau pekerjaan yang dilakukan..."
                        required
                    >{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <small class="service-field-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- RINCIAN HARGA --}}
                <div class="service-price-section">
                    <h3 class="service-price-heading">Rincian Harga</h3>

                    <p class="service-price-description">
                        Masukkan harga barang dan biaya jasa. Total akan dihitung otomatis.
                    </p>

                    <div class="service-price-grid">

                        <div class="service-form-group">
                            <label for="harga_barang">
                                Harga Barang / Suku Cadang (Rp)
                                <span class="required">*</span>
                            </label>

                            <input
                                id="harga_barang"
                                name="harga_barang"
                                type="number"
                                class="service-form-control @error('harga_barang') is-invalid @enderror"
                                min="0"
                                step="1"
                                value="{{ old('harga_barang', 0) }}"
                                placeholder="Contoh: 45000"
                                required
                            >

                            @error('harga_barang')
                                <small class="service-field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="service-form-group">
                            <label for="biaya_jasa">
                                Biaya Jasa Servis (Rp)
                                <span class="required">*</span>
                            </label>

                            <input
                                id="biaya_jasa"
                                name="biaya_jasa"
                                type="number"
                                class="service-form-control @error('biaya_jasa') is-invalid @enderror"
                                min="0"
                                step="1"
                                value="{{ old('biaya_jasa', 0) }}"
                                placeholder="Contoh: 15000"
                                required
                            >

                            @error('biaya_jasa')
                                <small class="service-field-error">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    {{-- TOTAL OTOMATIS --}}
                    <div class="service-total-card">
                        <div>
                            <div class="service-total-label">Total Harga Layanan</div>
                            <div class="service-total-note">
                                Harga barang + biaya jasa servis
                            </div>
                        </div>

                        <div id="totalHargaPreview" class="service-total-value">
                            Rp0
                        </div>
                    </div>
                </div>

            </div>

            {{-- TOMBOL --}}
            <div class="service-form-actions">
                <a href="{{ route('admin.layanan.index') }}" class="btn btn-light">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Layanan
                </button>
            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const barangInput = document.getElementById('harga_barang');
    const jasaInput = document.getElementById('biaya_jasa');
    const totalPreview = document.getElementById('totalHargaPreview');

    if (!barangInput || !jasaInput || !totalPreview) {
        return;
    }

    function updateTotalHarga() {
        const barang = Math.max(0, Number(barangInput.value) || 0);
        const jasa = Math.max(0, Number(jasaInput.value) || 0);
        const total = barang + jasa;

        totalPreview.textContent = 'Rp' + total.toLocaleString('id-ID');
    }

    barangInput.addEventListener('input', updateTotalHarga);
    jasaInput.addEventListener('input', updateTotalHarga);

    updateTotalHarga();
});
</script>
@endpush
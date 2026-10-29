@extends('admin.layouts.app')

@section('title', 'Tambah Layanan')

@push('styles')
<style>
    .fm-page,
    .fm-page * { box-sizing: border-box; }
    .fm-page { color: #212529; }

    /* ===== CARD ===== */
    .fm-page .panel { background: #fff; border: 1px solid #e9ecef; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,.06); margin-bottom: 18px; overflow: hidden; }
    .fm-page .panel-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; padding: 14px 20px; background: #fff; border-bottom: 1px solid #e9ecef; }
    .fm-page .panel-title { margin: 0; color: #212529; font-size: 16px; font-weight: 400; }
    .fm-page .panel-body { padding: 20px; }

    /* ===== TOMBOL ===== */
    .fm-page .fm-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 34px; padding: 6px 14px; border: 1px solid transparent; border-radius: 4px; font-family: inherit; font-size: 14px; font-weight: 600; line-height: 1.5; white-space: nowrap; text-decoration: none; cursor: pointer; transition: filter .15s ease; }
    .fm-page .fm-btn:hover { filter: brightness(.92); }
    .fm-page .fm-btn-primary { color: #fff; background: #007bff; border-color: #007bff; }
    .fm-page .fm-btn-secondary { color: #fff; background: #6c757d; border-color: #6c757d; }
    .fm-page .fm-btn-warning { color: #212529; background: #ffc107; border-color: #ffc107; }

    /* ===== NOTIFIKASI ===== */
    .fm-page .fm-notice { padding: 13px 16px; margin-bottom: 16px; color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 6px; font-size: 13px; line-height: 1.6; }
    .fm-page .fm-notice ul { padding-left: 20px; margin: 6px 0 0; }

    /* ===== FORM ===== */
    .fm-page .fm-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
    .fm-page .fm-group { display: flex; flex-direction: column; gap: 6px; min-width: 0; }
    .fm-page .fm-group.full { grid-column: 1 / -1; }
    .fm-page .fm-group label { color: #212529; font-size: 14px; font-weight: 600; }
    .fm-page .fm-group label .required { color: #dc3545; }
    .fm-page .fm-control { display: block; width: 100%; min-height: 38px; padding: 7px 12px; color: #495057; background: #fff; border: 1px solid #ced4da; border-radius: 4px; font: inherit; font-size: 14px; transition: border-color .15s, box-shadow .15s; }
    .fm-page .fm-control:focus { outline: none; border-color: #80bdff; box-shadow: 0 0 0 3px rgba(0,123,255,.2); }
    .fm-page .fm-control::placeholder { color: #adb5bd; }
    .fm-page .fm-control.is-invalid { border-color: #dc3545; }
    .fm-page textarea.fm-control { min-height: 110px; resize: vertical; line-height: 1.6; }
    .fm-page .fm-help { color: #6c757d; font-size: 12px; line-height: 1.5; }
    .fm-page .fm-error { color: #dc3545; font-size: 12px; }
    .fm-page .fm-actions { display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 8px; margin-top: 24px; padding-top: 18px; border-top: 1px solid #e9ecef; }

    /* ===== RINCIAN HARGA ===== */
    .fm-page .fm-section { grid-column: 1 / -1; padding: 18px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; }
    .fm-page .fm-section-title { margin: 0 0 4px; color: #212529; font-size: 15px; font-weight: 700; }
    .fm-page .fm-section-desc { margin: 0 0 16px; color: #6c757d; font-size: 12px; line-height: 1.6; }
    .fm-page .fm-total { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 16px 18px; background: #e7f1ff; border: 1px solid #b8daff; border-radius: 6px; }
    .fm-page .fm-total-label { color: #004085; font-size: 14px; font-weight: 700; }
    .fm-page .fm-total-note { margin-top: 3px; color: #6c757d; font-size: 12px; }
    .fm-page .fm-total-value { color: #007bff; font-size: 22px; font-weight: 800; white-space: nowrap; }
    .fm-page .fm-section .fm-total { margin-top: 16px; }

    @media (max-width: 700px) {
        .fm-page .panel-header { padding: 12px 14px; }
        .fm-page .panel-body { padding: 14px; }
        .fm-page .fm-grid { grid-template-columns: minmax(0, 1fr); gap: 16px; }
        .fm-page .fm-group.full, .fm-page .fm-section { grid-column: auto; }
        .fm-page .fm-control { font-size: 16px; }
        .fm-page .fm-section { padding: 14px; }
        .fm-page .fm-total { align-items: flex-start; flex-direction: column; gap: 8px; }
        .fm-page .fm-total-value { font-size: 20px; }
        .fm-page .fm-actions { align-items: stretch; flex-direction: column-reverse; }
        .fm-page .fm-actions .fm-btn { width: 100%; min-height: 42px; }
        .fm-page .panel-header .fm-btn { width: 100%; }
        .fm-page .fm-name { font-size: 19px; }
        .fm-page .fm-info { grid-template-columns: minmax(0, 1fr); }
        .fm-page .fm-info-item:nth-child(odd) { border-right: none; }
        .fm-page .fm-info-item:nth-last-child(2) { border-bottom: 1px solid #dee2e6; }
    }
</style>
@endpush

@section('content')
<div class="content fm-page">

    <section class="page-heading">
        <div>
            <div class="breadcrumb">Admin / Data Master / Kelola Layanan / Tambah</div>
            <h1 class="page-title">Tambah Layanan</h1>
            <p class="page-description">Tambahkan layanan servis beserta rincian harga Bengkel Royal Motor.</p>
        </div>
    </section>

    @if ($errors->any())
        <div class="fm-notice" role="alert">
            <strong>Periksa kembali data yang kamu masukkan.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Informasi Layanan</h2>
            <a href="{{ route('admin.layanan.index') }}" class="fm-btn fm-btn-secondary">← Kembali</a>
        </div>

        <div class="panel-body">
            <form action="{{ route('admin.layanan.store') }}" method="POST">
                @csrf

                <div class="fm-grid">

                    <div class="fm-group">
                        <label for="nama_servis">Nama Layanan <span class="required">*</span></label>
                        <input id="nama_servis" name="nama_servis" type="text"
                               class="fm-control @error('nama_servis') is-invalid @enderror"
                               value="{{ old('nama_servis') }}" placeholder="Contoh: Ganti Oli Mesin"
                               maxlength="255" required>
                        @error('nama_servis')
                            <small class="fm-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fm-group">
                        <label for="estimasi_waktu">Estimasi Pengerjaan <span class="required">*</span></label>
                        <input id="estimasi_waktu" name="estimasi_waktu" type="number"
                               class="fm-control @error('estimasi_waktu') is-invalid @enderror"
                               min="1" step="1" value="{{ old('estimasi_waktu', 30) }}"
                               placeholder="Contoh: 30" required>
                        <small class="fm-help">Masukkan perkiraan waktu pengerjaan dalam menit.</small>
                        @error('estimasi_waktu')
                            <small class="fm-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fm-group full">
                        <label for="deskripsi">Deskripsi Layanan <span class="required">*</span></label>
                        <textarea id="deskripsi" name="deskripsi"
                                  class="fm-control @error('deskripsi') is-invalid @enderror"
                                  rows="4" placeholder="Jelaskan layanan atau pekerjaan yang dilakukan..."
                                  required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <small class="fm-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="fm-section">
                        <h3 class="fm-section-title">Rincian Harga</h3>
                        <p class="fm-section-desc">Masukkan harga barang dan biaya jasa. Total akan dihitung otomatis.</p>

                        <div class="fm-grid">
                            <div class="fm-group">
                                <label for="harga_barang">Harga Barang / Suku Cadang (Rp) <span class="required">*</span></label>
                                <input id="harga_barang" name="harga_barang" type="number"
                                       class="fm-control @error('harga_barang') is-invalid @enderror"
                                       min="0" step="1" value="{{ old('harga_barang', 0) }}"
                                       placeholder="Contoh: 45000" required>
                                @error('harga_barang')
                                    <small class="fm-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="fm-group">
                                <label for="biaya_jasa">Biaya Jasa Servis (Rp) <span class="required">*</span></label>
                                <input id="biaya_jasa" name="biaya_jasa" type="number"
                                       class="fm-control @error('biaya_jasa') is-invalid @enderror"
                                       min="0" step="1" value="{{ old('biaya_jasa', 0) }}"
                                       placeholder="Contoh: 15000" required>
                                @error('biaya_jasa')
                                    <small class="fm-error">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="fm-total">
                            <div>
                                <div class="fm-total-label">Total Harga Layanan</div>
                                <div class="fm-total-note">Harga barang + biaya jasa servis</div>
                            </div>
                            <div id="totalHargaPreview" class="fm-total-value">Rp0</div>
                        </div>
                    </div>

                </div>

                <div class="fm-actions">
                    <a href="{{ route('admin.layanan.index') }}" class="fm-btn fm-btn-secondary">Batal</a>
                    <button type="submit" class="fm-btn fm-btn-primary">Simpan Layanan</button>
                </div>
            </form>
        </div>
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
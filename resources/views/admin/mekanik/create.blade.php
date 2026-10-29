@extends('admin.layouts.app')

@section('title', 'Tambah Mekanik')

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
<div class="fm-page">

    <section class="page-heading">
        <div>
            <div class="breadcrumb">Admin / Data Mekanik / Tambah</div>
            <h1 class="page-title">Tambah Mekanik</h1>
            <p class="page-description">Isi informasi mekanik baru.</p>
        </div>
    </section>

    @if ($errors->any())
        <div class="fm-notice" role="alert">
            <strong>Periksa kembali data yang diisi.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Informasi Mekanik</h2>
            <a href="{{ route('admin.mekanik.index') }}" class="fm-btn fm-btn-secondary">← Kembali ke Data Mekanik</a>
        </div>

        <div class="panel-body">
            <form action="{{ route('admin.mekanik.store') }}" method="POST">
                @csrf

                <div class="fm-grid">
                    <div class="fm-group">
                        <label for="nama_mekanik">Nama Mekanik</label>
                        <input type="text" id="nama_mekanik" name="nama_mekanik" value="{{ old('nama_mekanik') }}"
                               required maxlength="255" class="fm-control">
                    </div>

                    <div class="fm-group">
                        <label for="spesialisasi">Spesialisasi</label>
                        <input type="text" id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi') }}"
                               required maxlength="255" placeholder="Contoh: Servis mesin" class="fm-control">
                    </div>

                    <div class="fm-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required class="fm-control">
                            <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="fm-actions">
                    <a href="{{ route('admin.mekanik.index') }}" class="fm-btn fm-btn-secondary">Batal</a>
                    <button type="submit" class="fm-btn fm-btn-primary">Simpan Mekanik</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
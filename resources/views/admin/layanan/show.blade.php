@extends('admin.layouts.app')

@section('title', 'Detail Layanan')

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

    /* ===== DETAIL ===== */
    .fm-page .fm-name { margin: 0 0 16px; padding-bottom: 14px; color: #212529; border-bottom: 1px solid #dee2e6; font-size: 22px; font-weight: 700; line-height: 1.4; overflow-wrap: anywhere; }
    .fm-page .fm-desc-box { padding: 14px 16px; margin-bottom: 20px; background: #f8f9fa; border: 1px solid #dee2e6; border-left: 3px solid #6c757d; border-radius: 4px; }
    .fm-page .fm-desc-label { margin: 0 0 6px; color: #212529; font-size: 13px; font-weight: 700; }
    .fm-page .fm-desc { margin: 0; color: #495057; font-size: 14px; line-height: 1.8; white-space: pre-line; overflow-wrap: anywhere; }
    .fm-page .fm-section-heading { margin: 0 0 12px; color: #212529; font-size: 15px; font-weight: 700; }
    .fm-page .fm-info { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); margin: 0 0 16px; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; }
    .fm-page .fm-info-item { min-width: 0; padding: 14px 16px; border-bottom: 1px solid #dee2e6; }
    .fm-page .fm-info-item:nth-child(odd) { border-right: 1px solid #dee2e6; }
    .fm-page .fm-info-item:nth-last-child(-n + 2) { border-bottom: none; }
    .fm-page .fm-info-item dt { margin: 0 0 4px; color: #6c757d; font-size: 12px; font-weight: 600; }
    .fm-page .fm-info-item dd { margin: 0; color: #212529; font-size: 15px; font-weight: 700; overflow-wrap: anywhere; }

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
            <div class="breadcrumb">Admin / Data Master / Kelola Layanan / Detail Layanan</div>
            <h1 class="page-title">Detail Layanan</h1>
            <p class="page-description">Informasi lengkap layanan Bengkel Royal Motor.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Informasi Layanan</h2>
            <a href="{{ route('admin.layanan.index') }}" class="fm-btn fm-btn-secondary">← Kembali ke Daftar</a>
        </div>

        <div class="panel-body">

            <h3 class="fm-name">{{ $service->nama_servis }}</h3>

            <div class="fm-desc-box">
                <h4 class="fm-desc-label">Deskripsi Layanan</h4>
                <p class="fm-desc">{{ $service->deskripsi ?: 'Belum ada deskripsi layanan.' }}</p>
            </div>

            <h4 class="fm-section-heading">Rincian Layanan</h4>

            <dl class="fm-info">
                <div class="fm-info-item">
                    <dt>Nama Layanan</dt>
                    <dd>{{ $service->nama_servis }}</dd>
                </div>

                <div class="fm-info-item">
                    <dt>Estimasi Pengerjaan</dt>
                    <dd>{{ $service->estimasi_waktu }} menit</dd>
                </div>

                <div class="fm-info-item">
                    <dt>Harga Barang / Suku Cadang</dt>
                    <dd>Rp{{ number_format($service->harga_barang ?? 0, 0, ',', '.') }}</dd>
                </div>

                <div class="fm-info-item">
                    <dt>Biaya Jasa Servis</dt>
                    <dd>Rp{{ number_format($service->biaya_jasa ?? 0, 0, ',', '.') }}</dd>
                </div>
            </dl>

            <div class="fm-total">
                <div>
                    <div class="fm-total-label">Total Harga Layanan</div>
                    <div class="fm-total-note">Harga barang ditambah biaya jasa servis.</div>
                </div>

                <div class="fm-total-value">
                    Rp{{ number_format(
                        $service->harga ?? (($service->harga_barang ?? 0) + ($service->biaya_jasa ?? 0)),
                        0,
                        ',',
                        '.'
                    ) }}
                </div>
            </div>

            <div class="fm-actions">
                <a href="{{ route('admin.layanan.index') }}" class="fm-btn fm-btn-secondary">Kembali</a>
                <a href="{{ route('admin.layanan.edit', $service->id) }}" class="fm-btn fm-btn-warning">Edit Layanan</a>
            </div>

        </div>
    </section>
</div>
@endsection
@extends('admin.layouts.app')

@section('title', 'Detail Layanan')

@push('styles')
<style>
    .detail-page {
        max-width: 1100px;
        margin: 0 auto;
        padding-bottom: 30px;
        color: #1e293b;
    }

    /* Header halaman */
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .detail-breadcrumb {
        margin-bottom: 9px;
        color: #64748b;
        font-size: 12px;
    }

    .detail-breadcrumb span {
        color: #2563eb;
        font-weight: 600;
    }

    .detail-header h1 {
        margin: 0 0 7px;
        color: #172033;
        font-size: 25px;
        font-weight: 750;
    }

    .detail-header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    /* Tombol */
    .detail-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-height: 40px;
        padding: 10px 16px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: .2s ease;
        box-sizing: border-box;
    }

    .detail-btn-back {
        color: #475569;
        background: #f1f5f9;
        border-color: #dbe2ea;
    }

    .detail-btn-back:hover {
        background: #e2e8f0;
    }

    .detail-btn-edit {
        color: #fff;
        background: #2563eb;
    }

    .detail-btn-edit:hover {
        background: #1d4ed8;
    }

    /* Kartu utama */
    .detail-card {
        overflow: hidden;
        border: 1px solid #d8dee8;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .05);
    }

    /* Bagian informasi layanan */
    .detail-card-header {
        padding: 25px;
        background: linear-gradient(135deg, #eef2f7, #f8fafc);
        border-bottom: 1px solid #d5dce6;
    }

    .detail-label {
        display: inline-block;
        margin-bottom: 12px;
        padding: 5px 10px;
        color: #475569;
        background: rgba(148, 163, 184, .15);
        border: 1px solid #d5dce6;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .detail-service-name {
        margin: 0 0 20px;
        padding-bottom: 17px;
        color: #172033;
        border-bottom: 1px solid #cbd5e1;
        font-size: 25px;
        font-weight: 750;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .detail-description-box {
        padding: 16px 18px;
        background: rgba(255, 255, 255, .65);
        border: 1px solid #dce3ec;
        border-left: 4px solid #64748b;
        border-radius: 7px;
    }

    .detail-description-label {
        margin: 0 0 10px;
        padding-bottom: 9px;
        color: #334155;
        border-bottom: 1px solid #e2e8f0;
        font-size: 13px;
        font-weight: 750;
    }

    .detail-description {
        margin: 0;
        color: #475569;
        font-size: 14px;
        line-height: 1.9;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    /* Bagian rincian */
    .detail-card-body {
        padding: 25px;
        background: #fff;
    }

    .detail-section-title {
        margin: 0 0 17px;
        padding-bottom: 13px;
        border-bottom: 1px solid #e2e8f0;
        color: #172033;
        font-size: 16px;
        font-weight: 750;
    }

    .detail-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0;
        overflow: hidden;
        border: 1px solid #dce3ec;
        border-radius: 9px;
    }

    .detail-info-item {
        min-width: 0;
        padding: 20px;
        border-bottom: 1px solid #dce3ec;
    }

    /* Warna abu-abu selang-seling */
    .detail-info-item:nth-child(4n + 1),
    .detail-info-item:nth-child(4n + 4) {
        background: #f1f5f9;
    }

    .detail-info-item:nth-child(4n + 2),
    .detail-info-item:nth-child(4n + 3) {
        background: #fff;
    }

    .detail-info-item:nth-child(odd) {
        border-right: 1px solid #dce3ec;
    }

    .detail-info-item:nth-last-child(-n + 2) {
        border-bottom: none;
    }

    .detail-info-item dt {
        margin-bottom: 10px;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.5;
    }

    .detail-info-item dd {
        margin: 0;
        color: #1e293b;
        font-size: 17px;
        font-weight: 750;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    /* Total harga */
    .detail-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-top: 20px;
        padding: 22px 24px;
        border: 1px solid #bfdbfe;
        border-left: 4px solid #3b82f6;
        border-radius: 9px;
        background: linear-gradient(
            110deg,
            rgba(219, 234, 254, .65),
            rgba(239, 246, 255, .9)
        );
    }

    .detail-total-label {
        margin: 0 0 7px;
        color: #1e40af;
        font-size: 14px;
        font-weight: 750;
    }

    .detail-total-description {
        margin: 0;
        color: #64748b;
        font-size: 12px;
        line-height: 1.7;
    }

    .detail-total-price {
        color: #1d4ed8;
        font-size: 27px;
        font-weight: 850;
        text-align: right;
        overflow-wrap: anywhere;
    }

    /* Tombol bawah */
    .detail-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    @media (max-width: 640px) {
        .detail-header {
            align-items: flex-start;
        }

        .detail-header h1 {
            font-size: 22px;
        }

        .detail-header > .detail-btn {
            width: 100%;
        }

        .detail-card-header,
        .detail-card-body {
            padding: 17px;
        }

        .detail-service-name {
            font-size: 21px;
        }

        .detail-description-box {
            padding: 14px;
        }

        .detail-info-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .detail-info-item,
        .detail-info-item:nth-child(odd) {
            border-right: none;
            border-bottom: 1px solid #dce3ec;
        }

        .detail-info-item:nth-child(odd) {
            background: #f1f5f9;
        }

        .detail-info-item:nth-child(even) {
            background: #fff;
        }

        .detail-info-item:last-child {
            border-bottom: none;
        }

        .detail-total {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
            padding: 18px;
        }

        .detail-total-price {
            font-size: 24px;
            text-align: left;
        }

        .detail-footer {
            flex-direction: column-reverse;
        }

        .detail-footer .detail-btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-page">

    {{-- Header halaman --}}
    <div class="detail-header">
        <div>
            <div class="detail-breadcrumb">
                Admin / Data Master / Kelola Layanan /
                <span>Detail Layanan</span>
            </div>

            <h1>Detail Layanan</h1>

            <p>
                Informasi lengkap layanan Bengkel Royal Motor.
            </p>
        </div>

        <a
            href="{{ route('admin.layanan.index') }}"
            class="detail-btn detail-btn-back"
        >
            Kembali ke Daftar
        </a>
    </div>

    <div class="detail-card">

        {{-- Nama dan deskripsi --}}
        <div class="detail-card-header">

            <span class="detail-label">Informasi Layanan</span>

            <h2 class="detail-service-name">
                {{ $service->nama_servis }}
            </h2>

            <div class="detail-description-box">
                <h3 class="detail-description-label">
                    Deskripsi Layanan
                </h3>

                <p class="detail-description">
                    {{ $service->deskripsi ?: 'Belum ada deskripsi layanan.' }}
                </p>
            </div>

        </div>

        {{-- Rincian harga dan waktu --}}
        <div class="detail-card-body">

            <h3 class="detail-section-title">
                Rincian Layanan
            </h3>

            <dl class="detail-info-grid">

                <div class="detail-info-item">
                    <dt>Nama Layanan</dt>
                    <dd>{{ $service->nama_servis }}</dd>
                </div>

                <div class="detail-info-item">
                    <dt>Estimasi Pengerjaan</dt>
                    <dd>{{ $service->estimasi_waktu }} menit</dd>
                </div>

                <div class="detail-info-item">
                    <dt>Harga Barang / Suku Cadang</dt>
                    <dd>
                        Rp{{ number_format($service->harga_barang ?? 0, 0, ',', '.') }}
                    </dd>
                </div>

                <div class="detail-info-item">
                    <dt>Biaya Jasa Servis</dt>
                    <dd>
                        Rp{{ number_format($service->biaya_jasa ?? 0, 0, ',', '.') }}
                    </dd>
                </div>

            </dl>

            {{-- Total harga --}}
            <div class="detail-total">
                <div>
                    <p class="detail-total-label">
                        Total Harga Layanan
                    </p>

                    <p class="detail-total-description">
                        Harga barang ditambah biaya jasa servis.
                    </p>
                </div>

                <div class="detail-total-price">
                    Rp{{ number_format(
                        $service->harga ?? (($service->harga_barang ?? 0) + ($service->biaya_jasa ?? 0)),
                        0,
                        ',',
                        '.'
                    ) }}
                </div>
            </div>

            {{-- Tombol aksi --}}
            <div class="detail-footer">
                <a
                    href="{{ route('admin.layanan.index') }}"
                    class="detail-btn detail-btn-back"
                >
                    Kembali
                </a>

                <a
                    href="{{ route('admin.layanan.edit', $service->id) }}"
                    class="detail-btn detail-btn-edit"
                >
                    Edit Layanan
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
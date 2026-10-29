@extends('layouts.customer')

@section('title', 'Layanan & Harga - Bengkel Royal Motor')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<style>
    .dt-page, .dt-page * { box-sizing: border-box; }
    .dt-page { color: #192740; min-width: 0; }

    .rl-page { width: 100%; max-width: 1450px; margin: 0 auto; padding: 0 0 30px; }

    .rl-head {
        margin-bottom: 22px; padding: 23px 25px;
        background: linear-gradient(120deg,#fff,#f7faff);
        border: 1px solid #e3e9f2; border-left: 4px solid #3264d8;
        border-radius: 18px; box-shadow: 0 5px 22px rgba(31,52,88,.045);
    }
    .rl-crumb { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:12px; color:#7182a3; font-size:12px; }
    .rl-crumb span:last-child { color:#3264d8; font-weight:700; }
    .rl-label { display:inline-flex; align-items:center; gap:7px; margin-bottom:8px; color:#3264d8; font-size:11px; font-weight:800; letter-spacing:1px; text-transform:uppercase; }
    .rl-label:before { content:""; width:7px; height:7px; border-radius:50%; background:#3264d8; }
    .rl-title { margin:0; color:#14213d; font-size:27px; font-weight:800; line-height:1.35; }
    .rl-desc { max-width:650px; margin:8px 0 0; color:#7182a3; font-size:13px; line-height:1.8; }

    .rl-stats { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:17px; margin-bottom:22px; }
    .rl-stat { min-width:0; padding:19px 21px; background:#fff; border:1px solid #e3e9f2; border-top:3px solid #64748b; border-radius:16px; box-shadow:0 5px 22px rgba(31,52,88,.045); }
    .rl-stat:nth-child(2) { border-top-color:#0f9660; }
    .rl-stat:nth-child(3) { border-top-color:#3264d8; }
    .rl-stat-label { color:#60708a; font-size:12px; font-weight:700; }
    .rl-stat-number { margin-top:10px; color:#14213d; font-size:26px; font-weight:800; line-height:1.4; overflow-wrap:anywhere; }
    .rl-stat:nth-child(2) .rl-stat-number { color:#0f9660; }
    .rl-stat:nth-child(3) .rl-stat-number { color:#3264d8; }
    .rl-stat-desc { margin-top:5px; color:#8491a8; font-size:11px; line-height:1.6; overflow-wrap:anywhere; }

    .dt-page .panel { margin-bottom:18px; overflow:hidden; background:#fff; border:1px solid #e3e9f2; border-radius:18px; box-shadow:0 5px 22px rgba(31,52,88,.045); }
    .dt-page .panel-header { padding:21px 23px; background:linear-gradient(135deg,#fff,#f8faff); border-bottom:1px solid #edf1f7; }
    .dt-page .panel-header-top { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; }
    .dt-page .panel-heading { display:flex; align-items:center; gap:14px; min-width:0; }
    .dt-page .panel-heading-icon { width:45px; height:45px; display:grid; place-items:center; flex-shrink:0; border-radius:14px; background:linear-gradient(145deg,#527fff,#3158cb); color:#fff; }
    .dt-page .panel-title { margin:0; color:#1a2943; font-size:15px; font-weight:800; }
    .dt-page .panel-subtitle { margin-top:5px; color:#8794a9; font-size:12px; line-height:1.6; }
    .dt-page .panel-tag { flex-shrink:0; padding:7px 10px; color:#3264d8; background:#edf3ff; border:1px solid #dce7ff; border-radius:7px; font-size:11px; font-weight:750; }
    .dt-page .empty-state { padding:44px 15px; color:#8a97ab; text-align:center; font-size:13px; line-height:1.8; }

    .dt-page .table-wrapper { width:100%; padding:18px 22px 20px; }
    .dt-page .dt-strong { color:#14213d; font-size:13px; font-weight:750; line-height:1.6; overflow-wrap:anywhere; }
    .dt-page .dt-total { color:#3264d8; font-size:13px; font-weight:800; white-space:nowrap; }

    .dt-page table.dt-table { width:100%; border-collapse:collapse; border-spacing:0; border:1px solid #e2e9f3; text-align:left; background:#fff; }
    .dt-page table.dt-table thead th { padding:15px 14px; color:#60708a; background:#f5f8fd; border-bottom:1px solid #e2e9f3; border-right:1px solid #e2e9f3; font-size:11px; font-weight:800; letter-spacing:.35px; text-transform:uppercase; white-space:nowrap; }
    .dt-page table.dt-table tbody td { padding:11px 14px; color:#52647b; border-bottom:1px solid #e2e9f3; border-right:1px solid #e2e9f3; font-size:12px; line-height:1.7; vertical-align:middle; white-space:nowrap; }
    .dt-page table.dt-table tbody td.col-wrap { white-space:normal; overflow-wrap:anywhere; }
    .dt-page table.dt-table thead th:last-child, .dt-page table.dt-table tbody td:last-child { border-right:none; }
    .dt-page table.dt-table tbody tr:nth-child(even) { background:#fbfcff; }
    .dt-page table.dt-table tbody tr:hover { background:#f2f6ff; }
    .dt-page table.dataTable.no-footer { border-bottom:1px solid #e2e9f3; }

    .dt-page .dataTables_wrapper { width:100%; color:#52647b; font-size:12px; }
    .dt-page .dt-top, .dt-page .dt-bottom { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; }
    .dt-page .dt-top { margin-bottom:14px; }
    .dt-page .dt-bottom { margin-top:14px; }
    .dt-page .dt-buttons { display:flex; flex-wrap:wrap; gap:0; float:none; margin:0; }
    .dt-page .dt-button { margin:0 !important; padding:8px 13px !important; color:#fff !important; background:#3b4752 !important; background-image:none !important; border:1px solid #2f3a45 !important; border-radius:0 !important; font-size:12px !important; font-weight:700 !important; box-shadow:none !important; }
    .dt-page .dt-button:first-child { border-radius:7px 0 0 7px !important; }
    .dt-page .dt-button:last-child { border-radius:0 7px 7px 0 !important; }
    .dt-page .dt-button:only-child { border-radius:7px !important; }
    .dt-page .dt-button:hover { background:#2b343d !important; }

    .dt-page .dataTables_filter, .dt-page .dataTables_length { float:none; margin:0; }
    .dt-page .dataTables_filter label { display:flex; align-items:center; flex-wrap:wrap; gap:7px; }
    .dt-page .dataTables_filter input, .dt-page .dataTables_length select { max-width:100%; padding:8px 10px; color:#14213d; background:#fff; border:1px solid #d3dcea; border-radius:7px; font-size:12px; outline:none; }
    .dt-page .dataTables_filter input:focus { border-color:#3264d8; box-shadow:0 0 0 3px rgba(50,100,216,.12); }
    .dt-page .dataTables_info { float:none; padding:0; color:#7182a3; line-height:1.7; }
    .dt-page .dataTables_paginate { display:flex; flex-wrap:wrap; float:none; padding:0; }
    .dt-page .dataTables_paginate .paginate_button { padding:7px 11px !important; margin:0 0 0 -1px !important; color:#52647b !important; background:#fff !important; background-image:none !important; border:1px solid #d3dcea !important; border-radius:0 !important; box-shadow:none !important; }
    .dt-page .dataTables_paginate .paginate_button:first-child { border-radius:7px 0 0 7px !important; }
    .dt-page .dataTables_paginate .paginate_button:last-child { border-radius:0 7px 7px 0 !important; }
    .dt-page .dataTables_paginate .paginate_button.current { color:#fff !important; background:#3264d8 !important; border-color:#3264d8 !important; }
    .dt-page .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) { background:#eef3fc !important; }
    .dt-page .dataTables_paginate .paginate_button.disabled { color:#a7b2c4 !important; }
    div.dt-button-background { background:transparent !important; }
    div.dt-button-collection { padding:6px 0; border:1px solid #dce5f1; border-radius:8px; box-shadow:0 8px 24px rgba(39,61,99,.15); }
    div.dt-button-collection .dt-button { display:block; width:100%; color:#14213d !important; background:#fff !important; border:none !important; border-radius:0 !important; text-align:left; }
    div.dt-button-collection .dt-button.active, div.dt-button-collection .dt-button.dt-button-active { color:#fff !important; background:#3264d8 !important; }

    .dt-page .status { display:inline-flex; align-items:center; justify-content:center; padding:6px 9px; border:1px solid transparent; border-radius:7px; font-size:10px; font-weight:800; line-height:1.5; white-space:nowrap; }
    .dt-page .status.info { color:#2457bd; background:#e7efff; border-color:#cbdcff; }

    .dt-page .dt-mobile { display:none; padding:14px; }
    .dt-page .dt-card { padding:15px; margin-bottom:12px; background:#fff; border:1px solid #dce5f1; border-left:3px solid #3264d8; border-radius:11px; box-shadow:0 3px 10px rgba(39,61,99,.035); }
    .dt-page .dt-card-top { display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
    .dt-page .dt-card-top > .dt-strong { min-width:0; flex:1; font-size:14px; }
    .dt-page .dt-card-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:13px; margin-top:14px; padding-top:14px; border-top:1px solid #e8edf5; }
    .dt-page .dt-card-grid .full { grid-column:1/-1; }
    .dt-page .dt-card-label { color:#8491a8; font-size:11px; line-height:1.5; }
    .dt-page .dt-card-value { margin-top:5px; color:#263752; font-size:12px; font-weight:700; line-height:1.7; overflow-wrap:anywhere; }
    .dt-page .dt-card-total { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-top:14px; padding-top:13px; border-top:1px dashed #d3dcea; }
    .dt-page .dt-card-total span:first-child { color:#14213d; font-size:12px; font-weight:800; }
    .dt-page .dt-card-total .dt-total { font-size:15px; }
    .dt-page .dt-m-search { display:block; width:100%; min-height:44px; margin-bottom:12px; padding:11px 13px; color:#14213d; background:#fff; border:1px solid #d3dcea; border-radius:9px; font-family:inherit; font-size:16px; outline:none; }
    .dt-page .dt-m-search:focus { border-color:#3264d8; box-shadow:0 0 0 3px rgba(50,100,216,.12); }
    .dt-page .dt-m-more { display:none; width:100%; min-height:44px; margin-top:12px; color:#3264d8; background:#edf3ff; border:1px solid #dce7ff; border-radius:9px; font-family:inherit; font-size:13px; font-weight:750; cursor:pointer; }
    .dt-page .dt-m-more:hover { background:#e0eaff; }
    .dt-page .dt-m-empty { display:none; padding:22px 10px; color:#7182a3; font-size:13px; text-align:center; }
    .rl-note { margin-top:4px; padding:13px 16px; color:#52647b; background:#f5f8fd; border:1px solid #dce5f1; border-radius:10px; font-size:12px; line-height:1.8; }
    .rl-foot { margin-top:20px; color:#94a0b2; font-size:11px; line-height:1.7; text-align:center; }

    @media (max-width:1000px) {
        .dt-page .table-wrapper { padding:15px; }
        .rl-stats { gap:12px; }
    }
    @media (max-width:800px) {
        .dt-page .table-wrapper { display:none; }
        .dt-page .dt-mobile { display:block; }
        .rl-head { padding:19px; }
        .rl-title { font-size:24px; }
        .rl-stats { grid-template-columns:1fr; }
        .dt-page .dt-top, .dt-page .dt-bottom { align-items:stretch; flex-direction:column; }
        .dt-page .dt-buttons { width:100%; }
        .dt-page .dt-button { flex:1 1 auto; }
        .dt-page .dataTables_filter label { align-items:flex-start; flex-direction:column; }
        .dt-page .dataTables_filter input { width:100%; margin-left:0 !important; }
        .dt-page .dataTables_paginate { justify-content:flex-start; }
    }
    @media (max-width:560px) {
        .rl-page { padding-bottom:20px; }
        .rl-head { padding:16px; border-radius:13px; }
        .rl-title { font-size:22px; }
        .rl-desc { font-size:12px; }
        .rl-stat { padding:16px; border-radius:12px; }
        .rl-stat-number { font-size:23px; }
        .dt-page .panel { border-radius:13px; }
        .dt-page .panel-header { padding:16px; }
        .dt-page .panel-heading { gap:10px; }
        .dt-page .panel-heading-icon { width:39px; height:39px; border-radius:11px; }
        .dt-page .panel-title { font-size:14px; }
        .dt-page .panel-tag { display:none; }
        .dt-page .dt-mobile { padding:10px; }
        .dt-page .dt-card { padding:13px; }
        .dt-page .dt-card-top { gap:8px; }
        .dt-page .dt-card-top .status { flex-shrink:0; }
        .rl-note { font-size:11px; }
    }
</style>
@endpush

@section('content')
@php
    $services = $services ?? collect();

    $rp = fn ($n) => 'Rp' . number_format((float) $n, 0, ',', '.');

    $totalOf = fn ($s) => (float) (
        $s->harga ?? (
            ($s->harga_barang ?? 0) +
            ($s->biaya_jasa ?? 0)
        )
    );

    $waktu = function ($menit) {
        $menit = (int) $menit;

        if ($menit <= 0) {
            return '-';
        }

        if ($menit < 60) {
            return $menit . ' menit';
        }

        $jam = intdiv($menit, 60);
        $sisa = $menit % 60;

        return $jam . ' jam' . ($sisa ? ' ' . $sisa . ' menit' : '');
    };

    // Mendukung collection maupun paginator.
    $serviceItems = $services instanceof \Illuminate\Contracts\Pagination\Paginator
        || $services instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
            ? collect($services->items())
            : collect($services);

    $jumlah = $services instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
        ? $services->total()
        : $serviceItems->count();

    $termurah = $serviceItems->sortBy(fn ($s) => $totalOf($s))->first();
    $termahal = $serviceItems->sortByDesc(fn ($s) => $totalOf($s))->first();
@endphp

<div class="rl-page dt-page">

    <section class="rl-head">
        <div class="rl-crumb">
            <span>Pelanggan</span>
            <span aria-hidden="true">/</span>
            <span>Layanan &amp; Harga</span>
        </div>

        <div class="rl-label">Informasi Layanan</div>

        <h1 class="rl-title">Layanan &amp; Harga</h1>

        <p class="rl-desc">
            Daftar layanan servis motor beserta rincian biaya dan estimasi
            waktu pengerjaan di Bengkel Royal Motor.
        </p>
    </section>

    @if ($serviceItems->isEmpty())

        <section class="panel">
            <div class="empty-state">
                Belum ada layanan yang tersedia. Silakan cek kembali nanti.
            </div>
        </section>

    @else

        <section class="rl-stats">
            <article class="rl-stat">
                <div class="rl-stat-label">Total Layanan</div>
                <div class="rl-stat-number">{{ $jumlah }}</div>
                <div class="rl-stat-desc">Layanan servis yang tersedia</div>
            </article>

            <article class="rl-stat">
                <div class="rl-stat-label">Harga Terendah</div>
                <div class="rl-stat-number">{{ $rp($totalOf($termurah)) }}</div>
                <div class="rl-stat-desc">{{ $termurah->nama_servis }}</div>
            </article>

            <article class="rl-stat">
                <div class="rl-stat-label">Harga Tertinggi</div>
                <div class="rl-stat-number">{{ $rp($totalOf($termahal)) }}</div>
                <div class="rl-stat-desc">{{ $termahal->nama_servis }}</div>
            </article>
        </section>

        <section class="panel">
            <div class="panel-header">
                <div class="panel-header-top">
                    <div class="panel-heading">
                        <div class="panel-heading-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2"
                                 aria-hidden="true">
                                <rect x="4" y="3" width="16" height="18" rx="2"/>
                                <path d="M8 7h8M8 11h8M8 15h5"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="panel-title">Daftar Layanan Servis</h2>
                            <div class="panel-subtitle">
                                Harga mencakup barang dan jasa sesuai rincian di bawah.
                            </div>
                        </div>
                    </div>

                    <span class="panel-tag">{{ $jumlah }} Layanan</span>
                </div>
            </div>

            {{-- TABEL DESKTOP: HANYA MELIHAT DATA --}}
            <div class="table-wrapper">
                <table id="tabelLayananPelanggan" class="dt-table display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Layanan Servis</th>
                            <th>Deskripsi</th>
                            <th>Harga Barang</th>
                            <th>Biaya Jasa</th>
                            <th>Total Harga</th>
                            <th>Estimasi Waktu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($serviceItems as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="col-wrap" style="min-width:180px">
                                    <div class="dt-strong">
                                        {{ $service->nama_servis }}
                                    </div>
                                </td>

                                <td class="col-wrap" style="min-width:240px">
                                    {{ $service->deskripsi ?: '-' }}
                                </td>

                                <td data-order="{{ (float) ($service->harga_barang ?? 0) }}">
                                    {{ $rp($service->harga_barang ?? 0) }}
                                </td>

                                <td data-order="{{ (float) ($service->biaya_jasa ?? 0) }}">
                                    {{ $rp($service->biaya_jasa ?? 0) }}
                                </td>

                                <td data-order="{{ $totalOf($service) }}">
                                    <span class="dt-total">
                                        {{ $rp($totalOf($service)) }}
                                    </span>
                                </td>

                                <td data-order="{{ (int) ($service->estimasi_waktu ?? 0) }}">
                                    <span class="status info">
                                        {{ $waktu($service->estimasi_waktu ?? 0) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- KARTU MOBILE --}}
            <div class="dt-mobile" id="dtMobile">
                <input
                    type="search"
                    id="dtMSearch"
                    class="dt-m-search"
                    placeholder="Cari nama layanan atau deskripsi..."
                    autocomplete="off"
                    aria-label="Cari layanan"
                >

                @foreach ($serviceItems as $service)
                    <article
                        class="dt-card"
                        data-search="{{ \Illuminate\Support\Str::lower(($service->nama_servis ?? '') . ' ' . ($service->deskripsi ?? '')) }}"
                    >
                        <div class="dt-card-top">
                            <div class="dt-strong">
                                {{ $service->nama_servis }}
                            </div>

                            <span class="status info">
                                {{ $waktu($service->estimasi_waktu ?? 0) }}
                            </span>
                        </div>

                        <div class="dt-card-grid">
                            <div class="full">
                                <div class="dt-card-label">Deskripsi</div>
                                <div class="dt-card-value">
                                    {{ $service->deskripsi ?: 'Tidak ada deskripsi.' }}
                                </div>
                            </div>

                            <div>
                                <div class="dt-card-label">Harga Barang</div>
                                <div class="dt-card-value">
                                    {{ $rp($service->harga_barang ?? 0) }}
                                </div>
                            </div>

                            <div>
                                <div class="dt-card-label">Biaya Jasa</div>
                                <div class="dt-card-value">
                                    {{ $rp($service->biaya_jasa ?? 0) }}
                                </div>
                            </div>
                        </div>

                        <div class="dt-card-total">
                            <span>Total Harga</span>
                            <span class="dt-total">
                                {{ $rp($totalOf($service)) }}
                            </span>
                        </div>
                    </article>
                @endforeach

                <div class="dt-m-empty" id="dtMEmpty">
                    Layanan tidak ditemukan.
                </div>

                <button type="button" class="dt-m-more" id="dtMMore">
                    Tampilkan lebih banyak
                </button>
            </div>
        </section>

        <div class="rl-note">
            <strong>Informasi:</strong>
            Harga merupakan informasi awal layanan. Biaya akhir dapat
            menyesuaikan kondisi motor setelah diperiksa oleh mekanik.
        </div>

    @endif

    <div class="rl-foot">
        Bengkel Royal Motor · Layanan &amp; Harga
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    /* =========================================
       KARTU HP: PENCARIAN DAN TAMPILKAN LEBIH BANYAK
    ========================================= */
    function initMobileCards() {
        var container = document.getElementById('dtMobile');

        if (!container) return;

        var input = document.getElementById('dtMSearch');
        var more = document.getElementById('dtMMore');
        var empty = document.getElementById('dtMEmpty');

        var cards = Array.prototype.slice.call(
            container.querySelectorAll('.dt-card')
        );

        if (!input || !more || !empty) return;

        var step = 5;
        var limit = step;

        function render() {
            var query = (input.value || '').toLowerCase().trim();

            var matched = cards.filter(function (card) {
                var text = (card.getAttribute('data-search') || '').toLowerCase();
                return text.indexOf(query) !== -1;
            });

            cards.forEach(function (card) {
                card.style.display = 'none';
            });

            matched.slice(0, limit).forEach(function (card) {
                card.style.display = '';
            });

            more.style.display = matched.length > limit ? 'block' : 'none';
            empty.style.display = matched.length === 0 ? 'block' : 'none';
        }

        input.addEventListener('input', function () {
            limit = step;
            render();
        });

        more.addEventListener('click', function () {
            limit += step;
            render();
        });

        render();
    }

    /* =========================================
       MEMUAT LIBRARY TANPA DUPLIKASI
    ========================================= */
    function loadScript(src, callback) {
        var script = document.createElement('script');
        script.src = src;
        script.onload = callback;
        script.onerror = function () {
            console.error('Gagal memuat library:', src);
        };
        document.head.appendChild(script);
    }

    function loadSequentially(list, callback) {
        var index = 0;

        function next() {
            if (index >= list.length) {
                callback();
                return;
            }

            var item = list[index++];

            if (item.check()) {
                next();
                return;
            }

            loadScript(item.src, next);
        }

        next();
    }

    /* =========================================
       DATATABLE DESKTOP
       Tidak ada tombol tambah, edit, atau hapus.
    ========================================= */
    function initDesktopTable() {
        var table = document.getElementById('tabelLayananPelanggan');

        if (!table || !window.jQuery || !jQuery.fn.DataTable) return;

        if (jQuery.fn.DataTable.isDataTable(table)) return;

        var dataTable = jQuery(table).DataTable({
            dom:
                "<'dt-top'<'dt-buttons'B><'dt-search'f>>" +
                "rt" +
                "<'dt-bottom'<'dt-info'i><'dt-paging'p>>",

            pageLength: 10,
            lengthChange: false,
            searching: true,
            ordering: true,
            autoWidth: false,
            scrollX: true,
            stateSave: true,
            order: [],

            columnDefs: [
                {
                    targets: 0,
                    width: '42px',
                    orderable: false,
                    searchable: false
                }
            ],

            buttons: [
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Pengaturan Kolom',
                    background: false
                }
            ],

            language: {
                emptyTable: 'Belum ada layanan yang tersedia.',
                search: 'Cari:',
                searchPlaceholder: 'Cari layanan...',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ layanan',
                infoEmpty: 'Tidak ada data layanan',
                infoFiltered: '(disaring dari _MAX_ layanan)',
                zeroRecords: 'Layanan tidak ditemukan.',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    previous: '‹',
                    next: '›'
                },
                buttons: {
                    copyTitle: 'Data tersalin',
                    copySuccess: {
                        _: '%d baris berhasil disalin'
                    }
                }
            }
        });

        jQuery(window).on('resize', function () {
            dataTable.columns.adjust();
        });
    }

    function init() {
        initMobileCards();

        if (!document.getElementById('tabelLayananPelanggan')) return;

        var scripts = [
            {
                src: 'https://code.jquery.com/jquery-3.7.1.min.js',
                check: function () {
                    return !!window.jQuery;
                }
            },
            {
                src: 'https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js',
                check: function () {
                    return !!(window.jQuery && jQuery.fn.DataTable);
                }
            },
            {
                src: 'https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js',
                check: function () {
                    return !!(window.jQuery && jQuery.fn.dataTable &&
                        jQuery.fn.dataTable.Buttons);
                }
            },
            {
                src: 'https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js',
                check: function () {
                    return !!(window.jQuery &&
                        jQuery.fn.dataTable &&
                        jQuery.fn.dataTable.ext.buttons.copyHtml5);
                }
            },
            {
                src: 'https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js',
                check: function () {
                    return !!(window.jQuery &&
                        jQuery.fn.dataTable &&
                        jQuery.fn.dataTable.ext.buttons.colvis);
                }
            }
        ];

        loadSequentially(scripts, initDesktopTable);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush
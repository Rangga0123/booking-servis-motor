@extends('admin.layouts.app')

@section('title', 'Pelanggan & Pesanan')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .order-page,
    .order-page * { box-sizing: border-box; }
    .order-page { color: #192740; }
    .page-heading { gap: 20px; margin-bottom: 26px; align-items: center; }

    .order-page .panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e3e9f2;
        border-radius: 18px;
        box-shadow: 0 5px 22px rgba(31, 52, 88, .045);
    }
    .order-page .panel-header {
        padding: 21px 23px;
        background: linear-gradient(135deg, #fff, #f8faff);
        border-bottom: 1px solid #edf1f7;
    }
    .order-page .panel-header-top {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 16px;
    }
    .order-page .panel-heading { display: flex; align-items: center; gap: 14px; }
    .order-page .panel-heading-icon {
        width: 45px; height: 45px; display: grid; place-items: center; flex-shrink: 0;
        border-radius: 14px; background: linear-gradient(145deg, #527fff, #3158cb); color: #fff;
    }
    .order-page .panel-title { color: #1a2943; font-size: 15px; font-weight: 800; }
    .order-page .panel-subtitle { margin-top: 5px; color: #8794a9; font-size: 12px; }
    .order-page .panel-tag {
        flex-shrink: 0; padding: 7px 10px; color: #3264d8; background: #edf3ff;
        border: 1px solid #dce7ff; border-radius: 7px; font-size: 11px; font-weight: 750;
    }

    .order-page .filter-select {
        width: 170px; max-width: 100%; padding: 10px 13px; border: 1px solid #dfe6f1; border-radius: 10px;
        background: #fff; color: #40516e; font-family: inherit; font-size: 12px; font-weight: 700; outline: none;
    }
    .order-page .filter-select:focus { border-color: #3264d8; box-shadow: 0 0 0 3px rgba(50,100,216,.12); }

    /* ===== TABEL (sama dengan riwayat pelanggan) ===== */
    .order-page .table-wrapper { width: 100%; padding: 18px 22px 20px; }
    .order-page .ord-strong { color: #14213d; font-size: 13px; font-weight: 750; line-height: 1.6; overflow-wrap: anywhere; }
    .order-page .ord-small { margin-top: 4px; color: #8491a8; font-size: 11px; line-height: 1.6; overflow-wrap: anywhere; }

    .order-page table.order-table {
        width: 100%; border-collapse: collapse; border-spacing: 0;
        border: 1px solid #e2e9f3; text-align: left; background: #fff;
    }
    .order-page table.order-table thead th {
        padding: 15px 14px; color: #60708a; background: #f5f8fd;
        border-bottom: 1px solid #e2e9f3; border-right: 1px solid #e2e9f3;
        font-size: 11px; font-weight: 800; letter-spacing: .35px;
        text-transform: uppercase; white-space: nowrap;
    }
    .order-page table.order-table tbody td {
        padding: 11px 14px; color: #52647b; border-bottom: 1px solid #e2e9f3; border-right: 1px solid #e2e9f3;
        font-size: 12px; line-height: 1.7; vertical-align: middle; white-space: nowrap;
    }
    .order-page table.order-table tbody td.col-wrap { white-space: normal; }
    .order-page table.order-table .col-pemesan { min-width: 200px; }
    .order-page table.order-table .col-keluhan { min-width: 240px; }
    .order-page table.order-table .col-servis { min-width: 170px; }
    .order-page table.order-table thead th:last-child,
    .order-page table.order-table tbody td:last-child { border-right: none; }
    .order-page table.order-table tbody tr:nth-child(even) { background: #fbfcff; }
    .order-page table.order-table tbody tr:hover { background: #f2f6ff; }
    .order-page table.dataTable.no-footer { border-bottom: 1px solid #e2e9f3; }

    .order-page .dataTables_wrapper { font-size: 12px; color: #52647b; }
    .order-page .ord-dt-top,
    .order-page .ord-dt-bottom { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; }
    .order-page .ord-dt-top { margin-bottom: 14px; }
    .order-page .ord-dt-bottom { margin-top: 14px; }
    .order-page .dt-buttons { display: flex; flex-wrap: wrap; gap: 0; float: none; margin: 0; }
    .order-page .dt-button {
        margin: 0 !important; padding: 8px 15px !important; color: #fff !important;
        background: #3b4752 !important; background-image: none !important;
        border: 1px solid #2f3a45 !important; border-radius: 0 !important;
        font-size: 12px !important; font-weight: 700 !important; box-shadow: none !important;
    }
    .order-page .dt-button:first-child { border-radius: 7px 0 0 7px !important; }
    .order-page .dt-button:last-child { border-radius: 0 7px 7px 0 !important; }
    .order-page .dt-button:only-child { border-radius: 7px !important; }
    .order-page .dt-button:hover { background: #2b343d !important; background-image: none !important; }
    .order-page .dataTables_filter,
    .order-page .dataTables_length { float: none; margin: 0; }
    .order-page .dataTables_filter input,
    .order-page .dataTables_length select {
        padding: 7px 10px; color: #14213d; border: 1px solid #d3dcea; border-radius: 7px; font-size: 12px; outline: none;
    }
    .order-page .dataTables_filter input:focus { border-color: #3264d8; box-shadow: 0 0 0 3px rgba(50,100,216,.12); }
    .order-page .dataTables_info { float: none; padding: 0; color: #7182a3; }
    .order-page .dataTables_paginate { float: none; padding: 0; }
    .order-page .dataTables_paginate .paginate_button {
        padding: 6px 12px !important; margin: 0 0 0 -1px !important; color: #52647b !important;
        background: #fff !important; background-image: none !important;
        border: 1px solid #d3dcea !important; border-radius: 0 !important; box-shadow: none !important;
    }
    .order-page .dataTables_paginate .paginate_button:first-child { border-radius: 7px 0 0 7px !important; }
    .order-page .dataTables_paginate .paginate_button:last-child { border-radius: 0 7px 7px 0 !important; }
    .order-page .dataTables_paginate .paginate_button.current { color: #fff !important; background: #3264d8 !important; border-color: #3264d8 !important; }
    .order-page .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) { background: #eef3fc !important; }
    .order-page .dataTables_paginate .paginate_button.disabled { color: #a7b2c4 !important; }
    div.dt-button-background { background: transparent !important; }
    div.dt-button-collection { padding: 6px 0; border: 1px solid #dce5f1; border-radius: 8px; box-shadow: 0 8px 24px rgba(39,61,99,.15); }
    div.dt-button-collection .dt-button { display: block; width: 100%; color: #14213d !important; background: #fff !important; border: none !important; border-radius: 0 !important; text-align: left; }
    div.dt-button-collection .dt-button.active,
    div.dt-button-collection .dt-button.dt-button-active { color: #fff !important; background: #3264d8 !important; }

    /* STATUS (sama dengan riwayat pelanggan) */
    .order-page .status {
        display: inline-flex; align-items: center; justify-content: center; padding: 6px 9px;
        border: 1px solid transparent; border-radius: 7px; font-size: 10px; font-weight: 800;
        line-height: 1.5; white-space: nowrap;
    }
    .order-page .status.waiting  { color: #956000; background: #fff5dc; border-color: #ffe3a0; }
    .order-page .status.process  { color: #2457bd; background: #e7efff; border-color: #cbdcff; }
    .order-page .status.done     { color: #087647; background: #e1f8eb; border-color: #bcebd0; }
    .order-page .status.rejected { color: #bb2942; background: #ffedf0; border-color: #ffd0d8; }

    .order-page .detail-btn {
        min-height: 32px; padding: 7px 12px; border: 1px solid #d2e2ff; border-radius: 7px; background: #eaf2ff;
        color: #1854b4; font-family: inherit; font-size: 10px; font-weight: 800; white-space: nowrap; cursor: pointer; transition: .2s ease;
    }
    .order-page .detail-btn:hover { background: #d9e7ff; transform: translateY(-1px); }

    .order-page .empty-state { padding: 44px 15px; color: #8a97ab; text-align: center; font-size: 13px; }

    /* ===== KARTU MOBILE ===== */
    .order-page .ord-mobile { display: none; padding: 14px; }
    .order-page .ord-card {
        padding: 15px; margin-bottom: 12px; background: #fff; border: 1px solid #dce5f1;
        border-left: 3px solid #3264d8; border-radius: 11px; box-shadow: 0 3px 10px rgba(39,61,99,.035);
    }
    .order-page .ord-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    .order-page .ord-card-grid {
        display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 13px;
        margin-top: 14px; padding-top: 14px; border-top: 1px solid #e8edf5;
    }
    .order-page .ord-card-grid .full { grid-column: 1 / -1; }
    .order-page .ord-card-label { color: #8491a8; font-size: 11px; line-height: 1.5; }
    .order-page .ord-card-value { margin-top: 5px; color: #263752; font-size: 12px; font-weight: 700; line-height: 1.7; overflow-wrap: anywhere; }
    .order-page .ord-card-actions { margin-top: 14px; padding-top: 13px; border-top: 1px solid #e8edf5; }
    .order-page .ord-m-search {
        width: 100%; margin-bottom: 12px; padding: 11px 13px; color: #14213d; background: #fff;
        border: 1px solid #d3dcea; border-radius: 9px; font-family: inherit; font-size: 16px; outline: none;
    }
    .order-page .ord-m-search:focus { border-color: #3264d8; box-shadow: 0 0 0 3px rgba(50,100,216,.12); }
    .order-page .ord-m-more {
        display: none; width: 100%; min-height: 44px; margin-top: 12px; color: #3264d8; background: #edf3ff;
        border: 1px solid #dce7ff; border-radius: 9px; font-family: inherit; font-size: 13px; font-weight: 750; cursor: pointer;
    }
    .order-page .ord-m-empty { display: none; padding: 22px 10px; color: #7182a3; font-size: 13px; text-align: center; }

    /* MODAL DETAIL */
    .order-page .modal {
        display: none; position: fixed; inset: 0; z-index: 2000;
        align-items: center; justify-content: center; padding: 18px;
        background: rgba(12, 23, 43, .68); backdrop-filter: blur(5px);
    }
    .order-page .modal.show { display: flex; }
    .order-page .modal-box {
        width: 100%; max-width: 640px; max-height: 90vh; overflow-y: auto;
        background: #fff; border-radius: 19px; box-shadow: 0 25px 80px #0003;
    }
    .order-page .modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 23px; border-bottom: 1px solid #e8edf5;
    }
    .order-page .modal-header h3 { margin: 0; color: #1d2c45; font-size: 16px; font-weight: 800; }
    .order-page .close-modal {
        width: 36px; height: 36px; border: 1px solid #e7ebf3; border-radius: 10px;
        background: #f5f7fb; color: #53637c; cursor: pointer;
    }
    .order-page .modal-content { padding: 23px; }
    .order-page .detail-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .order-page .detail-item {
        padding: 15px; overflow-wrap: anywhere; background: #f7f9fd;
        border: 1px solid #e9edf5; border-radius: 12px;
    }
    .order-page .detail-item.full { grid-column: 1 / -1; }
    .order-page .detail-item small {
        display: block; margin-bottom: 7px; color: #8996aa; font-size: 10px;
        font-weight: 700; text-transform: uppercase;
    }
    .order-page .detail-item strong { color: #263650; font-size: 12px; line-height: 1.7; white-space: pre-line; }

    /* JAM */
    .clock-box {
        min-width: 240px; display: flex; align-items: center; gap: 12px; padding: 13px 16px;
        background: #fff; border: 1px solid #e2e8f1; border-radius: 15px;
    }
    .clock-icon {
        width: 42px; height: 42px; display: grid; place-items: center; flex-shrink: 0;
        border-radius: 13px; background: #eaf0ff; color: #426fe7;
    }
    .clock-date { margin-bottom: 4px; color: #7c8ba4; font-size: 11px; font-weight: 600; }
    .clock-time { color: #1b2941; font-size: 17px; font-weight: 800; white-space: nowrap; }

    @media (max-width: 800px) {
        .order-page .table-wrapper { display: none; }
        .order-page .ord-mobile { display: block; }
    }

    @media (max-width: 650px) {
        .page-heading { align-items: stretch; }
        .clock-box { width: 100%; min-width: 0; }
        .order-page .panel-header { padding: 16px; }
        .order-page .panel-tag { display: none; }
        .order-page .filter-select { width: 100%; font-size: 16px; }
        .order-page .ord-mobile { padding: 10px; }
        .order-page .ord-card { padding: 13px; }
        .order-page .detail-grid { grid-template-columns: minmax(0, 1fr); }
    }
</style>
@endpush

@section('content')
@php
    $rp = fn ($n) => 'Rp' . number_format((float) $n, 0, ',', '.');

    $daftar = $bookings->map(function ($item) use ($rp) {
        $status = strtolower($item->status ?? '');

        $jam = $item->jam_booking
            ? substr(str_replace(',', ':', trim($item->jam_booking)), 0, 5)
            : '';

        $tanggalRaw = $item->tanggal_booking
            ? \Carbon\Carbon::parse($item->tanggal_booking)
            : null;

        $tanggal = $tanggalRaw ? $tanggalRaw->format('d M Y') : '-';

        $metode = $item->metode_pembayaran ?: '-';
        if (in_array(strtolower($metode), ['tunai', 'tunai / bayar di kasir', 'tunai (bayar di kasir)'])) {
            $metode = 'Tunai (bayar di kasir)';
        }

        $d = [
            'item'        => $item,
            'kelasStatus' => match ($status) {
                'selesai' => 'done',
                'ditolak', 'dibatalkan', 'batal' => 'rejected',
                'disetujui', 'diterima', 'proses', 'diproses', 'sedang dikerjakan', 'dikerjakan' => 'process',
                default => 'waiting',
            },
            'labelStatus' => ucfirst($item->status ?? 'Menunggu'),
            'pemesan'     => $item->nama_pelanggan ?? $item->user?->name ?? 'Pelanggan',
            'email'       => $item->user?->email ?? 'Email tidak tersedia',
            'hp'          => $item->no_hp ?: '-',
            'motor'       => $item->nama_motor ?: '-',
            'plat'        => $item->plat_nomor ?: '-',
            'keluhan'     => $item->keluhan ?: '-',
            'tanggal'     => $tanggal,
            'jam'         => $jam,
            'tanggalSort' => ($tanggalRaw ? $tanggalRaw->format('Y-m-d') : '') . ' ' . $jam,
            'servis'      => $item->service?->nama_servis ?? $item->jenis_servis ?? '-',
            'mekanik'     => $item->mechanic?->nama_mekanik ?? 'Belum dipilih',
            'barang'      => (float) ($item->harga_barang ?? 0),
            'jasa'        => (float) ($item->biaya_jasa ?? 0),
            'total'       => (float) ($item->harga ?? 0),
            'metode'      => $metode,
        ];

        // Data untuk modal detail
        $d['attrs'] = [
            'customer'  => $d['pemesan'],
            'email'     => $item->user?->email ?? '-',
            'phone'     => $d['hp'],
            'motor'     => $d['motor'],
            'plate'     => $d['plat'],
            'service'   => $d['servis'],
            'complaint' => $d['keluhan'],
            'date'      => $tanggal,
            'time'      => $jam,
            'status'    => $d['labelStatus'],
            'mechanic'  => $d['mekanik'],
            'barang'    => $rp($d['barang']),
            'jasa'      => $rp($d['jasa']),
            'total'     => $rp($d['total']),
            'payment'   => $metode,
            'reason'    => $item->alasan_penolakan ?? '',
        ];

        return $d;
    });

    $totalData = $daftar->count();
@endphp

<section class="page-heading">
    <div>
        <div class="breadcrumb">Admin / Pelanggan / Daftar Pesanan</div>
        <h1 class="page-title">Daftar Pesanan</h1>
        <p class="page-description">Lihat pelanggan, booking masuk, dan status pesanan servis.</p>
    </div>

    <div class="clock-box">
        <div class="clock-icon">
            <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="3" y="4" width="18" height="17" rx="2"/>
                <path d="M8 2v4M16 2v4M3 10h18"/>
            </svg>
        </div>
        <div>
            <div id="liveDate" class="clock-date">Memuat tanggal...</div>
            <div id="liveTime" class="clock-time">--:--:-- WIB</div>
        </div>
    </div>
</section>

<div class="order-page">
    <section class="panel">
        <div class="panel-header">
            <div class="panel-header-top">
                <div class="panel-heading">
                    <div class="panel-heading-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                            <path d="M8 7h8M8 11h8M8 15h5"/>
                        </svg>
                    </div>
                    <div>
                        <div class="panel-title">Daftar Pesanan Servis Masuk</div>
                        <div class="panel-subtitle">Lihat detail pesanan, tanggal booking, dan status pelanggan.</div>
                    </div>
                </div>

                <div style="display:flex;align-items:center;flex-wrap:wrap;gap:10px">
                    <select id="filterStatus" class="filter-select" aria-label="Filter status booking">
                        <option value="^(menunggu|pending|disetujui|diterima|proses|diproses|sedang dikerjakan|dikerjakan)$" selected>Belum selesai</option>
                        <option value="">Semua Status</option>
                        <option value="^(menunggu|pending)$">Menunggu</option>
                        <option value="^(disetujui|diterima)$">Disetujui</option>
                        <option value="^(proses|diproses|sedang dikerjakan|dikerjakan)$">Diproses</option>
                        <option value="^selesai$">Selesai</option>
                        <option value="^ditolak$">Ditolak</option>
                        <option value="^(dibatalkan|batal)$">Dibatalkan</option>
                    </select>
                    <span class="panel-tag">{{ $totalData }} Pesanan</span>
                </div>
            </div>
        </div>

        @if($daftar->isEmpty())
            <div class="empty-state">Belum ada pesanan servis.</div>
        @else

            {{-- TABEL DESKTOP (DataTables) --}}
            <div class="table-wrapper">
                <table id="tabelPesanan" class="order-table display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemesan</th>
                            <th>No. HP</th>
                            <th>Kendaraan</th>
                            <th>Jadwal</th>
                            <th>Layanan Servis</th>
                            <th>Mekanik</th>
                            <th>Total Biaya</th>
                            <th>Pembayaran</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftar as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="col-wrap col-pemesan">
                                    <div class="ord-strong">{{ $d['pemesan'] }}</div>
                                    <div class="ord-small">{{ $d['email'] }}</div>
                                </td>
                                <td>{{ $d['hp'] }}</td>
                                <td>
                                    <div class="ord-strong">{{ $d['motor'] }}</div>
                                    <div class="ord-small">{{ $d['plat'] }}</div>
                                </td>
                                <td data-order="{{ $d['tanggalSort'] }}">
                                    <div class="ord-strong">{{ $d['tanggal'] }}</div>
                                    <div class="ord-small">{{ $d['jam'] ? $d['jam'] . ' WIB' : '-' }}</div>
                                </td>
                                <td class="col-wrap col-servis"><div class="ord-strong">{{ $d['servis'] }}</div></td>
                                <td>{{ $d['mekanik'] }}</td>
                                <td data-order="{{ $d['total'] }}">
                                    <div class="ord-strong" title="Barang {{ $rp($d['barang']) }} + Jasa {{ $rp($d['jasa']) }}">{{ $rp($d['total']) }}</div>
                                </td>
                                <td>{{ $d['metode'] }}</td>
                                <td class="col-wrap col-keluhan">{{ $d['keluhan'] }}</td>
                                <td><span class="status {{ $d['kelasStatus'] }}">{{ $d['labelStatus'] }}</span></td>
                                <td style="text-align:center">
                                    <button type="button" class="detail-btn" onclick="openDetail(this)"
                                        @foreach($d['attrs'] as $k => $v) data-{{ $k }}="{{ $v }}" @endforeach
                                    >Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- KARTU MOBILE --}}
            <div class="ord-mobile">
                <input type="search" id="ordMobileSearch" class="ord-m-search"
                       placeholder="Cari pemesan / motor / plat / layanan / status" autocomplete="off">

                @foreach($daftar as $d)
                    <article class="ord-card"
                             data-status="{{ strtolower($d['item']->status ?? 'menunggu') }}"
                             data-search="{{ strtolower($d['pemesan'].' '.$d['motor'].' '.$d['plat'].' '.$d['servis'].' '.$d['mekanik'].' '.$d['labelStatus'].' '.$d['tanggal']) }}">
                        <div class="ord-card-top">
                            <div>
                                <div class="ord-strong">{{ $d['pemesan'] }}</div>
                                <div class="ord-small">{{ $d['hp'] }}</div>
                            </div>
                            <span class="status {{ $d['kelasStatus'] }}">{{ $d['labelStatus'] }}</span>
                        </div>

                        <div class="ord-card-grid">
                            <div>
                                <div class="ord-card-label">Motor</div>
                                <div class="ord-card-value">{{ $d['motor'] }}</div>
                            </div>
                            <div>
                                <div class="ord-card-label">Nomor Polisi</div>
                                <div class="ord-card-value">{{ $d['plat'] }}</div>
                            </div>
                            <div>
                                <div class="ord-card-label">Jadwal</div>
                                <div class="ord-card-value">
                                    {{ $d['tanggal'] }}<br>{{ $d['jam'] ? $d['jam'] . ' WIB' : '-' }}
                                </div>
                            </div>
                            <div>
                                <div class="ord-card-label">Layanan Servis</div>
                                <div class="ord-card-value">{{ $d['servis'] }}</div>
                            </div>
                            <div class="full">
                                <div class="ord-card-label">Mekanik</div>
                                <div class="ord-card-value">{{ $d['mekanik'] }}</div>
                            </div>
                            <div>
                                <div class="ord-card-label">Total Biaya</div>
                                <div class="ord-card-value">{{ $rp($d['total']) }}</div>
                            </div>
                            <div>
                                <div class="ord-card-label">Pembayaran</div>
                                <div class="ord-card-value">{{ $d['metode'] }}</div>
                            </div>
                        </div>

                        <div class="ord-card-actions">
                            <button type="button" class="detail-btn" onclick="openDetail(this)"
                                @foreach($d['attrs'] as $k => $v) data-{{ $k }}="{{ $v }}" @endforeach
                            >Detail</button>
                        </div>
                    </article>
                @endforeach

                <div class="ord-m-empty" id="ordMobileEmpty">Data tidak ditemukan</div>
                <button type="button" class="ord-m-more" id="ordMobileMore">Tampilkan lebih banyak</button>
            </div>
        @endif
    </section>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="modal" onclick="closeModalOutside(event)">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Detail Pesanan Servis</h3>
                <button type="button" class="close-modal" onclick="closeDetail()" aria-label="Tutup">✕</button>
            </div>

            <div class="modal-content">
                <div class="detail-grid">
                    <div class="detail-item"><small>Pelanggan</small><strong id="detailCustomer">-</strong></div>
                    <div class="detail-item"><small>Email</small><strong id="detailEmail">-</strong></div>
                    <div class="detail-item"><small>No. HP</small><strong id="detailPhone">-</strong></div>
                    <div class="detail-item"><small>Kendaraan</small><strong id="detailMotor">-</strong></div>
                    <div class="detail-item"><small>Plat Nomor</small><strong id="detailPlate">-</strong></div>
                    <div class="detail-item"><small>Jenis Servis</small><strong id="detailService">-</strong></div>
                    <div class="detail-item"><small>Tanggal</small><strong id="detailDate">-</strong></div>
                    <div class="detail-item"><small>Jam</small><strong id="detailTime">-</strong></div>
                    <div class="detail-item"><small>Mekanik</small><strong id="detailMechanic">-</strong></div>
                    <div class="detail-item"><small>Status</small><strong id="detailStatus">-</strong></div>
                    <div class="detail-item"><small>Harga Barang</small><strong id="detailBarang">-</strong></div>
                    <div class="detail-item"><small>Biaya Jasa</small><strong id="detailJasa">-</strong></div>
                    <div class="detail-item"><small>Total Biaya</small><strong id="detailTotal">-</strong></div>
                    <div class="detail-item"><small>Pembayaran</small><strong id="detailPayment">-</strong></div>
                    <div class="detail-item full"><small>Keluhan</small><strong id="detailComplaint">-</strong></div>
                    <div class="detail-item full" id="reasonBox" style="display:none">
                        <small>Alasan Penolakan</small><strong id="detailReason">-</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Jam & tanggal live
    function updateClock() {
        const now = new Date();
        const dateEl = document.getElementById('liveDate');
        const timeEl = document.getElementById('liveTime');

        if (dateEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
                timeZone: 'Asia/Jakarta'
            });
        }
        if (timeEl) {
            timeEl.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                hour12: false, timeZone: 'Asia/Jakarta'
            }) + ' WIB';
        }
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Modal detail
    function openDetail(button) {
        const d = button.dataset;
        const set = (id, val) => document.getElementById(id).textContent = val || '-';

        set('detailCustomer', d.customer);
        set('detailEmail', d.email);
        set('detailPhone', d.phone);
        set('detailMotor', d.motor);
        set('detailPlate', d.plate);
        set('detailService', d.service);
        set('detailComplaint', d.complaint);
        set('detailDate', d.date);
        set('detailTime', d.time ? d.time + ' WIB' : '-');
        set('detailStatus', d.status);
        set('detailMechanic', d.mechanic);
        set('detailBarang', d.barang);
        set('detailJasa', d.jasa);
        set('detailTotal', d.total);
        set('detailPayment', d.payment);

        document.getElementById('reasonBox').style.display = d.reason ? '' : 'none';
        set('detailReason', d.reason);

        document.getElementById('detailModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.remove('show');
        const sidebar = document.getElementById('sidebar');
        const sidebarOpen = window.innerWidth <= 1000 && sidebar && sidebar.classList.contains('open');
        document.body.style.overflow = sidebarOpen ? 'hidden' : '';
    }

    function closeModalOutside(event) {
        if (event.target.id === 'detailModal') closeDetail();
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeDetail();
    });
</script>

@if(! $daftar->isEmpty())
<script>
// Kartu di HP: pencarian + tampil 5 data dulu
(function () {
    var cards = Array.prototype.slice.call(document.querySelectorAll('.ord-mobile .ord-card'));
    if (!cards.length) return;
    var input = document.getElementById('ordMobileSearch');
    var more = document.getElementById('ordMobileMore');
    var empty = document.getElementById('ordMobileEmpty');
    var step = 5, limit = step;
    var select = document.getElementById('filterStatus');

    function render() {
        var q = (input.value || '').toLowerCase().trim();
        var pola = select && select.value ? new RegExp(select.value, 'i') : null;
        var matched = cards.filter(function (c) {
            var cocokStatus = !pola || pola.test(c.getAttribute('data-status'));
            return cocokStatus && c.getAttribute('data-search').indexOf(q) !== -1;
        });
        cards.forEach(function (c) { c.style.display = 'none'; });
        matched.slice(0, limit).forEach(function (c) { c.style.display = ''; });
        more.style.display = matched.length > limit ? 'block' : 'none';
        empty.style.display = matched.length ? 'none' : 'block';
    }

    input.addEventListener('input', function () { limit = step; render(); });
    if (select) select.addEventListener('change', function () { limit = step; render(); });
    more.addEventListener('click', function () { limit += step; render(); });
    render();
})();
</script>

<script>
// Tabel desktop: Copy, Column visibility, cari, urutkan, pagination
(function () {
    function loadScript(src, cb) {
        var s = document.createElement('script');
        s.src = src;
        s.onload = cb;
        document.body.appendChild(s);
    }

    function chain(list, done) {
        if (!list.length) return done();
        loadScript(list[0], function () { chain(list.slice(1), done); });
    }

    var STATUS_COL = 10;

    function initTable() {
        var table = jQuery('#tabelPesanan').DataTable({
            dom: "<'ord-dt-top'<'ord-dt-btns'B><'ord-dt-search'f>>rt<'ord-dt-bottom'<'ord-dt-info'i><'ord-dt-page'p>>",
            stateSave: true,
            pageLength: 10,
            order: [],                       // urutan awal = pesanan terbaru dari server
            autoWidth: false,
            scrollX: true,
            stateLoadParams: function (settings, data) {
                // filter status tidak diingat agar dropdown selalu sinkron
                (data.columns || []).forEach(function (c) { c.search.search = ''; });
            },
            buttons: [
                {
                    extend: 'copy',
                    text: 'Copy',
                    exportOptions: { columns: ':visible:not(:last-child)' }
                },
                {
                    extend: 'colvis',
                    text: 'Column visibility',
                    background: false,
                    columns: ':not(:last-child)'
                }
            ],
            columnDefs: [
                { targets: [2, 9], visible: false },     // No. HP dan Keluhan disembunyikan awalnya
                { targets: 0, width: '40px' },
                { targets: -1, orderable: false, searchable: false }
            ],
            language: {
                search: 'Cari :',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(dari _MAX_ data)',
                zeroRecords: 'Tidak ada pesanan pada filter ini',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                buttons: { copyTitle: 'Tersalin', copySuccess: { _: '%d baris tersalin' } }
            }
        });

        // Filter status
        var select = document.getElementById('filterStatus');
        function terapkanFilter() {
            table.column(STATUS_COL).search(select.value, true, false).draw();
        }
        select.addEventListener('change', terapkanFilter);
        terapkanFilter(); // filter awal: Belum selesai
    }

    function start() {
        chain([
            'https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js'
        ], initTable);
    }

    if (window.jQuery) {
        start();
    } else {
        loadScript('https://code.jquery.com/jquery-3.7.1.min.js', start);
    }
})();
</script>
@endif
@endpush
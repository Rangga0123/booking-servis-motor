@extends('admin.layouts.app')

@section('title', 'Pelanggan & Pesanan')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .order-page,
    .order-page * { box-sizing: border-box; }
    .order-page { color: #212529; }
    .page-heading { gap: 20px; margin-bottom: 26px; align-items: center; }

    /* ===== CARD ===== */
    .order-page .panel { overflow: hidden; background: #fff; border: 1px solid #e9ecef; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .order-page .panel-header { padding: 14px 20px; background: #fff; border-bottom: 1px solid #e9ecef; }
    .order-page .panel-header-top { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .order-page .panel-title { color: #212529; font-size: 16px; font-weight: 400; }
    .order-page .panel-subtitle { margin-top: 3px; color: #6c757d; font-size: 12px; }
    .order-page .panel-tools { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; }
    .order-page .panel-tag { flex-shrink: 0; padding: 6px 10px; color: #004085; background: #e7f1ff; border: 1px solid #b8daff; border-radius: 4px; font-size: 12px; font-weight: 600; }

    .order-page .filter-select { width: 170px; max-width: 100%; min-height: 36px; padding: 6px 10px; color: #495057; background: #fff; border: 1px solid #ced4da; border-radius: 4px; font-family: inherit; font-size: 14px; outline: none; }
    .order-page .filter-select:focus { border-color: #80bdff; box-shadow: 0 0 0 3px rgba(0,123,255,.2); }

    .order-page .empty-state { padding: 44px 15px; color: #6c757d; text-align: center; font-size: 13px; }

    /* ===== TABEL ===== */
    .order-page .table-wrapper { width: 100%; padding: 20px; overflow-x: auto; }
    .order-page .ord-strong { color: #212529; font-size: 14px; font-weight: 600; line-height: 1.5; overflow-wrap: anywhere; }
    .order-page .ord-small { margin-top: 2px; color: #6c757d; font-size: 11px; line-height: 1.5; overflow-wrap: anywhere; }

    .order-page table.order-table { width: 100% !important; margin: 0 !important; border-collapse: collapse; border: 1px solid #dee2e6; background: #fff; }
    .order-page table.order-table thead th,
    .order-page table.order-table tfoot th { padding: 14px 12px; color: #212529; background: #fff; border: 1px solid #dee2e6; font-size: 14px; font-weight: 700; text-align: left; white-space: nowrap; }
    .order-page table.order-table thead th { border-bottom: 2px solid #dee2e6; }
    .order-page table.order-table tfoot th { border-top: 2px solid #dee2e6; }
    .order-page table.order-table tbody td { padding: 12px; color: #212529; border: 1px solid #dee2e6; font-size: 14px; vertical-align: middle; white-space: nowrap; }
    .order-page table.order-table tbody td.col-wrap { white-space: normal; }
    .order-page table.order-table .col-pemesan { min-width: 200px; }
    .order-page table.order-table .col-keluhan { min-width: 240px; }
    .order-page table.order-table .col-servis { min-width: 170px; }
    .order-page table.order-table tbody tr:hover { background: #f1f1f1; }
    .order-page table.dataTable.no-footer { border-bottom: 1px solid #dee2e6; }

    /* ===== DATATABLES ===== */
    .order-page .dataTables_wrapper { font-size: 14px; color: #212529; }
    .order-page .ord-dt-top,
    .order-page .ord-dt-bottom { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; }
    .order-page .ord-dt-top { margin-bottom: 14px; }
    .order-page .ord-dt-bottom { margin-top: 14px; }
    .order-page .dt-buttons { display: flex; flex-wrap: wrap; float: none; margin: 0; }
    .order-page .dt-button { margin: 0 !important; padding: 8px 12px !important; color: #fff !important; background: #6c757d !important; background-image: none !important; border: none !important; border-radius: 0 !important; font-size: 14px !important; box-shadow: none !important; }
    .order-page .dt-button:first-child { border-radius: 4px 0 0 4px !important; }
    .order-page .dt-button:last-child { border-radius: 0 4px 4px 0 !important; }
    .order-page .dt-button:only-child { border-radius: 4px !important; }
    .order-page .dt-button:hover { background: #5a6268 !important; background-image: none !important; }
    .order-page .dataTables_filter,
    .order-page .dataTables_length { float: none; margin: 0; }
    .order-page .dataTables_filter input { margin-left: 6px; width: 180px; padding: 6px 10px; color: #495057; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; outline: none; }
    .order-page .dataTables_filter input:focus { border-color: #80bdff; box-shadow: 0 0 0 3px rgba(0,123,255,.2); }
    .order-page .dataTables_info { float: none; padding: 0; color: #212529; }
    .order-page .dataTables_paginate { float: none; padding: 0; }
    .order-page .dataTables_paginate .paginate_button { padding: 6px 12px !important; margin: 0 0 0 -1px !important; color: #6c757d !important; background: #fff !important; background-image: none !important; border: 1px solid #dee2e6 !important; border-radius: 0 !important; box-shadow: none !important; }
    .order-page .dataTables_paginate .paginate_button:first-child { border-radius: 4px 0 0 4px !important; }
    .order-page .dataTables_paginate .paginate_button:last-child { border-radius: 0 4px 4px 0 !important; }
    .order-page .dataTables_paginate .paginate_button.current { color: #fff !important; background: #007bff !important; border-color: #007bff !important; }
    .order-page .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) { color: #0056b3 !important; background: #e9ecef !important; }
    .order-page .dataTables_paginate .paginate_button.disabled { color: #adb5bd !important; cursor: default; }
    div.dt-button-background { background: transparent !important; }
    div.dt-button-collection { padding: 6px 0; border: 1px solid #dee2e6; border-radius: 4px; box-shadow: 0 6px 18px rgba(0,0,0,.15); }
    div.dt-button-collection .dt-button { display: block; width: 100%; color: #212529 !important; background: #fff !important; border: none !important; border-radius: 0 !important; text-align: left; }
    div.dt-button-collection .dt-button.active,
    div.dt-button-collection .dt-button.dt-button-active { color: #fff !important; background: #007bff !important; }

    /* ===== STATUS & TOMBOL ===== */
    .order-page .status { display: inline-flex; align-items: center; justify-content: center; padding: 5px 9px; border: 1px solid transparent; border-radius: 4px; font-size: 11px; font-weight: 700; line-height: 1.5; white-space: nowrap; }
    .order-page .status.waiting  { color: #856404; background: #fff3cd; border-color: #ffeeba; }
    .order-page .status.process  { color: #0c5460; background: #d1ecf1; border-color: #bee5eb; }
    .order-page .status.done     { color: #155724; background: #d4edda; border-color: #c3e6cb; }
    .order-page .status.rejected { color: #721c24; background: #f8d7da; border-color: #f5c6cb; }

    .order-page .detail-btn { min-height: 30px; padding: 4px 10px; color: #fff; background: #17a2b8; border: 1px solid #17a2b8; border-radius: 4px; font-family: inherit; font-size: 12px; font-weight: 600; white-space: nowrap; cursor: pointer; transition: filter .15s ease; }
    .order-page .detail-btn:hover { filter: brightness(.92); }

    /* ===== KARTU MOBILE ===== */
    .order-page .ord-mobile { display: none; padding: 14px; }
    .order-page .ord-card { padding: 15px; margin-bottom: 12px; background: #fff; border: 1px solid #ced4da; border-left: 3px solid #007bff; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
    .order-page .ord-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; padding-bottom: 12px; border-bottom: 1px solid #ced4da; }
    .order-page .ord-card-grid { display: block; margin-top: 2px; }
    .order-page .ord-card-grid > div { display: flex; justify-content: space-between; align-items: flex-start; gap: 14px; padding: 10px 0; border-bottom: 1px solid #e9ecef; }
    .order-page .ord-card-grid > div:last-child { border-bottom: none; }
    .order-page .ord-card-label { flex: 0 0 auto; color: #6c757d; font-size: 12px; line-height: 1.6; }
    .order-page .ord-card-value { min-width: 0; margin-top: 0; color: #212529; font-size: 13px; font-weight: 600; line-height: 1.6; text-align: right; overflow-wrap: anywhere; }
    .order-page .ord-card-actions { margin-top: 4px; padding-top: 14px; border-top: 1px solid #ced4da; }
    .order-page .ord-card-actions .detail-btn { width: 100%; min-height: 40px; font-size: 13px; }
    .order-page .ord-m-search { width: 100%; margin-bottom: 12px; padding: 10px 12px; color: #495057; background: #fff; border: 1px solid #ced4da; border-radius: 4px; font-family: inherit; font-size: 16px; outline: none; }
    .order-page .ord-m-search:focus { border-color: #80bdff; box-shadow: 0 0 0 3px rgba(0,123,255,.2); }
    .order-page .ord-m-more { display: none; width: 100%; min-height: 44px; margin-top: 12px; color: #fff; background: #007bff; border: 1px solid #007bff; border-radius: 4px; font-family: inherit; font-size: 14px; font-weight: 600; cursor: pointer; }
    .order-page .ord-m-empty { display: none; padding: 22px 10px; color: #6c757d; font-size: 13px; text-align: center; }

    /* ===== MODAL DETAIL ===== */
    .order-page .modal { display: none; position: fixed; inset: 0; z-index: 2000; align-items: center; justify-content: center; padding: 18px; background: rgba(0,0,0,.55); }
    .order-page .modal.show { display: flex; }
    .order-page .modal-box { width: 100%; max-width: 640px; max-height: 90vh; max-height: 90dvh; overflow-y: auto; overscroll-behavior: contain; background: #fff; border-radius: 6px; box-shadow: 0 10px 40px rgba(0,0,0,.25); }
    .order-page .modal-header { position: sticky; top: 0; z-index: 1; display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: #fff; border-bottom: 1px solid #e9ecef; }
    .order-page .modal-header h3 { margin: 0; color: #212529; font-size: 16px; font-weight: 600; }
    .order-page .close-modal { width: 32px; height: 32px; color: #495057; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; cursor: pointer; }
    .order-page .close-modal:hover { background: #e9ecef; }
    .order-page .modal-content { padding: 20px; }
    .order-page .detail-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
    .order-page .detail-item { padding: 12px 14px; overflow-wrap: anywhere; background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; }
    .order-page .detail-item.full { grid-column: 1 / -1; }
    .order-page .detail-item small { display: block; margin-bottom: 5px; color: #6c757d; font-size: 10px; font-weight: 700; text-transform: uppercase; }
    .order-page .detail-item strong { color: #212529; font-size: 13px; line-height: 1.6; white-space: pre-line; }

    @media (max-width: 800px) {
        .order-page .table-wrapper { display: none; }
        .order-page .ord-mobile { display: block; }
    }

    @media (max-width: 650px) {
        .page-heading { align-items: stretch; }
        .order-page .panel-header { padding: 12px 14px; }
        .order-page .panel-tools { width: 100%; }
        .order-page .panel-tag { display: none; }
        .order-page .filter-select { width: 100%; font-size: 16px; min-height: 42px; }
        .order-page .ord-mobile { padding: 10px; }
    .order-page .ord-card { padding: 13px; }
        .order-page .modal { padding: 10px; align-items: flex-end; }
        .order-page .modal-box { max-height: 92vh; max-height: 92dvh; }
        .order-page .modal-header { padding: 12px 14px; }
        .order-page .modal-content { padding: 14px; }
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
</section>

<div class="order-page">
    <section class="panel">
        <div class="panel-header">
            <div class="panel-header-top">
                <div>
                    <div class="panel-title">Daftar Pesanan Servis Masuk</div>
                    <div class="panel-subtitle">Lihat detail pesanan, tanggal booking, dan status pelanggan.</div>
                </div>

                <div class="panel-tools">
                    <select id="filterStatus" class="filter-select" aria-label="Filter status booking">
                        <option value="">Semua Status</option>
                        <option value="^(menunggu|pending|disetujui|diterima|proses|diproses|sedang dikerjakan|dikerjakan)$" selected>Belum selesai</option>
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
                    <tfoot>
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
                    </tfoot>
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
// Tabel desktop: Copy, PDF, Column visibility, cari, urutkan, pagination
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
        var exportCols = { columns: ':visible:not(:last-child)' };

        var table = jQuery('#tabelPesanan').DataTable({
            dom: "<'ord-dt-top'<'ord-dt-btns'B><'ord-dt-search'f>>rt<'ord-dt-bottom'<'ord-dt-info'i><'ord-dt-page'p>>",
            stateSave: false,
            pageLength: 5,
            order: [],                       // urutan awal = pesanan terbaru dari server
            autoWidth: false,
            stateLoadParams: function (settings, data) {
                // filter status tidak diingat agar dropdown selalu sinkron
                (data.columns || []).forEach(function (c) { c.search.search = ''; });
            },
            buttons: [
                { extend: 'copy', text: 'Copy', exportOptions: exportCols },
                { extend: 'pdf',  text: 'PDF',  title: 'Daftar Pesanan Servis', orientation: 'landscape', pageSize: 'A4', exportOptions: exportCols },
                { extend: 'colvis', text: 'Column visibility', background: false, columns: ':not(:last-child)' }
            ],
            columnDefs: [
                { targets: [2, 9], visible: false },     // No. HP dan Keluhan disembunyikan awalnya
                { targets: 0, width: '40px' },
                { targets: -1, orderable: false, searchable: false }
            ],
            language: {
                search: 'Search:',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                infoEmpty: 'Belum ada data',
                infoFiltered: '(dari total _MAX_ data)',
                zeroRecords: 'Pesanan tidak ditemukan',
                paginate: { previous: 'Previous', next: 'Next' },
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
            'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js',
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
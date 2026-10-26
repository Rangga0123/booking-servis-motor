@extends('layouts.customer')

@section('title', 'Riwayat Booking - Bengkel Royal Motor')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
.rb-page,.rb-page *{box-sizing:border-box}
.rb-page{width:100%;max-width:1450px;margin:0 auto;padding:0 0 30px;color:#14213d}
.rb-head{display:flex;align-items:center;justify-content:space-between;gap:22px;margin-bottom:25px;padding:23px 25px;background:linear-gradient(120deg,#fff,#f7faff);border:1px solid #dce5f1;border-left:4px solid #3264d8;border-radius:14px;box-shadow:0 4px 14px rgba(39,61,99,.04)}
.rb-head-text{min-width:0}
.rb-crumb{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;color:#7182a3;font-size:12px}
.rb-crumb span:last-child{color:#3264d8;font-weight:700}
.rb-heading-label{display:inline-flex;align-items:center;gap:7px;margin-bottom:8px;color:#3264d8;font-size:11px;font-weight:800;letter-spacing:1px;text-transform:uppercase}
.rb-heading-label:before{content:"";width:7px;height:7px;border-radius:50%;background:#3264d8}
.rb-title{margin:0;color:#14213d;font-size:27px;font-weight:800;line-height:1.35}
.rb-desc{max-width:650px;margin:8px 0 0;color:#7182a3;font-size:13px;line-height:1.8}
.rb-btn{display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:43px;padding:11px 16px;border:1px solid transparent;border-radius:9px;font-size:12px;font-weight:750;text-decoration:none;cursor:pointer;transition:.2s}
.rb-btn:hover{transform:translateY(-2px)}
.rb-btn-primary{flex-shrink:0;color:#fff;background:#3264d8;box-shadow:0 5px 13px rgba(50,100,216,.18)}
.rb-btn-primary:hover{color:#fff;background:#244fb5}
.rb-alert{padding:14px 16px;margin-bottom:18px;border-radius:10px;font-size:13px;line-height:1.7;overflow-wrap:anywhere}
.rb-alert.success{color:#137849;background:#e8f8ef;border:1px solid #bcebd0}
.rb-alert.error{color:#bd263e;background:#fff0f2;border:1px solid #ffd1d8}
.rb-alert ul{margin:7px 0 0;padding-left:20px}
.rb-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:17px;margin-bottom:24px}
.rb-stat{position:relative;min-width:0;padding:21px;background:#fff;border:1px solid #dce5f1;border-top:3px solid #64748b;border-radius:13px;box-shadow:0 4px 13px rgba(39,61,99,.04);transition:.2s}
.rb-stat:nth-child(2){border-top-color:#3264d8}
.rb-stat:nth-child(3){border-top-color:#0f9660}
.rb-stat:hover{transform:translateY(-3px)}
.rb-stat-label{padding-right:48px;color:#60708a;font-size:12px;font-weight:700;line-height:1.6}
.rb-stat-number{margin-top:12px;color:#14213d;font-size:32px;font-weight:800;line-height:1.2}
.rb-stat-number.blue{color:#3264d8}
.rb-stat-number.green{color:#0f9660}
.rb-stat-desc{margin-top:8px;color:#8491a8;font-size:11px;line-height:1.7}
.rb-stat-icon{position:absolute;top:18px;right:18px;display:grid;place-items:center;width:39px;height:39px;border-radius:10px;background:#edf1f7;color:#52647b;font-size:19px;font-weight:800}
.rb-stat:nth-child(2) .rb-stat-icon{color:#3264d8;background:#e7efff}
.rb-stat:nth-child(3) .rb-stat-icon{color:#0f9660;background:#e1f8eb}
.rb-panel{min-width:0;overflow:hidden;background:#fff;border:1px solid #dce5f1;border-radius:13px;box-shadow:0 4px 15px rgba(39,61,99,.045)}
.rb-panel-head{display:flex;align-items:center;justify-content:space-between;gap:15px;padding:20px 22px;border-bottom:1px solid #e8edf5}
.rb-panel-title{margin:0;color:#14213d;font-size:17px;font-weight:800;line-height:1.5}
.rb-panel-sub{margin-top:5px;color:#7182a3;font-size:12px;line-height:1.7}
.rb-panel-tag{flex-shrink:0;padding:7px 10px;color:#3264d8;background:#edf3ff;border:1px solid #dce7ff;border-radius:7px;font-size:11px;font-weight:750}

/* ===== Tabel + DataTables ===== */
.rb-table-wrap{width:100%;padding:18px 22px 20px;overflow-x:auto}
.rb-table{width:100%!important;border-collapse:collapse;border-spacing:0;text-align:left;background:#fff}
.rb-table thead{background:#f5f8fd}
.rb-table th{padding:15px 14px;color:#60708a;background:#f5f8fd;border-bottom:1px solid #e2e9f3;font-size:11px;font-weight:800;letter-spacing:.35px;white-space:nowrap;text-transform:uppercase}
.rb-table td{padding:15px 14px;color:#52647b;border-bottom:1px solid #edf1f7;font-size:12px;line-height:1.7;vertical-align:middle}
.rb-table tbody tr:nth-child(even){background:#fbfcff}
.rb-table tbody tr:hover{background:#f2f6ff}
.rb-strong{color:#14213d;font-size:13px;font-weight:750;line-height:1.6;overflow-wrap:anywhere}
.rb-small{margin-top:4px;color:#8491a8;font-size:11px;line-height:1.6;overflow-wrap:anywhere}

.rb-table-wrap .dataTables_wrapper{font-size:12px;color:#52647b}
.rb-dt-top,.rb-dt-bottom{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px}
.rb-dt-top{margin-bottom:14px}
.rb-dt-bottom{margin-top:14px}
.rb-table-wrap .dt-buttons{display:flex;flex-wrap:wrap;gap:0;float:none;margin:0}
.rb-table-wrap .dt-button{margin:0!important;padding:8px 15px!important;color:#fff!important;background:#3b4752!important;background-image:none!important;border:1px solid #2f3a45!important;border-radius:0!important;font-size:12px!important;font-weight:700!important;box-shadow:none!important}
.rb-table-wrap .dt-button:first-child{border-radius:7px 0 0 7px!important}
.rb-table-wrap .dt-button:last-child{border-radius:0 7px 7px 0!important}
.rb-table-wrap .dt-button:only-child{border-radius:7px!important}
.rb-table-wrap .dt-button:hover{background:#2b343d!important;background-image:none!important}
.rb-table-wrap .dataTables_filter,.rb-table-wrap .dataTables_length{float:none;margin:0}
.rb-table-wrap .dataTables_filter input,.rb-table-wrap .dataTables_length select{padding:7px 10px;color:#14213d;border:1px solid #d3dcea;border-radius:7px;font-size:12px;outline:none}
.rb-table-wrap .dataTables_filter input:focus{border-color:#3264d8;box-shadow:0 0 0 3px rgba(50,100,216,.12)}
.rb-table-wrap .dataTables_info{float:none;padding:0;color:#7182a3}
.rb-table-wrap .dataTables_paginate{float:none;padding:0}
.rb-table-wrap .dataTables_paginate .paginate_button{padding:6px 12px!important;margin:0 0 0 -1px!important;color:#52647b!important;background:#fff!important;background-image:none!important;border:1px solid #d3dcea!important;border-radius:0!important;box-shadow:none!important}
.rb-table-wrap .dataTables_paginate .paginate_button:first-child{border-radius:7px 0 0 7px!important}
.rb-table-wrap .dataTables_paginate .paginate_button:last-child{border-radius:0 7px 7px 0!important}
.rb-table-wrap .dataTables_paginate .paginate_button.current{color:#fff!important;background:#3264d8!important;border-color:#3264d8!important}
.rb-table-wrap .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled){background:#eef3fc!important}
.rb-table-wrap .dataTables_paginate .paginate_button.disabled{color:#a7b2c4!important}
table.dataTable.rb-table thead th,table.dataTable.rb-table thead td{border-bottom:1px solid #e2e9f3}
table.dataTable.rb-table.no-footer{border-bottom:1px solid #e2e9f3}
/* Garis pemisah antar kolom */
table.dataTable.rb-table{border:1px solid #e2e9f3}
table.dataTable.rb-table thead th,table.dataTable.rb-table tbody td{border-right:1px solid #e2e9f3}
table.dataTable.rb-table thead th:last-child,table.dataTable.rb-table tbody td:last-child{border-right:none}
table.dataTable.rb-table tbody td{border-bottom:1px solid #e2e9f3}
div.dt-button-background{background:transparent!important}
div.dt-button-collection{padding:6px 0;border:1px solid #dce5f1;border-radius:8px;box-shadow:0 8px 24px rgba(39,61,99,.15)}
div.dt-button-collection .dt-button{display:block;width:100%;color:#14213d!important;background:#fff!important;border:none!important;border-radius:0!important;text-align:left}
div.dt-button-collection .dt-button.active,div.dt-button-collection .dt-button.dt-button-active{color:#fff!important;background:#3264d8!important}

.rb-status{display:inline-flex;align-items:center;justify-content:center;padding:6px 9px;border:1px solid transparent;border-radius:7px;font-size:10px;font-weight:800;line-height:1.5;white-space:nowrap}
.rb-status.selesai{color:#087647;background:#e1f8eb;border-color:#bcebd0}
.rb-status.proses{color:#2457bd;background:#e7efff;border-color:#cbdcff}
.rb-status.ditolak{color:#bb2942;background:#ffedf0;border-color:#ffd0d8}
.rb-status.menunggu{color:#956000;background:#fff5dc;border-color:#ffe3a0}
.rb-actions{display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:6px}
.rb-actions form{display:inline-flex;margin:0}
.rb-link{display:inline-flex;align-items:center;justify-content:center;min-height:32px;padding:7px 10px;border:1px solid transparent;border-radius:7px;font-family:inherit;font-size:10px;font-weight:800;line-height:1.4;text-decoration:none;white-space:nowrap;cursor:pointer;transition:.2s}
.rb-link:hover{transform:translateY(-1px)}
.rb-link.detail{color:#1854b4;background:#eaf2ff;border-color:#d2e2ff}
.rb-link.edit{color:#8a5800;background:#fff4d9;border-color:#ffe3a0}
.rb-link.cancel{color:#bd2942;background:#fff0f2;border-color:#ffd1d8}
.rb-empty{padding:48px 20px;text-align:center}
.rb-empty-icon{display:grid;place-items:center;width:55px;height:55px;margin:0 auto 16px;color:#3264d8;background:#edf3ff;border:1px solid #dce7ff;border-radius:15px;font-size:25px}
.rb-empty h3{margin:0;color:#14213d;font-size:17px;font-weight:800}
.rb-empty p{max-width:420px;margin:9px auto 19px;color:#7182a3;font-size:13px;line-height:1.8}
.rb-mobile{display:none;padding:14px}
.rb-card{padding:15px;margin-bottom:12px;background:#fff;border:1px solid #dce5f1;border-left:3px solid #3264d8;border-radius:11px;box-shadow:0 3px 10px rgba(39,61,99,.035)}
.rb-card:last-child{margin-bottom:0}
.rb-card-top{display:flex;align-items:flex-start;justify-content:space-between;gap:10px}
.rb-card-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:13px;margin-top:14px;padding-top:14px;border-top:1px solid #e8edf5}
.rb-card-grid .full{grid-column:1/-1}
.rb-card-label{color:#8491a8;font-size:11px;line-height:1.5}
.rb-card-value{margin-top:5px;color:#263752;font-size:12px;font-weight:700;line-height:1.7;overflow-wrap:anywhere}
.rb-card .rb-actions{justify-content:flex-start;margin-top:14px;padding-top:13px;border-top:1px solid #e8edf5}
.rb-m-search{width:100%;margin-bottom:12px;padding:11px 13px;color:#14213d;background:#fff;border:1px solid #d3dcea;border-radius:9px;font-family:inherit;font-size:16px;outline:none}
.rb-m-search:focus{border-color:#3264d8;box-shadow:0 0 0 3px rgba(50,100,216,.12)}
.rb-m-more{display:none;width:100%;min-height:44px;margin-top:12px;color:#3264d8;background:#edf3ff;border:1px solid #dce7ff;border-radius:9px;font-family:inherit;font-size:13px;font-weight:750;cursor:pointer}
.rb-m-empty{display:none;padding:22px 10px;color:#7182a3;font-size:13px;text-align:center}
.rb-foot{margin-top:20px;color:#94a0b2;font-size:11px;line-height:1.7;text-align:center}
@media(max-width:1050px){.rb-page{max-width:100%}.rb-stats{gap:12px}.rb-stat{padding:18px}}
@media(max-width:800px){.rb-head{align-items:flex-start;padding:19px}.rb-title{font-size:24px}.rb-stats{grid-template-columns:1fr;gap:12px}.rb-stat-number{font-size:28px}.rb-table-wrap{display:none}.rb-mobile{display:block}.rb-panel-head{padding:17px}}
@media(max-width:560px){.rb-page{padding-bottom:22px}.rb-head{display:block;margin-bottom:19px;padding:17px}.rb-title{font-size:22px}.rb-desc{font-size:12px}.rb-head .rb-btn{width:100%;margin-top:16px}.rb-panel-head{align-items:flex-start;padding:15px}.rb-panel-title{font-size:15px}.rb-panel-sub{font-size:11px}.rb-panel-tag{display:none}.rb-mobile{padding:10px}.rb-card{padding:13px}.rb-card .rb-actions{gap:7px}.rb-link{min-height:34px;padding:8px 10px}.rb-empty{padding:35px 17px}}
@media(max-width:360px){.rb-title{font-size:20px}.rb-card-grid{gap:10px}.rb-card-top{flex-direction:column}}
@media(prefers-reduced-motion:reduce){.rb-stat,.rb-btn,.rb-link{transition:none}}
</style>
@endpush

@section('content')
<div class="rb-page">

    @php
        $bookings = $bookings ?? collect();

        $totalBooking = $bookings->count();

        $totalProses = $bookings->filter(function ($booking) {
            return in_array(strtolower($booking->status ?? ''), [
                'proses', 'diproses', 'sedang dikerjakan',
                'dikerjakan', 'disetujui', 'diterima',
            ]);
        })->count();

        $totalSelesai = $bookings->filter(function ($booking) {
            return strtolower($booking->status ?? '') === 'selesai';
        })->count();

        $dataRiwayat = $bookings->map(function ($booking) {
            $status = strtolower($booking->status ?? 'menunggu');

            $statusClass = match ($status) {
                'selesai' => 'selesai',
                'ditolak', 'dibatalkan' => 'ditolak',
                'proses', 'diproses', 'sedang dikerjakan',
                'dikerjakan', 'disetujui', 'diterima' => 'proses',
                default => 'menunggu',
            };

            $tanggalRaw = $booking->tanggal_booking
                ? \Illuminate\Support\Carbon::parse($booking->tanggal_booking)
                : null;

            $tanggal = $tanggalRaw ? $tanggalRaw->format('d M Y') : '-';
            $tanggalSort = $tanggalRaw ? $tanggalRaw->format('Y-m-d') : '';

            $jam = $booking->jam_booking
                ? substr((string) $booking->jam_booking, 0, 5)
                : '-';

            $metode = $booking->metode_pembayaran ?? '-';

            if (in_array(strtolower($metode), [
                'tunai',
                'tunai / bayar di kasir',
                'tunai (bayar di kasir)',
            ])) {
                $metode = 'Tunai (bayar di kasir)';
            }

            return [
                'booking' => $booking,
                'statusClass' => $statusClass,
                'bisaUbah' => in_array($status, ['menunggu', 'pending']),
                'pemesan' => $booking->nama_pelanggan
                    ?? $booking->user?->name
                    ?? '-',
                'hp' => $booking->no_hp ?: '-',
                'motor' => $booking->nama_motor ?: '-',
                'plat' => $booking->plat_nomor ?: '-',
                'tanggal' => $tanggal,
                'tanggalSort' => $tanggalSort . ' ' . $jam,
                'jam' => $jam,
                'servis' => $booking->service?->nama_servis
                    ?? $booking->jenis_servis
                    ?? '-',
                'mekanik' => $booking->mechanic?->nama_mekanik
                    ?? 'Ditentukan admin',
                'hargaBarang' => (float) ($booking->harga_barang ?? 0),
                'biayaJasa' => (float) ($booking->biaya_jasa ?? 0),
                'totalHarga' => (float) ($booking->harga ?? 0),
                'metode' => $metode,
            ];
        });
    @endphp

    <section class="rb-head">
        <div class="rb-head-text">
            <div class="rb-crumb">
                <span>Pelanggan</span>
                <span aria-hidden="true">/</span>
                <span>Riwayat Booking</span>
            </div>
            <div class="rb-heading-label">Area Pelanggan</div>
            <h1 class="rb-title">Riwayat Booking</h1>
            <p class="rb-desc">
                Pantau data pemesan, kendaraan, jadwal servis, biaya,
                pembayaran, dan status booking di Bengkel Royal Motor.
            </p>
        </div>

        <a href="{{ route('booking.create') }}" class="rb-btn rb-btn-primary">
            <span aria-hidden="true">＋</span> Booking Baru
        </a>
    </section>

    @if (session('success'))
        <div class="rb-alert success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="rb-alert error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="rb-alert error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="rb-stats">
        <article class="rb-stat">
            <div class="rb-stat-icon" aria-hidden="true">#</div>
            <div class="rb-stat-label">Total Booking</div>
            <div class="rb-stat-number">{{ $totalBooking }}</div>
            <div class="rb-stat-desc">Semua pesanan milik kamu</div>
        </article>

        <article class="rb-stat">
            <div class="rb-stat-icon" aria-hidden="true">↻</div>
            <div class="rb-stat-label">Sedang Diproses</div>
            <div class="rb-stat-number blue">{{ $totalProses }}</div>
            <div class="rb-stat-desc">Pesanan yang sedang ditangani</div>
        </article>

        <article class="rb-stat">
            <div class="rb-stat-icon" aria-hidden="true">✓</div>
            <div class="rb-stat-label">Servis Selesai</div>
            <div class="rb-stat-number green">{{ $totalSelesai }}</div>
            <div class="rb-stat-desc">Pesanan yang telah selesai</div>
        </article>
    </section>

    <section class="rb-panel">
        <div class="rb-panel-head">
            <div>
                <h2 class="rb-panel-title">Riwayat Booking Saya</h2>
                <div class="rb-panel-sub">
                    Informasi booking sesuai data yang disimpan.
                </div>
            </div>
            <span class="rb-panel-tag">{{ $totalBooking }} Pesanan</span>
        </div>

        @if ($dataRiwayat->isEmpty())
            <div class="rb-empty">
                <div class="rb-empty-icon" aria-hidden="true">▤</div>
                <h3>Belum Ada Booking</h3>
                <p>
                    Kamu belum memiliki riwayat booking servis.
                    Buat booking baru untuk memilih jadwal servis motor.
                </p>
                <a href="{{ route('booking.create') }}" class="rb-btn rb-btn-primary">
                    <span aria-hidden="true">＋</span> Booking Sekarang
                </a>
            </div>
        @else

            {{-- TABEL DESKTOP (DataTables) --}}
            <div class="rb-table-wrap">
                <table id="tabelRiwayat" class="rb-table display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemesan</th>
                            <th>No. HP</th>
                            <th>Kendaraan</th>
                            <th>Jadwal</th>
                            <th>Layanan Servis</th>
                            <th>Mekanik</th>
                            <th>Rincian Biaya</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataRiwayat as $item)
                            @php $booking = $item['booking']; @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><div class="rb-strong">{{ $item['pemesan'] }}</div></td>
                                <td>{{ $item['hp'] }}</td>
                                <td>
                                    <div class="rb-strong">{{ $item['motor'] }}</div>
                                    <div class="rb-small">{{ $item['plat'] }}</div>
                                </td>
                                <td data-order="{{ $item['tanggalSort'] }}">
                                    <div class="rb-strong">{{ $item['tanggal'] }}</div>
                                    <div class="rb-small">
                                        {{ $item['jam'] !== '-' ? $item['jam'] . ' WIB' : '-' }}
                                    </div>
                                </td>
                                <td><div class="rb-strong">{{ $item['servis'] }}</div></td>
                                <td>{{ $item['mekanik'] }}</td>
                                <td data-order="{{ $item['totalHarga'] }}">
                                    <div class="rb-small" style="margin-top:0">
                                        Barang: Rp{{ number_format($item['hargaBarang'], 0, ',', '.') }}
                                    </div>
                                    <div class="rb-small">
                                        Jasa: Rp{{ number_format($item['biayaJasa'], 0, ',', '.') }}
                                    </div>
                                    <div class="rb-strong">
                                        Total: Rp{{ number_format($item['totalHarga'], 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>{{ $item['metode'] }}</td>
                                <td>
                                    <span class="rb-status {{ $item['statusClass'] }}">
                                        {{ ucfirst($booking->status ?? 'Menunggu') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="rb-actions">
                                        <a href="{{ route('booking.show', $booking->id) }}"
                                           class="rb-link detail">Detail</a>

                                        @if ($item['bisaUbah'])
                                            <a href="{{ route('booking.edit', $booking->id) }}"
                                               class="rb-link edit">Edit</a>

                                            <form action="{{ route('booking.cancel', $booking->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rb-link cancel">Batalkan</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- KARTU MOBILE --}}
            <div class="rb-mobile">
                <input type="search" id="rbMobileSearch" class="rb-m-search"
                       placeholder="Cari pemesan / motor / plat / layanan / status" autocomplete="off">

                @foreach ($dataRiwayat as $item)
                    @php $booking = $item['booking']; @endphp

                    <article class="rb-card"
                             data-search="{{ strtolower($item['pemesan'].' '.$item['motor'].' '.$item['plat'].' '.$item['servis'].' '.$item['mekanik'].' '.($booking->status ?? 'menunggu').' '.$item['tanggal']) }}">
                        <div class="rb-card-top">
                            <div>
                                <div class="rb-strong">{{ $item['pemesan'] }}</div>
                                <div class="rb-small">{{ $item['hp'] }}</div>
                            </div>
                            <span class="rb-status {{ $item['statusClass'] }}">
                                {{ ucfirst($booking->status ?? 'Menunggu') }}
                            </span>
                        </div>

                        <div class="rb-card-grid">
                            <div>
                                <div class="rb-card-label">Motor</div>
                                <div class="rb-card-value">{{ $item['motor'] }}</div>
                            </div>
                            <div>
                                <div class="rb-card-label">Nomor Polisi</div>
                                <div class="rb-card-value">{{ $item['plat'] }}</div>
                            </div>
                            <div>
                                <div class="rb-card-label">Jadwal</div>
                                <div class="rb-card-value">
                                    {{ $item['tanggal'] }}<br>
                                    {{ $item['jam'] !== '-' ? $item['jam'] . ' WIB' : '-' }}
                                </div>
                            </div>
                            <div>
                                <div class="rb-card-label">Layanan Servis</div>
                                <div class="rb-card-value">{{ $item['servis'] }}</div>
                            </div>
                            <div class="full">
                                <div class="rb-card-label">Mekanik</div>
                                <div class="rb-card-value">{{ $item['mekanik'] }}</div>
                            </div>
                            <div>
                                <div class="rb-card-label">Harga Barang</div>
                                <div class="rb-card-value">
                                    Rp{{ number_format($item['hargaBarang'], 0, ',', '.') }}
                                </div>
                            </div>
                            <div>
                                <div class="rb-card-label">Biaya Jasa</div>
                                <div class="rb-card-value">
                                    Rp{{ number_format($item['biayaJasa'], 0, ',', '.') }}
                                </div>
                            </div>
                            <div>
                                <div class="rb-card-label">Total Biaya</div>
                                <div class="rb-card-value">
                                    Rp{{ number_format($item['totalHarga'], 0, ',', '.') }}
                                </div>
                            </div>
                            <div>
                                <div class="rb-card-label">Pembayaran</div>
                                <div class="rb-card-value">{{ $item['metode'] }}</div>
                            </div>
                        </div>

                        <div class="rb-actions">
                            <a href="{{ route('booking.show', $booking->id) }}"
                               class="rb-link detail">Detail</a>

                            @if ($item['bisaUbah'])
                                <a href="{{ route('booking.edit', $booking->id) }}"
                                   class="rb-link edit">Edit</a>

                                <form action="{{ route('booking.cancel', $booking->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rb-link cancel">Batalkan</button>
                                </form>
                            @endif
                        </div>
                    </article>
                @endforeach

                <div class="rb-m-empty" id="rbMobileEmpty">Data tidak ditemukan</div>
                <button type="button" class="rb-m-more" id="rbMobileMore">Tampilkan lebih banyak</button>
            </div>
        @endif
    </section>

    <div class="rb-foot">
        Bengkel Royal Motor · Riwayat Booking Servis
    </div>
</div>
@endsection

@push('scripts')
@if (!$dataRiwayat->isEmpty())
<script>
// Daftar kartu di HP: pencarian + tampil 5 data dulu
(function () {
    var cards = Array.prototype.slice.call(document.querySelectorAll('.rb-mobile .rb-card'));
    if (!cards.length) return;
    var input = document.getElementById('rbMobileSearch');
    var more = document.getElementById('rbMobileMore');
    var empty = document.getElementById('rbMobileEmpty');
    var step = 5, limit = step;

    function render() {
        var q = (input.value || '').toLowerCase().trim();
        var matched = cards.filter(function (c) {
            return c.getAttribute('data-search').indexOf(q) !== -1;
        });
        cards.forEach(function (c) { c.style.display = 'none'; });
        matched.slice(0, limit).forEach(function (c) { c.style.display = ''; });
        more.style.display = matched.length > limit ? 'block' : 'none';
        empty.style.display = matched.length ? 'none' : 'block';
    }

    input.addEventListener('input', function () { limit = step; render(); });
    more.addEventListener('click', function () { limit += step; render(); });
    render();
})();
</script>

<script>
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

    function initTable() {
        jQuery('#tabelRiwayat').DataTable({
            dom: "<'rb-dt-top'<'rb-dt-btns'B><'rb-dt-search'f>>rt<'rb-dt-bottom'<'rb-dt-info'i><'rb-dt-page'p>>",
            stateSave: true,
            pageLength: 10,
            order: [[4, 'desc']],
            autoWidth: false,
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
                { targets: 2, visible: false },                 // No. HP disembunyikan awalnya
                { targets: 0, width: '40px' },
                { targets: -1, orderable: false, searchable: false }
            ],
            language: {
                search: 'Cari :',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(dari _MAX_ data)',
                zeroRecords: 'Data tidak ditemukan',
                paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                buttons: { copyTitle: 'Tersalin', copySuccess: { _: '%d baris tersalin' } }
            }
        });
    }

    function start() {
        var libs = [
            'https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js',
            'https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js'
        ];
        chain(libs, initTable);
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
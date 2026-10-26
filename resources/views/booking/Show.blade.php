@extends('layouts.customer')

@section('title', 'Detail Pesanan - Bengkel Royal Motor')

@push('styles')
<style>
.rd-page,.rd-page *{box-sizing:border-box}
.rd-page{width:100%;max-width:1200px;margin:0 auto;padding:0 0 30px;color:#14213d}
.rd-head{display:flex;align-items:center;justify-content:space-between;gap:22px;margin-bottom:22px;padding:23px 25px;background:linear-gradient(120deg,#fff,#f7faff);border:1px solid #dce5f1;border-left:4px solid #3264d8;border-radius:14px;box-shadow:0 4px 14px rgba(39,61,99,.04)}
.rd-crumb{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;color:#7182a3;font-size:12px}
.rd-crumb a{color:#7182a3;text-decoration:none}
.rd-crumb a:hover{color:#3264d8}
.rd-crumb span:last-child{color:#3264d8;font-weight:700}
.rd-title{margin:0;color:#14213d;font-size:27px;font-weight:800;line-height:1.35}
.rd-desc{margin:8px 0 0;color:#7182a3;font-size:13px;line-height:1.8}
.rd-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:43px;padding:11px 18px;border:1px solid #d3dcea;border-radius:9px;background:#fff;color:#52647b;font-family:inherit;font-size:12px;font-weight:750;text-decoration:none;cursor:pointer;transition:.2s}
.rd-btn:hover{transform:translateY(-2px);background:#f2f6ff}
.rd-btn-primary{color:#fff;background:#3264d8;border-color:#3264d8;box-shadow:0 5px 13px rgba(50,100,216,.18)}
.rd-btn-primary:hover{color:#fff;background:#244fb5}

.rd-alert{padding:14px 16px;margin-bottom:18px;border-radius:10px;font-size:13px;line-height:1.7}
.rd-reject{color:#bd263e;background:#fff0f2;border:1px solid #ffd1d8;border-left:4px solid #bd263e}
.rd-reject strong{display:block;margin-bottom:5px}
.rd-reject p{margin:0;color:#6b3a42;white-space:pre-line;overflow-wrap:anywhere}
.rd-reject small{display:block;margin-top:8px;color:#8a5a62}

.rd-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:17px;margin-bottom:22px}
.rd-stat{min-width:0;padding:19px 21px;background:#fff;border:1px solid #dce5f1;border-top:3px solid #3264d8;border-radius:13px;box-shadow:0 4px 13px rgba(39,61,99,.04)}
.rd-stat:nth-child(2){border-top-color:#64748b}
.rd-stat:nth-child(3){border-top-color:#0f9660}
.rd-stat-label{color:#60708a;font-size:12px;font-weight:700}
.rd-stat-value{margin-top:10px;color:#14213d;font-size:20px;font-weight:800;line-height:1.4;overflow-wrap:anywhere}
.rd-stat-value.green{color:#0f9660}
.rd-stat-sub{margin-top:4px;color:#8491a8;font-size:11px}

.rd-status{display:inline-flex;align-items:center;justify-content:center;padding:6px 11px;border:1px solid transparent;border-radius:7px;font-size:12px;font-weight:800;white-space:nowrap}
.rd-status.selesai{color:#087647;background:#e1f8eb;border-color:#bcebd0}
.rd-status.proses{color:#2457bd;background:#e7efff;border-color:#cbdcff}
.rd-status.ditolak{color:#bb2942;background:#ffedf0;border-color:#ffd0d8}
.rd-status.menunggu{color:#956000;background:#fff5dc;border-color:#ffe3a0}

.rd-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
.rd-card{min-width:0;overflow:hidden;background:#fff;border:1px solid #dce5f1;border-radius:13px;box-shadow:0 4px 15px rgba(39,61,99,.045)}
.rd-card.full{grid-column:1/-1}
.rd-card-head{padding:16px 22px;border-bottom:1px solid #e8edf5;background:#f5f8fd}
.rd-card-title{margin:0;color:#14213d;font-size:15px;font-weight:800;line-height:1.5}
.rd-card-sub{margin-top:2px;color:#7182a3;font-size:12px}
.rd-rows{margin:0;padding:0}
.rd-row{display:grid;grid-template-columns:160px minmax(0,1fr);gap:14px;padding:13px 22px;border-bottom:1px solid #edf1f7}
.rd-row:last-child{border-bottom:none}
.rd-row:nth-child(even){background:#fbfcff}
.rd-label{color:#7182a3;font-size:12px;line-height:1.7}
.rd-value{margin:0;color:#14213d;font-size:13px;font-weight:700;line-height:1.7;overflow-wrap:anywhere;white-space:pre-line}
.rd-value.muted{color:#8491a8;font-weight:400}
.rd-row.total{background:#edf3ff}
.rd-row.total .rd-label{color:#3264d8;font-weight:800}
.rd-row.total .rd-value{color:#3264d8;font-size:15px;font-weight:800}
.rd-note{margin:0;padding:18px 22px;color:#52647b;font-size:13px;line-height:1.8;overflow-wrap:anywhere;white-space:pre-line}

.rd-foot{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-top:22px;padding-top:18px;border-top:1px solid #e8edf5}
.rd-foot-note{color:#8491a8;font-size:12px}
.rd-actions{display:flex;flex-wrap:wrap;gap:9px}

@media(max-width:900px){.rd-stats{grid-template-columns:1fr;gap:12px}}
@media(max-width:760px){.rd-grid{grid-template-columns:1fr;gap:14px}.rd-card.full{grid-column:auto}.rd-title{font-size:24px}}
@media(max-width:560px){.rd-head{display:block;padding:17px}.rd-title{font-size:22px}.rd-head .rd-btn{width:100%;margin-top:16px}.rd-row{grid-template-columns:1fr;gap:2px;padding:12px 16px}.rd-card-head{padding:14px 16px}.rd-note{padding:16px}.rd-foot{flex-direction:column;align-items:stretch}.rd-actions{display:grid;grid-template-columns:1fr}}
@media(prefers-reduced-motion:reduce){.rd-btn{transition:none}}
</style>
@endpush

@section('content')
@php
    $jamTampil = $booking->jam_booking ? substr((string) $booking->jam_booking, 0, 5) : '-';

    $tanggalTampil = $booking->tanggal_booking
        ? \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('d M Y')
        : '-';

    $status = strtolower(trim($booking->status ?? 'menunggu'));

    // Label status sama persis dengan tabel riwayat
    $statusTampil = ucfirst($booking->status ?? 'Menunggu');

    $statusClass = match ($status) {
        'selesai' => 'selesai',
        'ditolak', 'dibatalkan', 'batal' => 'ditolak',
        'proses', 'diproses', 'sedang dikerjakan', 'dikerjakan', 'disetujui', 'diterima' => 'proses',
        default => 'menunggu',
    };

    $bisaDiubah = in_array($status, ['menunggu', 'pending'], true);

    $pemesan = $booking->nama_pelanggan ?? $booking->user?->name ?? '-';

    $servis = $booking->service?->nama_servis ?? $booking->jenis_servis ?? '-';

    $namaMekanik = $booking->mechanic?->nama_mekanik ?? 'Ditentukan admin';

    $metode = $booking->metode_pembayaran ?: '-';
    if (in_array(strtolower($metode), ['tunai', 'tunai / bayar di kasir', 'tunai (bayar di kasir)'])) {
        $metode = 'Tunai (bayar di kasir)';
    }

    $hargaBarang = (float) ($booking->harga_barang ?? 0);
    $biayaJasa   = (float) ($booking->biaya_jasa ?? 0);
    $totalHarga  = (float) ($booking->harga ?? 0);

    $rp = fn ($n) => 'Rp' . number_format($n, 0, ',', '.');
@endphp

<div class="rd-page">

    <section class="rd-head">
        <div>
            <div class="rd-crumb">
                <span>Pelanggan</span>
                <span aria-hidden="true">/</span>
                <a href="{{ route('booking.index') }}">Riwayat Booking</a>
                <span aria-hidden="true">/</span>
                <span>Detail</span>
            </div>
            <h1 class="rd-title">Detail Pesanan</h1>
            <p class="rd-desc">Informasi lengkap booking servis motor kamu.</p>
        </div>

        <a href="{{ route('booking.index') }}" class="rd-btn">← Kembali ke Riwayat</a>
    </section>

    @if ($status === 'ditolak')
        <div class="rd-alert rd-reject">
            <strong>Pesanan kamu ditolak</strong>
            <p>{{ $booking->alasan_penolakan ?: 'Admin tidak mencantumkan alasan penolakan.' }}</p>
            <small>Kamu bisa membuat booking baru dengan jadwal lain lewat menu Booking.</small>
        </div>
    @endif

    <section class="rd-stats">
        <article class="rd-stat">
            <div class="rd-stat-label">Status</div>
            <div class="rd-stat-value">
                <span class="rd-status {{ $statusClass }}">{{ $statusTampil }}</span>
            </div>
        </article>

        <article class="rd-stat">
            <div class="rd-stat-label">Jadwal</div>
            <div class="rd-stat-value">{{ $tanggalTampil }}</div>
            <div class="rd-stat-sub">{{ $jamTampil !== '-' ? $jamTampil . ' WIB' : '-' }}</div>
        </article>

        <article class="rd-stat">
            <div class="rd-stat-label">Total Biaya</div>
            <div class="rd-stat-value green">{{ $rp($totalHarga) }}</div>
            <div class="rd-stat-sub">{{ $metode }}</div>
        </article>
    </section>

    <div class="rd-grid">

        <section class="rd-card">
            <div class="rd-card-head">
                <h3 class="rd-card-title">Data Pemesan</h3>
                <div class="rd-card-sub">Informasi pemesan servis</div>
            </div>
            <dl class="rd-rows">
                <div class="rd-row">
                    <dt class="rd-label">Pemesan</dt>
                    <dd class="rd-value">{{ $pemesan }}</dd>
                </div>
                <div class="rd-row">
                    <dt class="rd-label">No. HP</dt>
                    <dd class="rd-value">{{ $booking->no_hp ?: '-' }}</dd>
                </div>
                <div class="rd-row">
                    <dt class="rd-label">Email</dt>
                    <dd class="rd-value {{ empty($booking->email_pelanggan) ? 'muted' : '' }}">
                        {{ $booking->email_pelanggan ?: 'Email tidak dicantumkan' }}
                    </dd>
                </div>
            </dl>
        </section>

        <section class="rd-card">
            <div class="rd-card-head">
                <h3 class="rd-card-title">Kendaraan</h3>
                <div class="rd-card-sub">Motor yang akan diservis</div>
            </div>
            <dl class="rd-rows">
                <div class="rd-row">
                    <dt class="rd-label">Nama / Tipe Motor</dt>
                    <dd class="rd-value">{{ $booking->nama_motor ?: '-' }}</dd>
                </div>
                <div class="rd-row">
                    <dt class="rd-label">Nomor Polisi</dt>
                    <dd class="rd-value">{{ $booking->plat_nomor ?: '-' }}</dd>
                </div>
            </dl>
        </section>

        <section class="rd-card">
            <div class="rd-card-head">
                <h3 class="rd-card-title">Layanan & Jadwal</h3>
                <div class="rd-card-sub">Jenis servis dan waktu booking</div>
            </div>
            <dl class="rd-rows">
                <div class="rd-row">
                    <dt class="rd-label">Layanan Servis</dt>
                    <dd class="rd-value">{{ $servis }}</dd>
                </div>
                <div class="rd-row">
                    <dt class="rd-label">Tanggal</dt>
                    <dd class="rd-value">{{ $tanggalTampil }}</dd>
                </div>
                <div class="rd-row">
                    <dt class="rd-label">Jam</dt>
                    <dd class="rd-value">{{ $jamTampil !== '-' ? $jamTampil . ' WIB' : '-' }}</dd>
                </div>
                <div class="rd-row">
                    <dt class="rd-label">Mekanik</dt>
                    <dd class="rd-value {{ $namaMekanik === 'Ditentukan admin' ? 'muted' : '' }}">{{ $namaMekanik }}</dd>
                </div>
            </dl>
        </section>

        <section class="rd-card">
            <div class="rd-card-head">
                <h3 class="rd-card-title">Rincian Biaya & Pembayaran</h3>
                <div class="rd-card-sub">Sesuai data pada tabel riwayat</div>
            </div>
            <dl class="rd-rows">
                <div class="rd-row">
                    <dt class="rd-label">Harga Barang</dt>
                    <dd class="rd-value">{{ $rp($hargaBarang) }}</dd>
                </div>
                <div class="rd-row">
                    <dt class="rd-label">Biaya Jasa</dt>
                    <dd class="rd-value">{{ $rp($biayaJasa) }}</dd>
                </div>
                <div class="rd-row total">
                    <dt class="rd-label">Total Biaya</dt>
                    <dd class="rd-value">{{ $rp($totalHarga) }}</dd>
                </div>
                <div class="rd-row">
                    <dt class="rd-label">Pembayaran</dt>
                    <dd class="rd-value">{{ $metode }}</dd>
                </div>
            </dl>
        </section>

        <section class="rd-card full">
            <div class="rd-card-head">
                <h3 class="rd-card-title">Keluhan / Catatan Servis</h3>
                <div class="rd-card-sub">Keluhan yang disampaikan saat booking</div>
            </div>
            <p class="rd-note">{{ $booking->keluhan ?: 'Tidak ada keluhan yang ditambahkan.' }}</p>
        </section>

    </div>

    <div class="rd-foot">
        <span class="rd-foot-note">Pastikan data booking kamu sudah sesuai.</span>

        <div class="rd-actions">
            <a href="{{ route('booking.index') }}" class="rd-btn">Kembali ke Riwayat</a>

            @if ($bisaDiubah)
                <a href="{{ route('booking.edit', $booking->id) }}" class="rd-btn rd-btn-primary">Edit Pesanan</a>
            @endif
        </div>
    </div>

</div>
@endsection
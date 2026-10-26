@extends('layouts.customer')

@section('title', 'Booking Servis - Bengkel Royal Motor')

@php
    $kategoriBayar = [
        'tunai' => [
            'label' => 'Tunai',
            'badge' => 'Rp',
            'warna' => '#19a875',
            'pilihan' => [],
        ],
        'ewallet' => [
            'label' => 'E-Wallet',
            'badge' => 'EW',
            'warna' => '#4c2a86',
            'pilihan' => ['OVO', 'GoPay', 'DANA', 'ShopeePay', 'LinkAja'],
        ],
        'qris' => [
            'label' => 'QRIS',
            'badge' => 'QR',
            'warna' => '#1f2937',
            'pilihan' => [],
        ],
        'bank' => [
            'label' => 'Transfer Bank',
            'badge' => 'TF',
            'warna' => '#0060af',
            'pilihan' => ['BCA', 'BRI', 'Mandiri', 'BNI'],
        ],
    ];

    $metodeLama = old('metode_pembayaran', 'Tunai / Bayar di Kasir');

    if ($metodeLama === 'QRIS') {
        $kategoriAktif = 'qris';
    } elseif (str_starts_with($metodeLama, 'Transfer ')) {
        $kategoriAktif = 'bank';
    } elseif (in_array($metodeLama, $kategoriBayar['ewallet']['pilihan'], true)) {
        $kategoriAktif = 'ewallet';
    } else {
        $kategoriAktif = 'tunai';
    }
@endphp

@section('content')
<div class="booking-page">

    {{-- HEADER HALAMAN --}}
    <header class="booking-header">
        <div class="booking-breadcrumb">
            <span>Pelanggan</span>
            <span aria-hidden="true">/</span>
            <strong>Booking Servis</strong>
        </div>

        <div class="booking-header-content">
            <div>
                <h1>Booking Servis Motor</h1>
                <p>Isi data kendaraan dan pilih jadwal sebelum datang ke bengkel.</p>
            </div>

            <a href="{{ route('booking.index') }}" class="booking-btn booking-btn-outline">
                <span aria-hidden="true">←</span>
                Riwayat Booking
            </a>
        </div>
    </header>

    {{-- PESAN VALIDASI --}}
    @if ($errors->any())
        <div class="booking-alert" role="alert">
            <strong>Ada data yang perlu diperbaiki.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm" class="booking-layout">
        @csrf

        <main class="booking-main">

            {{-- 01. DATA PELANGGAN --}}
            <section class="booking-card">
                <div class="booking-card-heading">
                    <span class="booking-step">01</span>
                    <div>
                        <h2>Data Pelanggan</h2>
                        <p>Masukkan data orang yang membawa motor untuk diservis.</p>
                    </div>
                </div>

                <div class="booking-fields">
                    <div class="booking-field">
                        <label for="nama_pelanggan">Nama Pemesan <span>*</span></label>
                        <input class="booking-input" type="text" id="nama_pelanggan"
                               name="nama_pelanggan"
                               value="{{ old('nama_pelanggan', Auth::user()->name) }}"
                               maxlength="255" autocomplete="name" required
                               placeholder="Masukkan nama lengkap">
                        @error('nama_pelanggan') <small class="booking-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="booking-field">
                        <label for="no_hp">No. HP / WhatsApp <span>*</span></label>
                        <input class="booking-input" type="tel" id="no_hp" name="no_hp"
                               value="{{ old('no_hp') }}" inputmode="tel" maxlength="20"
                               autocomplete="tel" required placeholder="Contoh: 081234567890">
                        @error('no_hp') <small class="booking-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="booking-field booking-field-full">
                        <label for="email_pelanggan">Email</label>
                        <input class="booking-input" type="email" id="email_pelanggan"
                               name="email_pelanggan"
                               value="{{ old('email_pelanggan', Auth::user()->email) }}"
                               maxlength="255" autocomplete="email" placeholder="nama@email.com">
                        @error('email_pelanggan') <small class="booking-error">{{ $message }}</small> @enderror
                    </div>
                </div>
            </section>

            {{-- 02. DATA KENDARAAN --}}
            <section class="booking-card">
                <div class="booking-card-heading">
                    <span class="booking-step">02</span>
                    <div>
                        <h2>Data Kendaraan</h2>
                        <p>Lengkapi identitas motor yang akan diservis.</p>
                    </div>
                </div>

                <div class="booking-fields">
                    <div class="booking-field">
                        <label for="nama_motor">Merek / Tipe Motor <span>*</span></label>
                        <input class="booking-input" type="text" id="nama_motor" name="nama_motor"
                               value="{{ old('nama_motor') }}" maxlength="255" required
                               placeholder="Contoh: Honda Vario 160">
                        @error('nama_motor') <small class="booking-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="booking-field">
                        <label for="plat_nomor">Nomor Polisi <span>*</span></label>
                        <input class="booking-input booking-uppercase" type="text" id="plat_nomor"
                               name="plat_nomor" value="{{ old('plat_nomor') }}"
                               maxlength="20" required placeholder="Contoh: B 1234 ABC">
                        @error('plat_nomor') <small class="booking-error">{{ $message }}</small> @enderror
                    </div>
                </div>
            </section>

            {{-- 03. LAYANAN DAN JADWAL --}}
            <section class="booking-card">
                <div class="booking-card-heading">
                    <span class="booking-step">03</span>
                    <div>
                        <h2>Layanan dan Jadwal</h2>
                        <p>Tentukan layanan, tanggal, dan waktu kedatangan.</p>
                    </div>
                </div>

                <div class="booking-fields">
                    <div class="booking-field booking-field-full">
                        <label for="service_id">Pilih Layanan Servis <span>*</span></label>
                        <select class="booking-input" id="service_id" name="service_id" required>
                            <option value="">-- Pilih layanan servis --</option>
                            @foreach (($services ?? collect()) as $service)
                                <option value="{{ $service->id }}"
                                        data-nama="{{ $service->nama_servis }}"
                                        data-barang="{{ $service->harga_barang ?? 0 }}"
                                        data-jasa="{{ $service->biaya_jasa ?? 0 }}"
                                        @selected((string) old('service_id') === (string) $service->id)>
                                    {{ $service->nama_servis }}
                                </option>
                            @endforeach
                        </select>

                        @if (($services ?? collect())->isEmpty())
                            <small class="booking-error">Belum ada layanan. Silakan hubungi admin bengkel.</small>
                        @endif
                        @error('service_id') <small class="booking-error">{{ $message }}</small> @enderror

                        <div class="booking-price-box">
                            <div class="booking-price-row">
                                <span>Harga barang / suku cadang</span>
                                <strong id="harga-barang">Rp0</strong>
                            </div>
                            <div class="booking-price-row">
                                <span>Biaya jasa servis</span>
                                <strong id="biaya-jasa">Rp0</strong>
                            </div>
                            <div class="booking-price-row booking-price-total">
                                <span>Total biaya servis</span>
                                <strong id="total-harga">Rp0</strong>
                            </div>
                        </div>
                        <small class="booking-hint">Harga mengikuti layanan yang dipilih. Total akhir dihitung kembali oleh sistem.</small>
                    </div>

                    <div class="booking-field">
                        <label for="tanggal_booking">Tanggal Servis <span>*</span></label>
                        <input class="booking-input" type="date" id="tanggal_booking"
                               name="tanggal_booking" value="{{ old('tanggal_booking') }}"
                               min="{{ date('Y-m-d') }}" required>
                        @error('tanggal_booking') <small class="booking-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="booking-field">
                        <label for="jam_booking">Jam Servis <span>*</span></label>
                        <input class="booking-input" type="time" id="jam_booking"
                               name="jam_booking" value="{{ old('jam_booking') }}" required>
                        <small class="booking-hint" id="ket_waktu"></small>
                        @error('jam_booking') <small class="booking-error">{{ $message }}</small> @enderror
                    </div>

                    <div class="booking-field booking-field-full">
                        <label for="keluhan">Keluhan / Catatan <span>*</span></label>
                        <textarea class="booking-input" id="keluhan" name="keluhan" rows="4"
                                  required placeholder="Ceritakan kendala motor, misalnya mesin kasar, rem berbunyi, atau susah distarter...">{{ old('keluhan') }}</textarea>
                        @error('keluhan') <small class="booking-error">{{ $message }}</small> @enderror
                    </div>
                </div>
            </section>

            {{-- 04. PILIH MEKANIK --}}
            <section class="booking-card">
                <div class="booking-card-heading">
                    <span class="booking-step">04</span>
                    <div>
                        <h2>Pilih Mekanik</h2>
                        <p>Pilih mekanik jika tersedia, atau biarkan admin yang menentukan.</p>
                    </div>
                </div>

                <div class="booking-mechanics">
                    <label class="booking-mechanic">
                        <input type="radio" name="mechanic_id" value=""
                               data-label="Ditentukan admin" @checked(!old('mechanic_id'))>
                        <span class="booking-mechanic-box">
                            <span class="booking-avatar booking-avatar-neutral">?</span>
                            <span class="booking-mechanic-info">
                                <strong>Bebas</strong>
                                <small>Ditentukan oleh admin</small>
                            </span>
                            <span class="booking-check" aria-hidden="true">✓</span>
                        </span>
                    </label>

                    @foreach (($mechanics ?? collect()) as $mekanik)
                        <label class="booking-mechanic">
                            <input type="radio" name="mechanic_id" value="{{ $mekanik->id }}"
                                   data-label="{{ $mekanik->nama_mekanik }}"
                                   @checked((string) old('mechanic_id') === (string) $mekanik->id)>
                            <span class="booking-mechanic-box">
                                <span class="booking-avatar">
                                    {{ strtoupper(substr($mekanik->nama_mekanik ?? 'M', 0, 1)) }}
                                </span>
                                <span class="booking-mechanic-info">
                                    <strong>{{ $mekanik->nama_mekanik }}</strong>
                                    <small>{{ $mekanik->spesialisasi ?: 'Mekanik Royal Motor' }}</small>
                                </span>
                                <span class="booking-check" aria-hidden="true">✓</span>
                            </span>
                        </label>
                    @endforeach
                </div>

                @if (($mechanics ?? collect())->isEmpty())
                    <div class="booking-info">Belum ada mekanik aktif. Mekanik akan ditentukan oleh admin.</div>
                @endif
                @error('mechanic_id') <small class="booking-error">{{ $message }}</small> @enderror
            </section>

            {{-- 05. METODE PEMBAYARAN --}}
            <section class="booking-card">
                <div class="booking-card-heading">
                    <span class="booking-step">05</span>
                    <div>
                        <h2>Metode Pembayaran</h2>
                        <p>Pilih metode pembayaran. Pembayaran dilakukan setelah servis.</p>
                    </div>
                </div>

                <input type="hidden" name="metode_pembayaran" id="metode_pembayaran"
                       value="{{ $metodeLama }}">

                <div class="booking-payment-categories">
                    @foreach ($kategoriBayar as $kode => $kategori)
                        @php
                            $nilaiLangsung = $kode === 'tunai'
                                ? 'Tunai / Bayar di Kasir'
                                : ($kode === 'qris' ? 'QRIS' : '');

                            $labelLangsung = $kode === 'tunai'
                                ? 'Tunai (bayar di kasir)'
                                : ($kode === 'qris' ? 'QRIS' : '');
                        @endphp

                        <button type="button"
                                class="booking-payment-category {{ $kode === $kategoriAktif ? 'is-active' : '' }}"
                                data-kat="{{ $kode }}"
                                data-nilai="{{ $nilaiLangsung }}"
                                data-label="{{ $labelLangsung }}"
                                aria-pressed="{{ $kode === $kategoriAktif ? 'true' : 'false' }}">
                            <span class="booking-payment-badge"
                                  style="background: {{ $kategori['warna'] }};">
                                {{ $kategori['badge'] }}
                            </span>
                            <span>{{ $kategori['label'] }}</span>
                            <span class="booking-payment-arrow" aria-hidden="true">›</span>
                        </button>
                    @endforeach
                </div>

                @foreach (['ewallet', 'bank'] as $kode)
                    <div class="booking-payment-options {{ $kode === $kategoriAktif ? '' : 'is-hidden' }}"
                         data-sub="{{ $kode }}">
                        <strong>
                            Pilih {{ $kode === 'ewallet' ? 'e-wallet' : 'bank tujuan' }}
                        </strong>
                        <div class="booking-payment-chips">
                            @foreach ($kategoriBayar[$kode]['pilihan'] as $pilihan)
                                @php
                                    $nilai = $kode === 'bank' ? 'Transfer ' . $pilihan : $pilihan;
                                @endphp
                                <button type="button"
                                        class="booking-payment-option {{ $metodeLama === $nilai ? 'is-active' : '' }}"
                                        data-nilai="{{ $nilai }}" data-label="{{ $nilai }}">
                                    {{ $pilihan }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <small class="booking-error is-hidden" id="errBayar" role="alert">
                    Pilih e-wallet atau bank terlebih dahulu.
                </small>
                @error('metode_pembayaran') <small class="booking-error">{{ $message }}</small> @enderror
            </section>

            {{-- TOMBOL AKSI --}}
            <div class="booking-actions">
                <a href="{{ route('booking.index') }}" class="booking-btn booking-btn-outline">Batal</a>
                <button type="submit" class="booking-btn booking-btn-primary" id="btnKirim">
                    Kirim Booking <span aria-hidden="true">→</span>
                </button>
            </div>
        </main>

        {{-- RINGKASAN BOOKING --}}
        <aside class="booking-sidebar">
            <section class="booking-summary">
                <div class="booking-summary-heading">
                    <div>
                        <span class="booking-summary-kicker">RINGKASAN</span>
                        <h2>Booking Kamu</h2>
                    </div>
                    <span class="booking-summary-icon" aria-hidden="true">✓</span>
                </div>

                <p class="booking-summary-description">Periksa kembali data sebelum mengirim booking.</p>

                <div class="booking-summary-section">
                    <h3 class="booking-summary-section-title">Informasi Booking</h3>
                    <dl class="booking-summary-list">
                        <div><dt>Pemesan</dt><dd id="sumNama">-</dd></div>
                        <div><dt>No. HP</dt><dd id="sumHp">-</dd></div>
                        <div><dt>Motor</dt><dd id="sumMotor">-</dd></div>
                        <div><dt>Nomor polisi</dt><dd id="sumPlat">-</dd></div>
                        <div><dt>Jadwal</dt><dd id="sumJadwal">-</dd></div>
                        <div><dt>Mekanik</dt><dd id="sumMekanik">Ditentukan admin</dd></div>
                    </dl>
                </div>

                <div class="booking-summary-section booking-summary-cost-section">
                    <h3 class="booking-summary-section-title">Layanan &amp; Biaya</h3>
                    <dl class="booking-summary-list booking-summary-cost-list">
                        <div><dt>Layanan servis</dt><dd id="sumServis">-</dd></div>
                        <div><dt>Harga barang</dt><dd id="sumHargaBarang">Rp0</dd></div>
                        <div><dt>Biaya jasa</dt><dd id="sumBiayaJasa">Rp0</dd></div>
                        <div class="booking-summary-total"><dt>Total biaya</dt><dd id="sumTotalHarga">Rp0</dd></div>
                    </dl>
                </div>

                <div class="booking-summary-section booking-summary-payment-section">
                    <h3 class="booking-summary-section-title">Pembayaran</h3>
                    <dl class="booking-summary-list">
                        <div><dt>Metode pembayaran</dt><dd id="sumBayar">-</dd></div>
                    </dl>
                </div>

                <div class="booking-summary-note">
                    <span aria-hidden="true">i</span>
                    <p>Booking akan diperiksa admin. Pantau statusnya melalui halaman riwayat booking.</p>
                </div>
            </section>
        </aside>
    </form>

    <p class="booking-footer">Royal Motor · Booking Servis Motor</p>
</div>
@endsection

@push('styles')
<style>
    .booking-page {
        --booking-blue: #3264d8;
        --booking-blue-dark: #244fae;
        --booking-text: #343a40;
        --booking-muted: #6c757d;
        --booking-line: #dfe3e8;
        --booking-line-dark: #cbd1d8;
        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
        color: var(--booking-text);
    }

    .booking-page,
    .booking-page * { box-sizing: border-box; }

    .booking-page button,
    .booking-page input,
    .booking-page textarea,
    .booking-page select { font: inherit; }

    .booking-header {
        margin-bottom: 24px;
        padding: 23px 25px;
        border: 1px solid #dce5f1;
        border-left: 4px solid var(--booking-blue);
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 3px 12px rgba(39, 61, 99, .035);
        animation: booking-enter .35s ease both;
    }

    .booking-breadcrumb {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 17px;
        color: #7182a3;
        font-size: 12px;
    }

    .booking-breadcrumb strong { color: var(--booking-blue); }

    .booking-header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .booking-header h1 {
        margin: 0;
        color: #14213d;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.35;
        letter-spacing: -.4px;
    }

    .booking-header p {
        margin: 8px 0 0;
        color: #7182a3;
        font-size: 13px;
        line-height: 1.8;
    }

    @keyframes booking-enter {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .booking-alert {
        margin-bottom: 20px;
        padding: 15px 18px;
        border: 1px solid #f0c2c7;
        border-left: 4px solid #dc3545;
        border-radius: 8px;
        background: #fff8f8;
        color: #842029;
        font-size: 13px;
        line-height: 1.8;
    }

    .booking-alert ul { margin: 6px 0 0; padding-left: 19px; }

    .booking-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        align-items: start;
        gap: 22px;
    }

    .booking-main { display: flex; flex-direction: column; gap: 18px; min-width: 0; }

    .booking-card {
        min-width: 0;
        padding: 22px;
        border: 1px solid var(--booking-line);
        border-radius: 9px;
        background: #fff;
        box-shadow: 0 2px 7px rgba(30, 41, 59, .025);
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .booking-card:hover {
        border-color: #cbd3dd;
        box-shadow: 0 4px 12px rgba(30, 41, 59, .035);
    }

    .booking-card-heading {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding-bottom: 17px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--booking-line);
    }

    .booking-step {
        display: grid;
        place-items: center;
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        border: 1px solid #d6e2ff;
        border-radius: 8px;
        background: #edf3ff;
        color: var(--booking-blue);
        font-size: 12px;
        font-weight: 800;
    }

    .booking-card-heading h2 {
        margin: 0;
        color: #343a40;
        font-size: 16px;
        line-height: 1.5;
        font-weight: 800;
    }

    .booking-card-heading p {
        margin: 4px 0 0;
        color: var(--booking-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    .booking-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 19px;
    }

    .booking-field { min-width: 0; }
    .booking-field-full { grid-column: 1 / -1; }

    .booking-field label {
        display: block;
        margin-bottom: 8px;
        color: #343a40;
        font-size: 13px;
        font-weight: 700;
    }

    .booking-field label span { color: #dc3545; }

    .booking-input {
        display: block;
        width: 100%;
        min-width: 0;
        min-height: 43px;
        padding: 11px 13px;
        border: 1px solid var(--booking-line-dark);
        border-radius: 7px;
        outline: none;
        background: #fff;
        color: #343a40;
        font-size: 13px;
        line-height: 1.6;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .booking-input:hover { border-color: #aeb8c4; }
    .booking-input:focus {
        border-color: var(--booking-blue);
        box-shadow: 0 0 0 3px rgba(50, 100, 216, .12);
    }
    .booking-input::placeholder { color: #9aa2ad; }
    textarea.booking-input { min-height: 115px; resize: vertical; }
    .booking-uppercase { text-transform: uppercase; }
    .booking-uppercase::placeholder { text-transform: none; }

    .booking-hint {
        display: block;
        margin-top: 7px;
        color: var(--booking-muted);
        font-size: 11px;
        line-height: 1.7;
    }

    .booking-error {
        display: block;
        margin-top: 7px;
        color: #c92a3b;
        font-size: 12px;
        line-height: 1.6;
    }

    .booking-price-box {
        margin-top: 15px;
        padding: 15px;
        border: 1px solid var(--booking-line);
        border-radius: 8px;
        background: #f8faff;
    }

    .booking-price-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 10px 0;
        color: #626b75;
        font-size: 12px;
        line-height: 1.6;
    }

    .booking-price-row strong { color: #343a40; text-align: right; overflow-wrap: anywhere; }
    .booking-price-total { margin-top: 5px; padding-top: 14px; border-top: 1px solid var(--booking-line); }
    .booking-price-total span,
    .booking-price-total strong { color: var(--booking-blue-dark); font-size: 14px; font-weight: 800; }

    .booking-mechanics {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 11px;
    }

    .booking-mechanic { position: relative; display: block; min-width: 0; cursor: pointer; }
    .booking-mechanic input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .booking-mechanic-box {
        display: flex;
        align-items: center;
        gap: 11px;
        min-height: 72px;
        padding: 12px;
        border: 1px solid var(--booking-line-dark);
        border-radius: 8px;
        background: #fff;
        transition: border-color .2s ease, background .2s ease;
    }

    .booking-mechanic input:checked + .booking-mechanic-box {
        border-color: var(--booking-blue);
        background: #f0f5ff;
    }

    .booking-mechanic input:focus-visible + .booking-mechanic-box {
        outline: 3px solid rgba(50, 100, 216, .16);
        outline-offset: 2px;
    }

    .booking-avatar {
        display: grid;
        place-items: center;
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        border: 1px solid #d6e2ff;
        border-radius: 50%;
        background: #edf3ff;
        color: #244fae;
        font-size: 15px;
        font-weight: 800;
    }

    .booking-avatar-neutral { border-color: #dee2e6; background: #f1f3f5; color: #6c757d; }
    .booking-mechanic-info { flex: 1; min-width: 0; }
    .booking-mechanic-info strong { display: block; color: #343a40; font-size: 12px; line-height: 1.5; overflow-wrap: anywhere; }
    .booking-mechanic-info small { display: block; margin-top: 3px; color: var(--booking-muted); font-size: 11px; line-height: 1.5; overflow-wrap: anywhere; }

    .booking-check {
        display: grid;
        place-items: center;
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        border-radius: 50%;
        background: var(--booking-blue);
        color: #fff;
        font-size: 11px;
        opacity: 0;
        transform: scale(.8);
        transition: opacity .2s ease, transform .2s ease;
    }

    .booking-mechanic input:checked + .booking-mechanic-box .booking-check {
        opacity: 1;
        transform: scale(1);
    }

    .booking-info {
        margin-top: 14px;
        padding: 11px 13px;
        border: 1px solid #e0e4e9;
        border-radius: 7px;
        background: #f8f9fa;
        color: #626b75;
        font-size: 12px;
        line-height: 1.7;
    }

    .booking-payment-categories {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .booking-payment-category {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
        min-height: 63px;
        padding: 11px 12px;
        border: 1px solid var(--booking-line-dark);
        border-radius: 8px;
        background: #fff;
        color: #343a40;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: border-color .2s ease, background .2s ease;
    }

    .booking-payment-category:hover { border-color: #b8c9f4; background: #fafcff; }
    .booking-payment-category.is-active { border-color: var(--booking-blue); background: #f0f5ff; }

    .booking-payment-badge {
        display: grid;
        place-items: center;
        min-width: 38px;
        height: 34px;
        padding: 0 7px;
        flex-shrink: 0;
        border-radius: 6px;
        color: #fff;
        font-size: 10px;
        font-weight: 800;
    }

    .booking-payment-arrow { margin-left: auto; color: #9aa2ad; font-size: 20px; line-height: 1; }

    .booking-payment-options {
        margin-top: 13px;
        padding: 14px;
        border: 1px solid var(--booking-line);
        border-radius: 8px;
        background: #f8f9fa;
    }

    .booking-payment-options > strong { display: block; margin-bottom: 11px; color: #495057; font-size: 12px; }
    .booking-payment-chips { display: flex; flex-wrap: wrap; gap: 8px; }

    .booking-payment-option {
        min-height: 36px;
        padding: 8px 14px;
        border: 1px solid var(--booking-line-dark);
        border-radius: 6px;
        background: #fff;
        color: #495057;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
    }

    .booking-payment-option:hover { border-color: #aebedc; background: #f0f5ff; }
    .booking-payment-option.is-active { border-color: var(--booking-blue); background: var(--booking-blue); color: #fff; }
    .is-hidden { display: none !important; }

    .booking-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 43px;
        padding: 11px 19px;
        border: 1px solid transparent;
        border-radius: 7px;
        font-size: 12px;
        line-height: 1.5;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s ease, border-color .2s ease, transform .2s ease;
    }

    .booking-btn:active { transform: translateY(1px); }
    .booking-btn-primary { border-color: var(--booking-blue); background: var(--booking-blue); color: #fff; }
    .booking-btn-primary:hover { border-color: var(--booking-blue-dark); background: var(--booking-blue-dark); color: #fff; }
    .booking-btn-primary:disabled { cursor: not-allowed; opacity: .7; }
    .booking-btn-outline { border-color: var(--booking-line-dark); background: #fff; color: #495057; }
    .booking-btn-outline:hover { border-color: #b8c0ca; background: #f3f5f7; color: #343a40; }

    .booking-btn:focus-visible,
    .booking-payment-category:focus-visible,
    .booking-payment-option:focus-visible {
        outline: 3px solid rgba(50, 100, 216, .2);
        outline-offset: 2px;
    }

    .booking-actions { display: flex; justify-content: flex-end; align-items: center; gap: 10px; flex-wrap: wrap; }

    .booking-sidebar { position: sticky; top: 92px; min-width: 0; }

    /* RINGKASAN */
    .booking-summary {
        position: relative;
        overflow: hidden;
        padding: 20px;
        border: 1px solid #cfdcf3;
        border-top: 3px solid #6c91ff;
        border-radius: 16px;
        background: #eef3fd;
        box-shadow: 0 10px 26px rgba(35, 61, 105, .09);
    }

    .booking-summary-heading { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .booking-summary-kicker { display: block; margin-bottom: 5px; color: #3264d8; font-size: 10px; font-weight: 800; letter-spacing: 1.2px; }
    .booking-summary h2 { margin: 0; color: #14213d; font-size: 18px; line-height: 1.4; font-weight: 800; }
    .booking-summary-icon { display: grid; place-items: center; width: 36px; height: 36px; flex-shrink: 0; border: 1px solid rgba(50, 100, 216, .18); border-radius: 11px; background: #fff; color: #3264d8; font-size: 16px; font-weight: 800; }
    .booking-summary-description { margin: 8px 0 17px; color: #64748b; font-size: 12px; line-height: 1.7; }

    .booking-summary-section {
        margin-top: 14px;
        padding: 14px;
        border: 1px solid #d5e0f2;
        border-radius: 12px;
        background: #fff;
    }

    .booking-summary-section-title { margin: 0 0 10px; color: #334155; font-size: 11px; font-weight: 800; letter-spacing: .45px; text-transform: uppercase; }

    .booking-summary-list {
        margin: 0;
        border: 1px solid #e3e9f3;
        border-radius: 9px;
        overflow: hidden;
        background: #fff;
    }

    .booking-summary-list > div {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        min-height: 42px;
        padding: 11px 12px;
        border-bottom: 1px solid #e9eef6;
        font-size: 12px;
        line-height: 1.55;
    }

    .booking-summary-list > div:nth-child(even) { background: #f8faff; }
    .booking-summary-list > div:last-child { border-bottom: 0; }
    .booking-summary-list dt { flex: 0 0 40%; min-width: 0; color: #64748b; }
    .booking-summary-list dd { flex: 1 1 auto; min-width: 0; margin: 0; color: #1e293b; font-weight: 700; text-align: right; overflow-wrap: anywhere; }
    .booking-summary-list .booking-summary-total { align-items: center; border-top: 1px solid #c9d8f7; background: #e8efff; }
    .booking-summary-list .booking-summary-total dt,
    .booking-summary-list .booking-summary-total dd { color: #244fae; font-size: 13px; font-weight: 800; }

    .booking-summary-note {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-top: 16px;
        padding: 12px;
        border: 1px solid #d5e0f2;
        border-radius: 10px;
        background: #fff;
    }

    .booking-summary-note > span {
        display: grid;
        place-items: center;
        width: 19px;
        height: 19px;
        flex-shrink: 0;
        border: 1px solid #cbd5e1;
        border-radius: 50%;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
    }

    .booking-summary-note p { margin: 0; color: #626b75; font-size: 11px; line-height: 1.8; }
    .booking-footer { margin: 23px 0 0; color: #8b95a3; font-size: 11px; text-align: center; }

    @media (max-width: 1080px) {
        .booking-layout { grid-template-columns: minmax(0, 1fr); }
        .booking-sidebar { position: static; order: 1; }
        .booking-summary { padding: 17px; }
    }

    @media (max-width: 700px) {
        .booking-page { width: min(100% - 20px, 100%); margin: 14px auto 28px; }
        .booking-layout { gap: 16px; }
        .booking-sidebar { min-width: 0; }
        .booking-page input:not([type="radio"]):not([type="checkbox"]),
        .booking-page select,
        .booking-page textarea { width: 100%; max-width: 100%; font-size: 16px; }
        .booking-page input[type="radio"],
        .booking-page input[type="checkbox"] { flex-shrink: 0; }
        .booking-page .booking-btn { min-height: 46px; }
        .booking-header { padding: 18px; margin-bottom: 18px; }
        .booking-header-content { align-items: flex-start; flex-direction: column; gap: 14px; }
        .booking-header h1 { font-size: 23px; }
        .booking-header p { font-size: 12px; }
        .booking-card { padding: 17px 14px; }
        .booking-card-heading { gap: 10px; padding-bottom: 14px; margin-bottom: 17px; }
        .booking-step { width: 32px; height: 32px; }
        .booking-card-heading h2 { font-size: 15px; }
        .booking-card-heading p { font-size: 11px; }
        .booking-fields { grid-template-columns: minmax(0, 1fr); gap: 16px; }
        .booking-field-full { grid-column: auto; }
        .booking-mechanics { grid-template-columns: minmax(0, 1fr); }
        .booking-payment-categories { gap: 8px; }
        .booking-payment-category { gap: 8px; min-height: 58px; padding: 9px; font-size: 11px; }
        .booking-payment-badge { min-width: 32px; height: 30px; padding: 0 5px; font-size: 9px; }
        .booking-summary { padding: 14px 12px; }
        .booking-summary-section { padding: 12px 10px; }
        .booking-summary-list > div { padding: 10px 11px; }
        .booking-actions { flex-direction: column-reverse; align-items: stretch; }
        .booking-actions .booking-btn { width: 100%; }
    }

    @media (max-width: 480px) {
        .booking-payment-categories { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .booking-payment-category { min-width: 0; overflow-wrap: anywhere; }
    }

    @media (max-width: 380px) {
        .booking-header { padding: 15px; }
        .booking-header h1 { font-size: 21px; }
        .booking-card { padding: 15px 12px; }
        .booking-payment-category { gap: 6px; padding: 8px 7px; }
        .booking-payment-badge { min-width: 28px; }
        .booking-summary-list dt { flex-basis: 38%; }
    }

    @media (prefers-reduced-motion: reduce) {
        .booking-page *, .booking-page *::before, .booking-page *::after {
            animation-duration: .01ms !important;
            transition-duration: .01ms !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    'use strict';

    const get = (id) => document.getElementById(id);

    const form = get('bookingForm');
    const nama = get('nama_pelanggan');
    const hp = get('no_hp');
    const motor = get('nama_motor');
    const plat = get('plat_nomor');
    const servis = get('service_id');
    const tanggal = get('tanggal_booking');
    const jam = get('jam_booking');
    const metodeBayar = get('metode_pembayaran');
    const pesanBayar = get('errBayar');
    const tombolKirim = get('btnKirim');

    function isiTeks(elemen, nilai, cadangan = '-') {
        if (elemen) {
            elemen.textContent = nilai && String(nilai).trim()
                ? String(nilai).trim()
                : cadangan;
        }
    }

    function formatRupiah(nilai) {
        return 'Rp' + Number(nilai || 0).toLocaleString('id-ID');
    }

    function perbaruiWaktu() {
        const keterangan = get('ket_waktu');

        if (!jam.value) {
            keterangan.textContent = '';
            return;
        }

        const angkaJam = Number(jam.value.split(':')[0]);
        const waktu = angkaJam < 11 ? 'Pagi'
            : angkaJam < 15 ? 'Siang'
            : angkaJam < 18 ? 'Sore'
            : 'Malam';

        keterangan.textContent = 'Waktu kedatangan: ' + waktu;
    }

    function perbaruiRingkasan() {
        isiTeks(get('sumNama'), nama.value);
        isiTeks(get('sumHp'), hp.value);
        isiTeks(get('sumMotor'), motor.value);
        isiTeks(get('sumPlat'), plat.value.toUpperCase());

        const opsiLayanan = servis.selectedOptions[0];
        const namaLayanan = opsiLayanan && opsiLayanan.value
            ? opsiLayanan.dataset.nama
            : '';

        isiTeks(get('sumServis'), namaLayanan);

        const hargaBarang = Number(opsiLayanan?.dataset.barang || 0);
        const biayaJasa = Number(opsiLayanan?.dataset.jasa || 0);
        const totalHarga = hargaBarang + biayaJasa;

        get('harga-barang').textContent = formatRupiah(hargaBarang);
        get('biaya-jasa').textContent = formatRupiah(biayaJasa);
        get('total-harga').textContent = formatRupiah(totalHarga);

        isiTeks(get('sumHargaBarang'), formatRupiah(hargaBarang));
        isiTeks(get('sumBiayaJasa'), formatRupiah(biayaJasa));
        isiTeks(get('sumTotalHarga'), formatRupiah(totalHarga));

        let jadwal = '-';

        if (tanggal.value) {
            const tanggalDipilih = new Date(tanggal.value + 'T00:00:00');
            jadwal = tanggalDipilih.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });

            if (jam.value) jadwal += ', ' + jam.value;
        } else if (jam.value) {
            jadwal = jam.value;
        }

        isiTeks(get('sumJadwal'), jadwal);
        isiTeks(get('sumBayar'), metodeBayar.dataset.label);

        const mekanikDipilih = document.querySelector('input[name="mechanic_id"]:checked');
        isiTeks(
            get('sumMekanik'),
            mekanikDipilih?.dataset.label || 'Ditentukan admin'
        );
    }

    // Nomor HP: izinkan angka, tanda plus, strip, dan spasi.
    hp.addEventListener('input', function () {
        hp.value = hp.value.replace(/[^0-9+\-\s]/g, '');
        perbaruiRingkasan();
    });

    // Nomor polisi otomatis menjadi huruf besar.
    plat.addEventListener('input', function () {
        const posisiKursor = plat.selectionStart;
        plat.value = plat.value.toUpperCase();

        if (posisiKursor !== null) {
            plat.setSelectionRange(posisiKursor, posisiKursor);
        }

        perbaruiRingkasan();
    });

    [nama, motor, tanggal, jam, servis].forEach(function (elemen) {
        elemen.addEventListener('input', function () {
            perbaruiWaktu();
            perbaruiRingkasan();
        });

        elemen.addEventListener('change', function () {
            perbaruiWaktu();
            perbaruiRingkasan();
        });
    });

    function pilihMetodeBayar(nilai, label) {
        metodeBayar.value = nilai;
        metodeBayar.dataset.label = label;
        pesanBayar.classList.add('is-hidden');
        perbaruiRingkasan();
    }

    // Pilih kategori pembayaran.
    document.querySelectorAll('.booking-payment-category').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            document.querySelectorAll('.booking-payment-category').forEach(function (kategori) {
                const aktif = kategori === tombol;
                kategori.classList.toggle('is-active', aktif);
                kategori.setAttribute('aria-pressed', aktif ? 'true' : 'false');
            });

            document.querySelectorAll('.booking-payment-options').forEach(function (panel) {
                panel.classList.toggle('is-hidden', panel.dataset.sub !== tombol.dataset.kat);
            });

            if (tombol.dataset.nilai) {
                document.querySelectorAll('.booking-payment-option').forEach(function (opsi) {
                    opsi.classList.remove('is-active');
                });

                pilihMetodeBayar(tombol.dataset.nilai, tombol.dataset.label);
                return;
            }

            const panelAktif = document.querySelector(
                '.booking-payment-options[data-sub="' + tombol.dataset.kat + '"]'
            );
            const opsiAktif = panelAktif
                ? panelAktif.querySelector('.booking-payment-option.is-active')
                : null;

            if (opsiAktif) {
                pilihMetodeBayar(opsiAktif.dataset.nilai, opsiAktif.dataset.label);
            } else {
                metodeBayar.value = '';
                metodeBayar.dataset.label = '';
                perbaruiRingkasan();
            }
        });
    });

    // Pilih e-wallet atau bank.
    document.querySelectorAll('.booking-payment-option').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            const panel = tombol.closest('.booking-payment-options');

            if (panel) {
                panel.querySelectorAll('.booking-payment-option').forEach(function (opsi) {
                    opsi.classList.toggle('is-active', opsi === tombol);
                });
            }

            pilihMetodeBayar(tombol.dataset.nilai, tombol.dataset.label);
        });
    });

    // Atur label pembayaran awal, termasuk saat validasi sebelumnya gagal.
    (function aturPembayaranAwal() {
        const opsiAktif = document.querySelector(
            '.booking-payment-options:not(.is-hidden) .booking-payment-option.is-active'
        );
        const kategoriAktif = document.querySelector('.booking-payment-category.is-active');

        if (opsiAktif) {
            metodeBayar.dataset.label = opsiAktif.dataset.label;
        } else if (kategoriAktif && kategoriAktif.dataset.nilai) {
            metodeBayar.dataset.label = kategoriAktif.dataset.label;
        } else {
            metodeBayar.dataset.label = '';
        }
    })();

    document.querySelectorAll('input[name="mechanic_id"]').forEach(function (radio) {
        radio.addEventListener('change', perbaruiRingkasan);
    });

    // Validasi sebelum mengirim booking.
    form.addEventListener('submit', function (event) {
        if (!metodeBayar.value) {
            event.preventDefault();
            pesanBayar.classList.remove('is-hidden');
            pesanBayar.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        if (!servis.value) {
            event.preventDefault();
            servis.focus();
            return;
        }

        tombolKirim.disabled = true;
        tombolKirim.textContent = 'Mengirim...';
    });

    // Isi ringkasan saat halaman pertama kali dibuka.
    perbaruiWaktu();
    perbaruiRingkasan();
})();
</script>
@endpush
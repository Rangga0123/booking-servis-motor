@extends('layouts.customer')

@section('title', 'Booking Servis - Bengkel Royal Motor')

@section('content')
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

<div class="bk-page">

    {{-- HEADER --}}
    <section class="bk-page-heading">
        <div class="bk-heading-text">
            <div class="bk-breadcrumb">
                <span>Pelanggan</span>
                <span class="bk-breadcrumb-separator" aria-hidden="true">/</span>
                <span>Booking Servis</span>
            </div>

            <div class="bk-heading-body">
                <div class="bk-heading-info">
                    <h1>Booking Servis Motor</h1>
                    <p>
                        Isi data kendaraan dan pilih jadwal yang sesuai
                        sebelum datang ke bengkel.
                    </p>
                </div>

                <a href="{{ route('booking.index') }}" class="bk-btn bk-btn-ghost">
                    <span aria-hidden="true">←</span>
                    Lihat Riwayat Booking
                </a>
            </div>
        </div>
    </section>

    {{-- PESAN VALIDASI --}}
    @if ($errors->any())
        <div class="bk-alert" role="alert">
            <div class="bk-alert-icon">!</div>
            <div>
                <strong>Ada data yang perlu diperbaiki.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form
        action="{{ route('booking.store') }}"
        method="POST"
        id="bookingForm"
        class="bk-layout"
    >
        @csrf

        <div class="bk-main">

            {{-- 1. DATA PELANGGAN --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">01</span>
                    <div class="bk-card-title">
                        <h2>Data Pelanggan</h2>
                        <p>Masukkan data orang yang membawa motor untuk diservis.</p>
                    </div>
                </div>

                <div class="bk-grid">
                    <div class="bk-field">
                        <label for="nama_pelanggan">
                            Nama Pemesan <i>*</i>
                        </label>

                        <input
                            class="bk-input"
                            type="text"
                            id="nama_pelanggan"
                            name="nama_pelanggan"
                            value="{{ old('nama_pelanggan', Auth::user()->name) }}"
                            maxlength="255"
                            required
                            placeholder="Masukkan nama lengkap"
                            autocomplete="name"
                        >

                        @error('nama_pelanggan')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="no_hp">
                            No. HP / WhatsApp <i>*</i>
                        </label>

                        <input
                            class="bk-input"
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            inputmode="numeric"
                            maxlength="20"
                            required
                            placeholder="Contoh: 081234567890"
                            autocomplete="tel"
                        >

                        @error('no_hp')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field bk-span">
                        <label for="email_pelanggan">Email</label>

                        <input
                            class="bk-input"
                            type="email"
                            id="email_pelanggan"
                            name="email_pelanggan"
                            value="{{ old('email_pelanggan', Auth::user()->email) }}"
                            maxlength="255"
                            placeholder="nama@email.com"
                            autocomplete="email"
                        >

                        @error('email_pelanggan')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- 2. DATA KENDARAAN --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">02</span>
                    <div class="bk-card-title">
                        <h2>Data Kendaraan</h2>
                        <p>Lengkapi identitas motor yang akan mendapatkan layanan servis.</p>
                    </div>
                </div>

                <div class="bk-grid">
                    <div class="bk-field">
                        <label for="nama_motor">
                            Merek / Tipe Motor <i>*</i>
                        </label>

                        <input
                            class="bk-input"
                            type="text"
                            id="nama_motor"
                            name="nama_motor"
                            value="{{ old('nama_motor') }}"
                            maxlength="255"
                            required
                            placeholder="Contoh: Honda Vario 160"
                        >

                        @error('nama_motor')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="plat_nomor">
                            Nomor Polisi <i>*</i>
                        </label>

                        <input
                            class="bk-input bk-upper"
                            type="text"
                            id="plat_nomor"
                            name="plat_nomor"
                            value="{{ old('plat_nomor') }}"
                            maxlength="20"
                            required
                            placeholder="Contoh: B 1234 ABC"
                        >

                        @error('plat_nomor')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- 3. LAYANAN DAN JADWAL --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">03</span>
                    <div class="bk-card-title">
                        <h2>Layanan dan Jadwal</h2>
                        <p>Tentukan layanan, tanggal, dan waktu kedatangan.</p>
                    </div>
                </div>

                <div class="bk-grid">

                    {{-- PILIH LAYANAN DARI DATABASE --}}
                    <div class="bk-field bk-span">
                        <label for="service_id">
                            Pilih Layanan Servis <i>*</i>
                        </label>

                        <select
                            class="bk-input"
                            id="service_id"
                            name="service_id"
                            required
                        >
                            <option value="">-- Pilih layanan servis --</option>

                            @foreach (($services ?? collect()) as $service)
                                <option
                                    value="{{ $service->id }}"
                                    data-nama="{{ $service->nama_servis }}"
                                    data-barang="{{ $service->harga_barang ?? 0 }}"
                                    data-jasa="{{ $service->biaya_jasa ?? 0 }}"
                                    @selected((string) old('service_id') === (string) $service->id)
                                >
                                    {{ $service->nama_servis }}
                                </option>
                            @endforeach
                        </select>

                        @if (($services ?? collect())->isEmpty())
                            <small class="bk-error">
                                Belum ada layanan yang tersedia. Silakan hubungi admin bengkel.
                            </small>
                        @endif

                        @error('service_id')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror

                        {{-- RINCIAN HARGA --}}
                        <div class="bk-price-box">
                            <div class="bk-price-row">
                                <span>Harga barang / suku cadang</span>
                                <strong id="harga-barang">Rp0</strong>
                            </div>

                            <div class="bk-price-row">
                                <span>Biaya jasa servis</span>
                                <strong id="biaya-jasa">Rp0</strong>
                            </div>

                            <div class="bk-price-row bk-price-total">
                                <span>Total biaya servis</span>
                                <strong id="total-harga">Rp0</strong>
                            </div>
                        </div>

                        <small class="bk-hint">
                            Harga mengikuti layanan yang dipilih. Total akhir akan dihitung kembali oleh sistem.
                        </small>
                    </div>

                    <div class="bk-field">
                        <label for="tanggal_booking">
                            Tanggal Servis <i>*</i>
                        </label>

                        <input
                            class="bk-input"
                            type="date"
                            id="tanggal_booking"
                            name="tanggal_booking"
                            value="{{ old('tanggal_booking') }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >

                        @error('tanggal_booking')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="jam_booking">
                            Jam Servis <i>*</i>
                        </label>

                        <input
                            class="bk-input"
                            type="time"
                            id="jam_booking"
                            name="jam_booking"
                            value="{{ old('jam_booking') }}"
                            required
                        >

                        <small class="bk-hint" id="ket_waktu"></small>

                        @error('jam_booking')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field bk-span">
                        <label for="keluhan">
                            Keluhan / Catatan <i>*</i>
                        </label>

                        <textarea
                            class="bk-input"
                            id="keluhan"
                            name="keluhan"
                            rows="4"
                            required
                            placeholder="Ceritakan kendala motor, misalnya mesin kasar, rem berbunyi, atau susah distarter..."
                        >{{ old('keluhan') }}</textarea>

                        @error('keluhan')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- 4. PILIH MEKANIK --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">04</span>
                    <div class="bk-card-title">
                        <h2>Pilih Mekanik</h2>
                        <p>Pilih mekanik jika tersedia, atau serahkan penentuan kepada admin.</p>
                    </div>
                </div>

                <div class="bk-mek-grid">
                    <label class="bk-mek">
                        <input
                            type="radio"
                            name="mechanic_id"
                            value=""
                            data-label="Ditentukan admin"
                            @checked(!old('mechanic_id'))
                        >

                        <span class="bk-mek-box">
                            <span class="bk-mek-avatar bk-mek-any">?</span>
                            <span class="bk-mek-info">
                                <strong>Bebas</strong>
                                <small>Ditentukan oleh admin</small>
                            </span>
                            <span class="bk-tick" aria-hidden="true">✓</span>
                        </span>
                    </label>

                    @foreach (($mechanics ?? collect()) as $mekanik)
                        <label class="bk-mek">
                            <input
                                type="radio"
                                name="mechanic_id"
                                value="{{ $mekanik->id }}"
                                data-label="{{ $mekanik->nama_mekanik }}"
                                @checked((string) old('mechanic_id') === (string) $mekanik->id)
                            >

                            <span class="bk-mek-box">
                                <span class="bk-mek-avatar">
                                    {{ strtoupper(substr($mekanik->nama_mekanik ?? 'M', 0, 1)) }}
                                </span>

                                <span class="bk-mek-info">
                                    <strong>{{ $mekanik->nama_mekanik }}</strong>
                                    <small>{{ $mekanik->spesialisasi ?: 'Mekanik Royal Motor' }}</small>
                                </span>

                                <span class="bk-tick" aria-hidden="true">✓</span>
                            </span>
                        </label>
                    @endforeach
                </div>

                @if (($mechanics ?? collect())->isEmpty())
                    <div class="bk-info-note">
                        Belum ada mekanik aktif yang bisa dipilih. Mekanik akan ditentukan oleh admin.
                    </div>
                @endif

                @error('mechanic_id')
                    <small class="bk-error">{{ $message }}</small>
                @enderror
            </section>

            {{-- 5. METODE PEMBAYARAN --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">05</span>
                    <div class="bk-card-title">
                        <h2>Metode Pembayaran</h2>
                        <p>Pilih metode pembayaran yang tersedia. Pembayaran dilakukan setelah servis.</p>
                    </div>
                </div>

                <input
                    type="hidden"
                    name="metode_pembayaran"
                    id="metode_pembayaran"
                    value="{{ $metodeLama }}"
                >

                <div class="bk-cat-grid">
                    @foreach ($kategoriBayar as $kode => $kat)
                        @php
                            $nilaiLangsung = $kode === 'tunai'
                                ? 'Tunai / Bayar di Kasir'
                                : ($kode === 'qris' ? 'QRIS' : '');

                            $labelLangsung = $kode === 'tunai'
                                ? 'Tunai (bayar di kasir)'
                                : ($kode === 'qris' ? 'QRIS' : '');
                        @endphp

                        <button
                            type="button"
                            class="bk-cat {{ $kode === $kategoriAktif ? 'is-active' : '' }}"
                            data-kat="{{ $kode }}"
                            data-nilai="{{ $nilaiLangsung }}"
                            data-label="{{ $labelLangsung }}"
                            aria-pressed="{{ $kode === $kategoriAktif ? 'true' : 'false' }}"
                        >
                            <span
                                class="bk-badge"
                                style="background:{{ $kat['warna'] }};color:#fff"
                            >{{ $kat['badge'] }}</span>

                            <span class="bk-cat-label">{{ $kat['label'] }}</span>
                            <span class="bk-cat-arrow" aria-hidden="true">›</span>
                        </button>
                    @endforeach
                </div>

                @foreach (['ewallet', 'bank'] as $kode)
                    <div
                        class="bk-sub {{ $kode === $kategoriAktif ? '' : 'is-hidden' }}"
                        data-sub="{{ $kode }}"
                    >
                        <span class="bk-sub-title">
                            Pilih {{ $kode === 'ewallet' ? 'e-wallet' : 'bank tujuan' }}
                        </span>

                        <div class="bk-sub-chips">
                            @foreach ($kategoriBayar[$kode]['pilihan'] as $pilihan)
                                @php
                                    $nilai = $kode === 'bank'
                                        ? 'Transfer ' . $pilihan
                                        : $pilihan;
                                @endphp

                                <button
                                    type="button"
                                    class="bk-opt {{ $metodeLama === $nilai ? 'is-active' : '' }}"
                                    data-nilai="{{ $nilai }}"
                                    data-label="{{ $nilai }}"
                                >{{ $pilihan }}</button>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <small class="bk-error is-hidden" id="errBayar" role="alert">
                    Pilih e-wallet atau bank terlebih dahulu.
                </small>

                @error('metode_pembayaran')
                    <small class="bk-error">{{ $message }}</small>
                @enderror
            </section>

            {{-- TOMBOL AKSI --}}
            <div class="bk-actions">
                <a href="{{ route('booking.index') }}" class="bk-btn bk-btn-ghost">
                    Batal
                </a>

                <button
                    type="submit"
                    class="bk-btn bk-btn-primary"
                    id="btnKirim"
                >
                    Kirim Booking <span aria-hidden="true">→</span>
                </button>
            </div>
        </div>

        {{-- RINGKASAN BOOKING --}}
        <aside class="bk-side">
            <div class="bk-summary">
                <div class="bk-summary-head">
                    <div>
                        <span class="bk-summary-kicker">RINGKASAN</span>
                        <h3>Booking Kamu</h3>
                    </div>

                    <span class="bk-summary-icon" aria-hidden="true">✓</span>
                </div>

                <p class="bk-sum-sub">
                    Periksa kembali data sebelum mengirim booking.
                </p>

                <dl>
                    <div>
                        <dt>Pemesan</dt>
                        <dd id="sumNama">-</dd>
                    </div>

                    <div>
                        <dt>No. HP</dt>
                        <dd id="sumHp">-</dd>
                    </div>

                    <div>
                        <dt>Motor</dt>
                        <dd id="sumMotor">-</dd>
                    </div>

                    <div>
                        <dt>Nomor polisi</dt>
                        <dd id="sumPlat">-</dd>
                    </div>

                    <div>
                        <dt>Servis</dt>
                        <dd id="sumServis">-</dd>
                    </div>

                    <div>
                        <dt>Harga barang</dt>
                        <dd id="sumHargaBarang">Rp0</dd>
                    </div>

                    <div>
                        <dt>Biaya jasa</dt>
                        <dd id="sumBiayaJasa">Rp0</dd>
                    </div>

                    <div>
                        <dt>Total biaya</dt>
                        <dd id="sumTotalHarga">Rp0</dd>
                    </div>

                    <div>
                        <dt>Jadwal</dt>
                        <dd id="sumJadwal">-</dd>
                    </div>

                    <div>
                        <dt>Mekanik</dt>
                        <dd id="sumMekanik">Ditentukan admin</dd>
                    </div>

                    <div>
                        <dt>Pembayaran</dt>
                        <dd id="sumBayar">-</dd>
                    </div>
                </dl>

                <div class="bk-note">
                    <span class="bk-note-icon" aria-hidden="true">i</span>
                    <p>
                        Booking akan diperiksa oleh admin. Pantau status pesanan melalui halaman riwayat booking.
                    </p>
                </div>
            </div>
        </aside>
    </form>

    <p class="bk-foot">Royal Motor · Booking Servis Motor</p>
</div>
@endsection

@push('styles')
<style>
    .bk-page {
        --bk-blue: #3264d8;
        --bk-blue-dark: #244fae;
        --bk-text: #343a40;
        --bk-muted: #6c757d;
        --bk-line: #dfe3e8;
        --bk-line-dark: #cbd1d8;
        --bk-soft: #f7f8fa;

        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
        color: var(--bk-text);
    }

    .bk-page,
    .bk-page * {
        box-sizing: border-box;
    }

    .bk-page button,
    .bk-page input,
    .bk-page textarea,
    .bk-page select {
        font-family: inherit;
    }

    .bk-page-heading {
        position: relative;
        overflow: hidden;
        width: 100%;
        margin: 0 0 30px;
        padding: 23px 25px;
        background: #fff;
        border: 1px solid #dce5f1;
        border-left: 4px solid #3264d8;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(39, 61, 99, .035);
        animation: bkHeadingAppear .45s ease both;
    }

    .bk-heading-text {
        width: 100%;
        min-width: 0;
    }

    .bk-page .bk-breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 9px;
        margin: 0 0 18px;
        color: #7182a3;
        font-size: 12px;
        line-height: 1.5;
    }

    .bk-page .bk-breadcrumb span:last-child {
        color: #3264d8;
        font-weight: 700;
    }

    .bk-page .bk-breadcrumb-separator {
        color: #7182a3;
    }

    .bk-heading-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .bk-heading-info {
        min-width: 0;
        max-width: 750px;
    }

    .bk-page .bk-heading-info h1 {
        margin: 0;
        color: #14213d;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.35;
        letter-spacing: -.45px;
        overflow-wrap: anywhere;
    }

    .bk-page .bk-heading-info p {
        max-width: 650px;
        margin: 9px 0 0;
        color: #7182a3;
        font-size: 13px;
        line-height: 1.8;
    }

    @keyframes bkHeadingAppear {
        from {
            opacity: 0;
            transform: translateY(7px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bk-alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 15px 16px;
        margin-bottom: 20px;
        border: 1px solid #f0c2c7;
        border-left: 4px solid #dc3545;
        border-radius: 8px;
        background: #fff8f8;
        color: #842029;
        font-size: 13px;
    }

    .bk-alert-icon {
        display: grid;
        place-items: center;
        width: 25px;
        height: 25px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #f8d7da;
        color: #842029;
        font-weight: 800;
    }

    .bk-alert strong {
        display: block;
        margin: 2px 0 5px;
    }

    .bk-alert ul {
        margin: 0;
        padding-left: 18px;
        line-height: 1.8;
    }

    .bk-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        align-items: start;
        gap: 22px;
    }

    .bk-main {
        display: flex;
        flex-direction: column;
        gap: 18px;
        min-width: 0;
    }

    .bk-card {
        min-width: 0;
        padding: 22px;
        border: 1px solid var(--bk-line);
        border-radius: 9px;
        background: #fff;
        box-shadow: 0 2px 7px rgba(30, 41, 59, .025);
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .bk-card:hover {
        border-color: #cbd3dd;
        box-shadow: 0 4px 12px rgba(30, 41, 59, .035);
    }

    .bk-card-head {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding-bottom: 17px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--bk-line);
    }

    .bk-step {
        display: grid;
        place-items: center;
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        border: 1px solid #d6e2ff;
        border-radius: 8px;
        background: #edf3ff;
        color: var(--bk-blue);
        font-size: 12px;
        font-weight: 800;
    }

    .bk-card-title {
        min-width: 0;
        padding-top: 1px;
    }

    .bk-card-head h2 {
        margin: 0;
        color: #343a40;
        font-size: 16px;
        line-height: 1.5;
        font-weight: 800;
    }

    .bk-card-head p {
        margin: 4px 0 0;
        color: var(--bk-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    .bk-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 19px;
    }

    .bk-span {
        grid-column: 1 / -1;
    }

    .bk-field {
        min-width: 0;
    }

    .bk-field label {
        display: block;
        margin-bottom: 8px;
        color: #343a40;
        font-size: 13px;
        font-weight: 700;
    }

    .bk-field label i {
        color: #dc3545;
        font-style: normal;
    }

    .bk-input {
        display: block;
        width: 100%;
        min-width: 0;
        min-height: 43px;
        padding: 11px 13px;
        border: 1px solid var(--bk-line-dark);
        border-radius: 7px;
        outline: none;
        background: #fff;
        color: #343a40;
        font-size: 13px;
        line-height: 1.6;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .bk-input:hover {
        border-color: #aeb8c4;
    }

    .bk-input:focus {
        border-color: var(--bk-blue);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(50, 100, 216, .12);
    }

    .bk-input::placeholder {
        color: #9aa2ad;
        opacity: 1;
    }

    textarea.bk-input {
        min-height: 115px;
        resize: vertical;
        line-height: 1.7;
    }

    .bk-upper {
        text-transform: uppercase;
    }

    .bk-upper::placeholder {
        text-transform: none;
    }

    .bk-hint {
        display: block;
        margin-top: 7px;
        color: var(--bk-muted);
        font-size: 11px;
        line-height: 1.7;
    }

    .bk-error {
        display: block;
        margin-top: 7px;
        color: #c92a3b;
        font-size: 12px;
        line-height: 1.6;
    }

    /* RINCIAN HARGA */
    .bk-price-box {
        margin-top: 15px;
        padding: 15px;
        border: 1px solid #dfe3e8;
        border-radius: 8px;
        background: #f8faff;
    }

    .bk-price-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        padding: 10px 0;
        color: #626b75;
        font-size: 12px;
        line-height: 1.6;
    }

    .bk-price-row strong {
        color: #343a40;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .bk-price-total {
        margin-top: 5px;
        padding-top: 14px;
        border-top: 1px solid #dfe3e8;
    }

    .bk-price-total span,
    .bk-price-total strong {
        color: #244fae;
        font-size: 14px;
        font-weight: 800;
    }

    .bk-mek-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 11px;
    }

    .bk-mek {
        position: relative;
        display: block;
        min-width: 0;
        cursor: pointer;
    }

    .bk-mek input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .bk-mek-box {
        display: flex;
        align-items: center;
        gap: 11px;
        min-height: 72px;
        padding: 12px;
        border: 1px solid var(--bk-line-dark);
        border-radius: 8px;
        background: #fff;
        transition: border-color .2s ease, background .2s ease;
    }

    .bk-mek:hover .bk-mek-box {
        border-color: #aebedc;
        background: #fafcff;
    }

    .bk-mek input:focus-visible + .bk-mek-box {
        outline: 3px solid rgba(50, 100, 216, .16);
        outline-offset: 2px;
    }

    .bk-mek input:checked + .bk-mek-box {
        border-color: var(--bk-blue);
        background: #f0f5ff;
        box-shadow: inset 0 0 0 1px rgba(50, 100, 216, .12);
    }

    .bk-mek-avatar {
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

    .bk-mek-any {
        border-color: #dee2e6;
        background: #f1f3f5;
        color: #6c757d;
    }

    .bk-mek-info {
        flex: 1;
        min-width: 0;
    }

    .bk-mek-info strong {
        display: block;
        overflow-wrap: anywhere;
        color: #343a40;
        font-size: 12px;
        line-height: 1.5;
    }

    .bk-mek-info small {
        display: block;
        margin-top: 3px;
        color: var(--bk-muted);
        font-size: 11px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .bk-tick {
        display: grid;
        place-items: center;
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        border-radius: 50%;
        background: var(--bk-blue);
        color: #fff;
        font-size: 11px;
        opacity: 0;
        transform: scale(.8);
        transition: opacity .2s ease, transform .2s ease;
    }

    .bk-mek input:checked + .bk-mek-box .bk-tick {
        opacity: 1;
        transform: scale(1);
    }

    .bk-info-note {
        margin-top: 14px;
        padding: 11px 13px;
        border: 1px solid #e0e4e9;
        border-radius: 7px;
        background: #f8f9fa;
        color: #626b75;
        font-size: 12px;
        line-height: 1.7;
    }

    .bk-cat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .bk-cat {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
        min-height: 63px;
        padding: 11px 12px;
        border: 1px solid var(--bk-line-dark);
        border-radius: 8px;
        background: #fff;
        text-align: left;
        cursor: pointer;
        transition: border-color .2s ease, background .2s ease;
    }

    .bk-cat:hover {
        border-color: #b8c9f4;
        background: #fafcff;
    }

    .bk-cat.is-active {
        border-color: var(--bk-blue);
        background: #f0f5ff;
        box-shadow: inset 0 0 0 1px rgba(50, 100, 216, .08);
    }

    .bk-badge {
        display: grid;
        place-items: center;
        min-width: 38px;
        height: 34px;
        padding: 0 7px;
        flex-shrink: 0;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 800;
    }

    .bk-cat-label {
        flex: 1;
        min-width: 0;
        color: #343a40;
        font-size: 12px;
        line-height: 1.5;
        font-weight: 700;
    }

    .bk-cat-arrow {
        color: #9aa2ad;
        font-size: 20px;
        line-height: 1;
    }

    .bk-cat.is-active .bk-cat-arrow {
        color: var(--bk-blue);
    }

    .bk-sub {
        margin-top: 13px;
        padding: 14px;
        border: 1px solid var(--bk-line);
        border-radius: 8px;
        background: #f8f9fa;
    }

    .bk-sub-title {
        display: block;
        margin-bottom: 11px;
        color: #495057;
        font-size: 12px;
        font-weight: 700;
    }

    .bk-sub-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .bk-opt {
        min-height: 36px;
        padding: 8px 14px;
        border: 1px solid var(--bk-line-dark);
        border-radius: 6px;
        background: #fff;
        color: #495057;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
    }

    .bk-opt:hover {
        border-color: #aebedc;
        background: #f0f5ff;
    }

    .bk-opt.is-active {
        border-color: var(--bk-blue);
        background: var(--bk-blue);
        color: #fff;
    }

    .bk-opt.is-active:hover {
        background: var(--bk-blue-dark);
    }

    .is-hidden {
        display: none !important;
    }

    .bk-chip:focus-visible,
    .bk-opt:focus-visible,
    .bk-cat:focus-visible,
    .bk-btn:focus-visible {
        outline: 3px solid rgba(50, 100, 216, .2);
        outline-offset: 2px;
    }

    .bk-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 2px;
    }

    .bk-btn {
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

    .bk-btn:active {
        transform: translateY(1px);
    }

    .bk-btn-primary {
        border-color: var(--bk-blue);
        background: var(--bk-blue);
        color: #fff;
    }

    .bk-btn-primary:hover {
        border-color: var(--bk-blue-dark);
        background: var(--bk-blue-dark);
        color: #fff;
    }

    .bk-btn-primary:disabled {
        cursor: not-allowed;
        opacity: .7;
    }

    .bk-btn-ghost {
        border-color: var(--bk-line-dark);
        background: #fff;
        color: #495057;
    }

    .bk-btn-ghost:hover {
        border-color: #b8c0ca;
        background: #f3f5f7;
        color: #343a40;
    }

    .bk-side {
        position: sticky;
        top: 92px;
        min-width: 0;
    }

    .bk-summary {
        overflow: hidden;
        padding: 20px;
        border: 1px solid var(--bk-line);
        border-top: 3px solid var(--bk-blue);
        border-radius: 9px;
        background: #fff;
        box-shadow: 0 3px 12px rgba(30, 41, 59, .035);
    }

    .bk-summary-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .bk-summary-kicker {
        display: block;
        margin-bottom: 5px;
        color: var(--bk-blue);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .bk-summary h3 {
        margin: 0;
        color: #343a40;
        font-size: 17px;
        line-height: 1.4;
        font-weight: 800;
    }

    .bk-summary-icon {
        display: grid;
        place-items: center;
        width: 35px;
        height: 35px;
        flex-shrink: 0;
        border: 1px solid #dce6fb;
        border-radius: 8px;
        background: #edf3ff;
        color: var(--bk-blue);
        font-size: 16px;
        font-weight: 800;
    }

    .bk-sum-sub {
        margin: 8px 0 17px;
        color: var(--bk-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    .bk-summary dl {
        margin: 0;
        border-top: 1px solid var(--bk-line);
    }

    .bk-summary dl > div {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--bk-line);
        font-size: 12px;
        line-height: 1.6;
    }

    .bk-summary dt {
        flex-shrink: 0;
        color: var(--bk-muted);
    }

    .bk-summary dd {
        max-width: 62%;
        margin: 0;
        color: #343a40;
        font-weight: 700;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .bk-note {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-top: 16px;
        padding: 12px;
        border: 1px solid #e0e5ec;
        border-radius: 7px;
        background: #f7f8fa;
    }

    .bk-note-icon {
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

    .bk-note p {
        margin: 0;
        color: #626b75;
        font-size: 11px;
        line-height: 1.8;
    }

    .bk-foot {
        margin: 23px 0 0;
        color: #8b95a3;
        font-size: 11px;
        text-align: center;
    }

    @media (max-width: 1080px) {
        .bk-layout {
            grid-template-columns: minmax(0, 1fr);
            gap: 18px;
        }

        .bk-side {
            position: static;
            order: -1;
        }

        .bk-summary {
            padding: 17px;
        }

        .bk-summary dl {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 20px;
        }

        .bk-summary dl > div {
            gap: 8px;
        }
    }

    @media (max-width: 700px) {
        .bk-page-heading {
            padding: 18px;
            margin-bottom: 25px;
            border-radius: 9px;
        }

        .bk-page .bk-breadcrumb {
            gap: 7px;
            margin-bottom: 14px;
            font-size: 11px;
        }

        .bk-heading-body {
            align-items: stretch;
            flex-direction: column;
            gap: 14px;
        }

        .bk-page .bk-heading-info h1 {
            font-size: 23px;
            line-height: 1.4;
        }

        .bk-page .bk-heading-info p {
            margin-top: 8px;
            font-size: 12px;
            line-height: 1.8;
        }

        .bk-heading-body > .bk-btn {
            align-self: flex-start;
            max-width: 100%;
        }

        .bk-main {
            gap: 14px;
        }

        .bk-card {
            padding: 17px 14px;
            border-radius: 8px;
        }

        .bk-card-head {
            gap: 10px;
            padding-bottom: 14px;
            margin-bottom: 17px;
        }

        .bk-step {
            width: 32px;
            height: 32px;
            font-size: 11px;
        }

        .bk-card-head h2 {
            font-size: 15px;
        }

        .bk-card-head p {
            font-size: 11px;
        }

        .bk-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 16px;
        }

        .bk-span {
            grid-column: auto;
        }

        .bk-input {
            min-height: 44px;
            font-size: 13px;
        }

        .bk-mek-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .bk-cat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .bk-cat {
            gap: 8px;
            min-height: 58px;
            padding: 9px;
        }

        .bk-badge {
            min-width: 32px;
            height: 30px;
            padding: 0 5px;
            font-size: 9px;
        }

        .bk-cat-label {
            font-size: 11px;
        }

        .bk-cat-arrow {
            font-size: 17px;
        }

        .bk-summary {
            padding: 16px 14px;
        }

        .bk-summary dl {
            grid-template-columns: minmax(0, 1fr);
        }

        .bk-summary dl > div {
            padding: 10px 0;
        }

        .bk-summary dd {
            max-width: 65%;
        }

        .bk-actions {
            flex-direction: column-reverse;
            align-items: stretch;
            gap: 9px;
        }

        .bk-actions .bk-btn {
            width: 100%;
        }

        .bk-price-row {
            gap: 10px;
        }
    }

    @media (max-width: 380px) {
        .bk-page-heading {
            padding: 15px;
        }

        .bk-page .bk-heading-info h1 {
            font-size: 21px;
        }

        .bk-card {
            padding: 15px 12px;
        }

        .bk-cat {
            gap: 6px;
            padding: 8px 7px;
        }

        .bk-cat-label {
            font-size: 10px;
        }

        .bk-badge {
            min-width: 28px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const $ = (id) => document.getElementById(id);

    const nama = $('nama_pelanggan');
    const hp = $('no_hp');
    const motor = $('nama_motor');
    const plat = $('plat_nomor');
    const servis = $('service_id');
    const tgl = $('tanggal_booking');
    const jam = $('jam_booking');
    const ket = $('ket_waktu');

    const hargaBarangEl = $('harga-barang');
    const biayaJasaEl = $('biaya-jasa');
    const totalHargaEl = $('total-harga');

    const bayarInput = $('metode_pembayaran');
    const errBayar = $('errBayar');
    const form = $('bookingForm');
    const btnKirim = $('btnKirim');

    function teks(el, nilai) {
        if (!el) return;
        el.textContent = nilai && String(nilai).trim()
            ? String(nilai).trim()
            : '-';
    }

    function rupiah(angka) {
        return 'Rp' + Number(angka || 0).toLocaleString('id-ID');
    }

    function labelWaktu() {
        if (!jam.value) {
            ket.textContent = '';
            return '';
        }

        const jamAngka = Number(jam.value.split(':')[0]);

        const waktu = jamAngka < 11
            ? 'Pagi'
            : jamAngka < 15
                ? 'Siang'
                : jamAngka < 18
                    ? 'Sore'
                    : 'Malam';

        ket.textContent = 'Waktu kedatangan: ' + waktu;
        return waktu;
    }

    function ringkasan() {
        teks($('sumNama'), nama.value);
        teks($('sumHp'), hp.value);
        teks($('sumMotor'), motor.value);
        teks($('sumPlat'), plat.value.toUpperCase());

        const opsiServis = servis.selectedOptions[0];
        const servisDipilih = opsiServis && opsiServis.value
            ? opsiServis.dataset.nama
            : '';

        teks($('sumServis'), servisDipilih);

        const hargaBarang = Number(opsiServis?.dataset.barang || 0);
        const biayaJasa = Number(opsiServis?.dataset.jasa || 0);
        const totalHarga = hargaBarang + biayaJasa;

        hargaBarangEl.textContent = rupiah(hargaBarang);
        biayaJasaEl.textContent = rupiah(biayaJasa);
        totalHargaEl.textContent = rupiah(totalHarga);

        teks($('sumHargaBarang'), rupiah(hargaBarang));
        teks($('sumBiayaJasa'), rupiah(biayaJasa));
        teks($('sumTotalHarga'), rupiah(totalHarga));

        let jadwal = '-';

        if (tgl.value) {
            const tanggal = new Date(tgl.value + 'T00:00:00');

            jadwal = tanggal.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });

            if (jam.value) {
                jadwal += ', ' + jam.value;
            }
        } else if (jam.value) {
            jadwal = jam.value;
        }

        $('sumJadwal').textContent = jadwal;
        $('sumBayar').textContent = bayarInput.dataset.label || '-';

        const mekanik = document.querySelector(
            'input[name="mechanic_id"]:checked'
        );

        $('sumMekanik').textContent = mekanik
            ? (mekanik.dataset.label || 'Ditentukan admin')
            : 'Ditentukan admin';
    }

    // FORMAT NOMOR HP
    hp.addEventListener('input', function () {
        hp.value = hp.value.replace(/[^0-9+\-\s]/g, '');
        ringkasan();
    });

    // NOMOR POLISI MENJADI HURUF BESAR
    plat.addEventListener('input', function () {
        const posisi = plat.selectionStart;

        plat.value = plat.value.toUpperCase();

        if (posisi !== null) {
            plat.setSelectionRange(posisi, posisi);
        }

        ringkasan();
    });

    // PERUBAHAN PILIHAN LAYANAN DAN HARGA
    servis.addEventListener('change', ringkasan);

    // PERUBAHAN DATA FORM
    [nama, motor, tgl, jam].forEach(function (el) {
        el.addEventListener('input', function () {
            labelWaktu();
            ringkasan();
        });

        el.addEventListener('change', function () {
            labelWaktu();
            ringkasan();
        });
    });

    // METODE PEMBAYARAN
    function setBayar(nilai, label) {
        bayarInput.value = nilai;
        bayarInput.dataset.label = label;

        errBayar.classList.add('is-hidden');

        ringkasan();
    }

    document.querySelectorAll('.bk-cat').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.bk-cat').forEach(function (kategori) {
                const aktif = kategori === btn;

                kategori.classList.toggle('is-active', aktif);
                kategori.setAttribute(
                    'aria-pressed',
                    aktif ? 'true' : 'false'
                );
            });

            document.querySelectorAll('.bk-sub').forEach(function (panel) {
                panel.classList.toggle(
                    'is-hidden',
                    panel.dataset.sub !== btn.dataset.kat
                );
            });

            if (btn.dataset.nilai) {
                document.querySelectorAll('.bk-opt').forEach(function (opsi) {
                    opsi.classList.remove('is-active');
                });

                setBayar(btn.dataset.nilai, btn.dataset.label);
                return;
            }

            const panelAktif = document.querySelector(
                '.bk-sub[data-sub="' + btn.dataset.kat + '"]'
            );

            const opsiAktif = panelAktif
                ? panelAktif.querySelector('.bk-opt.is-active')
                : null;

            if (opsiAktif) {
                setBayar(
                    opsiAktif.dataset.nilai,
                    opsiAktif.dataset.label
                );
            } else {
                bayarInput.value = '';
                bayarInput.dataset.label = '';
                errBayar.classList.add('is-hidden');
                ringkasan();
            }
        });
    });

    document.querySelectorAll('.bk-opt').forEach(function (opt) {
        opt.addEventListener('click', function () {
            const panel = opt.closest('.bk-sub');

            if (panel) {
                panel.querySelectorAll('.bk-opt').forEach(function (opsi) {
                    opsi.classList.toggle('is-active', opsi === opt);
                });
            }

            setBayar(opt.dataset.nilai, opt.dataset.label);
        });
    });

    // LABEL PEMBAYARAN AWAL
    (function () {
        const opsiAktif = document.querySelector(
            '.bk-sub:not(.is-hidden) .bk-opt.is-active'
        );

        const kategoriAktif = document.querySelector('.bk-cat.is-active');

        if (opsiAktif) {
            bayarInput.dataset.label = opsiAktif.dataset.label;
        } else if (kategoriAktif && kategoriAktif.dataset.nilai) {
            bayarInput.dataset.label = kategoriAktif.dataset.label;
        } else {
            bayarInput.dataset.label = '';
        }
    })();

    // PERUBAHAN MEKANIK
    document.querySelectorAll('input[name="mechanic_id"]').forEach(function (radio) {
        radio.addEventListener('change', ringkasan);
    });

    // CEGAH PENGIRIMAN GANDA DAN VALIDASI PEMBAYARAN
    form.addEventListener('submit', function (event) {
        if (!bayarInput.value) {
            event.preventDefault();

            errBayar.classList.remove('is-hidden');

            errBayar.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            return;
        }

        if (!servis.value) {
            event.preventDefault();
            servis.focus();
            return;
        }

        btnKirim.disabled = true;
        btnKirim.style.opacity = '.75';
        btnKirim.innerHTML = 'Mengirim...';
    });

    // TAMPILAN AWAL
    labelWaktu();
    ringkasan();
})();
</script>
@endpush
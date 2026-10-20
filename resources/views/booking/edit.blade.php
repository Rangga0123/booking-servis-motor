@extends('layouts.customer')

@section('title', 'Edit Booking - Bengkel Royal Motor')

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

    $metodeLama = old(
        'metode_pembayaran',
        $booking->metode_pembayaran ?: 'Tunai / Bayar di Kasir'
    );

    if ($metodeLama === 'QRIS') {
        $kategoriAktif = 'qris';
    } elseif (str_starts_with($metodeLama, 'Transfer ')) {
        $kategoriAktif = 'bank';
    } elseif (in_array($metodeLama, $kategoriBayar['ewallet']['pilihan'], true)) {
        $kategoriAktif = 'ewallet';
    } else {
        $kategoriAktif = 'tunai';
    }

    $mekanikTerpilih = old('mechanic_id', $booking->mechanic_id);

    $saranServis = [
        'Servis rutin',
        'Ganti oli',
        'Ganti aki',
        'Ganti ban',
        'Rem',
        'Kelistrikan',
        'Tune up',
        'Cek kerusakan',
    ];

    $tanggalLama = old(
        'tanggal_booking',
        $booking->tanggal_booking
            ? \Illuminate\Support\Carbon::parse($booking->tanggal_booking)->format('Y-m-d')
            : ''
    );

    $jamLama = old(
        'jam_booking',
        $booking->jam_booking
            ? substr((string) $booking->jam_booking, 0, 5)
            : ''
    );
@endphp

<div class="bk-page">

    <header class="bk-head">
        <div>
            <span class="bk-eyebrow">Royal Motor</span>
            <h1>Edit Booking Servis</h1>
            <p>Periksa dan perbarui data booking sebelum menyimpan perubahan.</p>
        </div>

        <a href="{{ route('booking.index') }}" class="bk-btn bk-btn-ghost">
            ← Riwayat Booking
        </a>
    </header>

    @if ($errors->any())
        <div class="bk-alert">
            <strong>Ada data yang perlu diperbaiki.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('booking.update', $booking->id) }}"
        method="POST"
        id="bookingForm"
        class="bk-layout"
    >
        @csrf
        @method('PUT')

        <div class="bk-main">

            {{-- 1. DATA PELANGGAN --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">1</span>
                    <div>
                        <h2>Data Pelanggan</h2>
                        <p>Perbarui informasi orang yang membawa motor.</p>
                    </div>
                </div>

                <div class="bk-grid">
                    <div class="bk-field">
                        <label for="nama_pelanggan">Nama Pemesan <i>*</i></label>
                        <input
                            class="bk-input"
                            type="text"
                            id="nama_pelanggan"
                            name="nama_pelanggan"
                            value="{{ old('nama_pelanggan', $booking->nama_pelanggan) }}"
                            maxlength="255"
                            required
                            placeholder="Nama lengkap"
                        >
                        @error('nama_pelanggan')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="no_hp">No. HP / WhatsApp <i>*</i></label>
                        <input
                            class="bk-input"
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            value="{{ old('no_hp', $booking->no_hp) }}"
                            inputmode="tel"
                            maxlength="20"
                            required
                            placeholder="Contoh: 081234567890"
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
                            value="{{ old('email_pelanggan', $booking->email_pelanggan) }}"
                            maxlength="255"
                            placeholder="nama@email.com"
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
                    <span class="bk-step">2</span>
                    <div>
                        <h2>Data Kendaraan</h2>
                        <p>Perbarui merek motor dan nomor polisi kendaraan.</p>
                    </div>
                </div>

                <div class="bk-grid">
                    <div class="bk-field">
                        <label for="nama_motor">Merek / Tipe Motor <i>*</i></label>
                        <input
                            class="bk-input"
                            type="text"
                            id="nama_motor"
                            name="nama_motor"
                            value="{{ old('nama_motor', $booking->nama_motor) }}"
                            maxlength="255"
                            required
                            placeholder="Contoh: Honda Vario 160"
                        >
                        @error('nama_motor')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="plat_nomor">Nomor Polisi <i>*</i></label>
                        <input
                            class="bk-input bk-upper"
                            type="text"
                            id="plat_nomor"
                            name="plat_nomor"
                            value="{{ old('plat_nomor', $booking->plat_nomor) }}"
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
                    <span class="bk-step">3</span>
                    <div>
                        <h2>Layanan dan Jadwal</h2>
                        <p>Sesuaikan kebutuhan servis serta waktu kedatangan.</p>
                    </div>
                </div>

                <div class="bk-grid">
                    <div class="bk-field bk-span">
                        <label for="jenis_servis">Servis yang Diinginkan <i>*</i></label>
                        <input
                            class="bk-input"
                            type="text"
                            id="jenis_servis"
                            name="jenis_servis"
                            value="{{ old('jenis_servis', $booking->jenis_servis) }}"
                            maxlength="255"
                            required
                            placeholder="Contoh: Ganti oli dan cek rem depan"
                        >

                        <div class="bk-chips" aria-label="Saran cepat">
                            @foreach ($saranServis as $saran)
                                <button
                                    type="button"
                                    class="bk-chip"
                                    data-saran="{{ $saran }}"
                                >
                                    + {{ $saran }}
                                </button>
                            @endforeach
                        </div>

                        <small class="bk-hint">
                            Ketik kebutuhan servis atau klik salah satu saran.
                        </small>

                        @error('jenis_servis')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="tanggal_booking">Tanggal Servis <i>*</i></label>
                        <input
                            class="bk-input"
                            type="date"
                            id="tanggal_booking"
                            name="tanggal_booking"
                            value="{{ $tanggalLama }}"
                            required
                        >
                        @error('tanggal_booking')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field">
                        <label for="jam_booking">Jam Servis <i>*</i></label>
                        <input
                            class="bk-input"
                            type="time"
                            id="jam_booking"
                            name="jam_booking"
                            value="{{ $jamLama }}"
                            required
                        >
                        <small class="bk-hint" id="ket_waktu"></small>
                        @error('jam_booking')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="bk-field bk-span">
                        <label for="keluhan">Keluhan / Catatan <i>*</i></label>
                        <textarea
                            class="bk-input"
                            id="keluhan"
                            name="keluhan"
                            rows="4"
                            required
                            placeholder="Ceritakan kendala motor Anda..."
                        >{{ old('keluhan', $booking->keluhan) }}</textarea>
                        @error('keluhan')
                            <small class="bk-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- 4. MEKANIK --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">4</span>
                    <div>
                        <h2>Pilih Mekanik</h2>
                        <p>Pilih mekanik atau biarkan admin yang menentukan.</p>
                    </div>
                </div>

                <div class="bk-mek-grid">
                    <label class="bk-mek">
                        <input
                            type="radio"
                            name="mechanic_id"
                            value=""
                            data-label="Ditentukan admin"
                            @checked($mekanikTerpilih === null || $mekanikTerpilih === '')
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
                                @checked((string) $mekanikTerpilih === (string) $mekanik->id)
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

                @if (($mechanics ?? collect())->count() === 0)
                    <small class="bk-hint">
                        Belum ada mekanik aktif yang bisa dipilih. Mekanik akan ditentukan oleh admin.
                    </small>
                @endif

                @error('mechanic_id')
                    <small class="bk-error">{{ $message }}</small>
                @enderror
            </section>

            {{-- 5. PEMBAYARAN --}}
            <section class="bk-card">
                <div class="bk-card-head">
                    <span class="bk-step">5</span>
                    <div>
                        <h2>Metode Pembayaran</h2>
                        <p>Perbarui metode pembayaran yang akan digunakan.</p>
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
                        >
                            <span
                                class="bk-badge"
                                style="background:{{ $kat['warna'] }};color:#fff"
                            >
                                {{ $kat['badge'] }}
                            </span>
                            <span class="bk-cat-label">{{ $kat['label'] }}</span>
                        </button>
                    @endforeach
                </div>

                @foreach (['ewallet', 'bank'] as $kode)
                    <div
                        class="bk-sub {{ $kode === $kategoriAktif ? '' : 'is-hidden' }}"
                        data-sub="{{ $kode }}"
                    >
                        <span class="bk-sub-title">
                            Pilih {{ $kode === 'ewallet' ? 'e-wallet' : 'bank' }}
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
                                >
                                    {{ $pilihan }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <small class="bk-error is-hidden" id="errBayar">
                    Pilih e-wallet atau bank terlebih dahulu.
                </small>

                @error('metode_pembayaran')
                    <small class="bk-error">{{ $message }}</small>
                @enderror
            </section>

            <div class="bk-actions">
                <a href="{{ route('booking.index') }}" class="bk-btn bk-btn-ghost">
                    Batal
                </a>

                <button type="submit" class="bk-btn bk-btn-primary" id="btnKirim">
                    Simpan Perubahan →
                </button>
            </div>
        </div>

        {{-- RINGKASAN BOOKING --}}
        <aside class="bk-side">
            <div class="bk-summary">
                <h3>Ringkasan Booking</h3>
                <p class="bk-sum-sub">Ringkasan diperbarui sesuai data yang Anda isi.</p>

                <dl>
                    <div><dt>Pemesan</dt><dd id="sumNama">-</dd></div>
                    <div><dt>No. HP</dt><dd id="sumHp">-</dd></div>
                    <div><dt>Motor</dt><dd id="sumMotor">-</dd></div>
                    <div><dt>Nomor polisi</dt><dd id="sumPlat">-</dd></div>
                    <div><dt>Servis</dt><dd id="sumServis">-</dd></div>
                    <div><dt>Jadwal</dt><dd id="sumJadwal">-</dd></div>
                    <div><dt>Mekanik</dt><dd id="sumMekanik">Ditentukan admin</dd></div>
                    <div><dt>Pembayaran</dt><dd id="sumBayar">-</dd></div>
                </dl>

                <div class="bk-note">
                    Periksa kembali perubahan sebelum menyimpannya. Booking akan diperbarui
                    setelah data berhasil diproses.
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
        --bk-text: #14213d;
        --bk-muted: #6b7c99;
        --bk-line: #dce5f1;
        max-width: 1180px;
        margin: 0 auto;
        color: var(--bk-text);
    }

    .bk-page * { box-sizing: border-box; }

    .bk-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .bk-eyebrow {
        display: inline-block;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--bk-blue);
        margin-bottom: 8px;
    }

    .bk-head h1 {
        font-size: 27px;
        line-height: 1.25;
        font-weight: 800;
        margin: 0;
    }

    .bk-head p {
        margin: 6px 0 0;
        font-size: 13px;
        color: var(--bk-muted);
    }

    .bk-alert {
        padding: 14px 16px;
        margin-bottom: 18px;
        border: 1px solid #f4cdd1;
        border-radius: 12px;
        background: #fff0f0;
        color: #a52e3c;
        font-size: 13px;
    }

    .bk-alert ul {
        margin: 8px 0 0;
        padding-left: 20px;
        line-height: 1.8;
    }

    .bk-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 22px;
        align-items: start;
    }

    .bk-main {
        display: flex;
        flex-direction: column;
        gap: 18px;
        min-width: 0;
    }

    .bk-card {
        background: #fff;
        border: 1px solid var(--bk-line);
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 16px #17254108;
        animation: bkUp .4s ease both;
    }

    .bk-card-head {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding-bottom: 16px;
        margin-bottom: 18px;
        border-bottom: 1px solid #e8eef7;
    }

    .bk-step {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: linear-gradient(135deg, #3567d9, #355dbb);
        color: #fff;
        font-size: 14px;
        font-weight: 800;
    }

    .bk-card-head h2 {
        font-size: 16px;
        font-weight: 800;
        margin: 0;
    }

    .bk-card-head p {
        margin: 4px 0 0;
        font-size: 12px;
        color: var(--bk-muted);
        line-height: 1.6;
    }

    .bk-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .bk-span { grid-column: 1 / -1; }
    .bk-field { min-width: 0; }

    .bk-field label {
        display: block;
        margin-bottom: 7px;
        font-size: 12px;
        font-weight: 700;
        color: #2a3a58;
    }

    .bk-field label i {
        font-style: normal;
        color: #d63b4f;
    }

    .bk-input {
        display: block;
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d3deee;
        border-radius: 10px;
        background: #fff;
        color: var(--bk-text);
        font: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .bk-input::placeholder { color: #9aa8c0; }

    .bk-input:focus {
        border-color: var(--bk-blue);
        box-shadow: 0 0 0 4px #3264d816;
    }

    textarea.bk-input {
        resize: vertical;
        min-height: 110px;
        line-height: 1.7;
    }

    .bk-upper { text-transform: uppercase; }
    .bk-upper::placeholder { text-transform: none; }

    .bk-hint {
        display: block;
        margin-top: 7px;
        font-size: 11px;
        color: var(--bk-muted);
        line-height: 1.6;
    }

    .bk-error {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #d63b4f;
    }

    .bk-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .bk-chip {
        padding: 6px 12px;
        border: 1px solid #cddcf6;
        border-radius: 999px;
        background: #f2f7ff;
        color: #2f56b3;
        font: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s, transform .15s;
    }

    .bk-chip:hover { background: #e0ebff; }
    .bk-chip:active { transform: scale(.97); }

    .bk-badge {
        min-width: 42px;
        height: 30px;
        padding: 0 8px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .02em;
    }

    .bk-tick {
        width: 20px;
        height: 20px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: var(--bk-blue);
        color: #fff;
        font-size: 11px;
        opacity: 0;
        transform: scale(.6);
        transition: opacity .15s, transform .15s;
    }

    .bk-mek-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 10px;
    }

    .bk-mek {
        display: block;
        cursor: pointer;
        position: relative;
    }

    .bk-mek input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .bk-mek-box {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1.5px solid #dbe4f1;
        border-radius: 12px;
        background: #fff;
        transition: border-color .18s, background .18s, box-shadow .18s;
    }

    .bk-mek:hover .bk-mek-box {
        border-color: #b9ccec;
        background: #fafcff;
    }

    .bk-mek input:focus-visible + .bk-mek-box {
        box-shadow: 0 0 0 4px #3264d822;
    }

    .bk-mek input:checked + .bk-mek-box {
        border-color: var(--bk-blue);
        background: #eef4ff;
        box-shadow: 0 3px 12px #3264d81f;
    }

    .bk-mek input:checked + .bk-mek-box .bk-tick {
        opacity: 1;
        transform: scale(1);
    }

    .bk-mek-avatar {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #d9e6ff, #9ebcff);
        color: #224c9c;
        font-size: 16px;
        font-weight: 800;
    }

    .bk-mek-any {
        background: #edf1f7;
        color: #6b7c99;
    }

    .bk-mek-info {
        flex: 1;
        min-width: 0;
    }

    .bk-mek-info strong {
        display: block;
        font-size: 13px;
        color: #2a3a58;
        overflow-wrap: anywhere;
    }

    .bk-mek-info small {
        display: block;
        margin-top: 3px;
        font-size: 11px;
        color: var(--bk-muted);
    }

    .bk-cat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
    }

    .bk-cat {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 12px;
        border: 1.5px solid #dbe4f1;
        border-radius: 12px;
        background: #fff;
        cursor: pointer;
        font: inherit;
        text-align: left;
        transition: border-color .18s, background .18s, box-shadow .18s;
    }

    .bk-cat:hover {
        border-color: #b9ccec;
        background: #fafcff;
    }

    .bk-cat.is-active {
        border-color: var(--bk-blue);
        background: #eef4ff;
        box-shadow: 0 3px 12px #3264d81f;
    }

    .bk-cat-label {
        font-size: 13px;
        font-weight: 700;
        color: #2a3a58;
        line-height: 1.3;
    }

    .bk-sub {
        margin-top: 14px;
        padding: 14px;
        border: 1px dashed #cddcf6;
        border-radius: 12px;
        background: #f8fbff;
    }

    .bk-sub-title {
        display: block;
        margin-bottom: 10px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--bk-muted);
    }

    .bk-sub-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .bk-opt {
        padding: 9px 16px;
        border: 1.5px solid #d3deee;
        border-radius: 999px;
        background: #fff;
        color: #2a3a58;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: border-color .15s, background .15s, color .15s;
    }

    .bk-opt:hover { border-color: #9fb9e6; }

    .bk-opt.is-active {
        border-color: var(--bk-blue);
        background: var(--bk-blue);
        color: #fff;
    }

    .is-hidden { display: none !important; }

    .bk-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }

    .bk-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 13px 24px;
        border: 0;
        border-radius: 11px;
        font: inherit;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        transition: background .2s, transform .2s, box-shadow .2s;
    }

    .bk-btn:active { transform: scale(.98); }

    .bk-btn-primary {
        background: var(--bk-blue);
        color: #fff;
        box-shadow: 0 6px 16px #3264d838;
    }

    .bk-btn-primary:hover { background: var(--bk-blue-dark); }

    .bk-btn-ghost {
        background: #fff;
        color: #2a3a58;
        border: 1px solid #d3deee;
    }

    .bk-btn-ghost:hover { background: #f2f6fc; }

    .bk-side {
        position: sticky;
        top: 92px;
    }

    .bk-summary {
        background: #fff;
        border: 1px solid var(--bk-line);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 16px #17254108;
    }

    .bk-summary h3 {
        font-size: 15px;
        font-weight: 800;
        margin: 0;
    }

    .bk-sum-sub {
        margin: 5px 0 14px;
        font-size: 11px;
        color: var(--bk-muted);
    }

    .bk-summary dl { margin: 0; }

    .bk-summary dl > div {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 10px 0;
        border-bottom: 1px dashed #dfe7f3;
        font-size: 12px;
    }

    .bk-summary dt {
        color: var(--bk-muted);
        flex-shrink: 0;
    }

    .bk-summary dd {
        margin: 0;
        text-align: right;
        font-weight: 700;
        color: var(--bk-text);
        overflow-wrap: anywhere;
    }

    .bk-note {
        margin-top: 14px;
        padding: 12px 13px;
        border-radius: 10px;
        background: #eef4ff;
        color: #3f5a8a;
        font-size: 11px;
        line-height: 1.7;
    }

    .bk-foot {
        margin: 22px 0 0;
        text-align: center;
        font-size: 11px;
        color: #97a5bd;
    }

    @keyframes bkUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 1080px) {
        .bk-layout {
            grid-template-columns: minmax(0, 1fr);
        }

        .bk-side {
            position: static;
            order: -1;
        }
    }

    @media (max-width: 700px) {
        .bk-head h1 { font-size: 22px; }

        .bk-card { padding: 16px 14px; }

        .bk-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 15px;
        }

        .bk-span { grid-column: auto; }

        .bk-cat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .bk-actions { flex-direction: column-reverse; }

        .bk-actions .bk-btn { width: 100%; }

        .bk-head > a { width: 100%; }
    }

    @media (prefers-reduced-motion: reduce) {
        .bk-card { animation: none; }
        .bk-page * { transition-duration: .01ms !important; }
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
    const servis = $('jenis_servis');
    const tgl = $('tanggal_booking');
    const jam = $('jam_booking');
    const ket = $('ket_waktu');

    const bayarInput = $('metode_pembayaran');
    const errBayar = $('errBayar');

    function teks(el, nilai) {
        el.textContent = nilai && nilai.trim() ? nilai.trim() : '-';
    }

    function labelWaktu() {
        if (!jam.value) {
            ket.textContent = '';
            return '';
        }

        const j = Number(jam.value.split(':')[0]);
        const waktu = j < 11 ? 'Pagi' : j < 15 ? 'Siang' : j < 18 ? 'Sore' : 'Malam';

        ket.textContent = waktu;
        return waktu;
    }

    function ringkasan() {
        teks($('sumNama'), nama.value);
        teks($('sumHp'), hp.value);
        teks($('sumMotor'), motor.value);
        teks($('sumPlat'), plat.value.toUpperCase());
        teks($('sumServis'), servis.value);

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

        const mekanik = document.querySelector('input[name="mechanic_id"]:checked');

        $('sumMekanik').textContent = mekanik
            ? mekanik.dataset.label
            : 'Ditentukan admin';
    }

    hp.addEventListener('input', function () {
        hp.value = hp.value.replace(/[^0-9+\-\s]/g, '');
    });

    plat.addEventListener('input', function () {
        const posisi = plat.selectionStart;
        plat.value = plat.value.toUpperCase();
        plat.setSelectionRange(posisi, posisi);
    });

    document.querySelectorAll('.bk-chip').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            const saran = tombol.dataset.saran;
            const sekarang = servis.value.trim();

            if (sekarang.toLowerCase().includes(saran.toLowerCase())) {
                return;
            }

            servis.value = sekarang
                ? sekarang + ', ' + saran.toLowerCase()
                : saran;

            servis.dispatchEvent(new Event('input'));
            servis.focus();
        });
    });

    [nama, hp, motor, plat, servis, tgl, jam].forEach(function (elemen) {
        elemen.addEventListener('input', function () {
            labelWaktu();
            ringkasan();
        });

        elemen.addEventListener('change', function () {
            labelWaktu();
            ringkasan();
        });
    });

    function setBayar(nilai, label) {
        bayarInput.value = nilai;
        bayarInput.dataset.label = label;

        errBayar.classList.add('is-hidden');
        ringkasan();
    }

    document.querySelectorAll('.bk-cat').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            document.querySelectorAll('.bk-cat').forEach(function (item) {
                item.classList.toggle('is-active', item === tombol);
            });

            document.querySelectorAll('.bk-sub').forEach(function (panel) {
                panel.classList.toggle(
                    'is-hidden',
                    panel.dataset.sub !== tombol.dataset.kat
                );
            });

            if (tombol.dataset.nilai) {
                document.querySelectorAll('.bk-opt').forEach(function (opsi) {
                    opsi.classList.remove('is-active');
                });

                setBayar(tombol.dataset.nilai, tombol.dataset.label);
            } else {
                const opsiAktif = document.querySelector(
                    '.bk-sub[data-sub="' + tombol.dataset.kat + '"] .bk-opt.is-active'
                );

                if (opsiAktif) {
                    setBayar(opsiAktif.dataset.nilai, opsiAktif.dataset.label);
                } else {
                    bayarInput.value = '';
                    bayarInput.dataset.label = '';
                    ringkasan();
                }
            }
        });
    });

    document.querySelectorAll('.bk-opt').forEach(function (opsi) {
        opsi.addEventListener('click', function () {
            const panel = opsi.closest('.bk-sub');

            panel.querySelectorAll('.bk-opt').forEach(function (item) {
                item.classList.toggle('is-active', item === opsi);
            });

            setBayar(opsi.dataset.nilai, opsi.dataset.label);
        });
    });

    document.querySelectorAll('input[name="mechanic_id"]').forEach(function (radio) {
        radio.addEventListener('change', ringkasan);
    });

    // Menampilkan metode pembayaran yang sudah tersimpan.
    (function () {
        const nilai = bayarInput.value;
        const kategori = document.querySelector('.bk-cat.is-active');

        let label = '';

        if (nilai.startsWith('Transfer ')) {
            label = nilai;
        } else if (nilai === 'QRIS') {
            label = 'QRIS';
        } else if (['OVO', 'GoPay', 'DANA', 'ShopeePay', 'LinkAja'].includes(nilai)) {
            label = nilai;
        } else if (nilai) {
            label = 'Tunai (bayar di kasir)';
        }

        bayarInput.dataset.label = label;

        if (!nilai && kategori && kategori.dataset.nilai) {
            bayarInput.dataset.label = kategori.dataset.label;
        }
    })();

    $('bookingForm').addEventListener('submit', function (event) {
        if (!bayarInput.value) {
            event.preventDefault();

            errBayar.classList.remove('is-hidden');
            errBayar.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            return;
        }

        const tombol = $('btnKirim');

        tombol.disabled = true;
        tombol.style.opacity = '.75';
        tombol.textContent = 'Menyimpan...';
    });

    labelWaktu();
    ringkasan();
})();
</script>
@endpush
@extends('admin.layouts.app')

@section('title', 'Edit Layanan')

@push('styles')
<style>
    .service-form-page {
        max-width: 1100px;
        margin: 0 auto;
        padding-bottom: 30px;
    }

    .service-form-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .service-form-heading h1 {
        margin: 0 0 7px;
        color: #172033;
        font-size: 25px;
        font-weight: 750;
    }

    .service-form-heading p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .service-breadcrumb {
        margin-bottom: 10px;
        color: #64748b;
        font-size: 12px;
    }

    .service-breadcrumb span {
        color: #2563eb;
        font-weight: 600;
    }

    .service-form-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
    }

    .service-panel-heading {
        padding: 22px 25px;
        border-bottom: 1px solid #e5e7eb;
        background: #fafbfc;
    }

    .service-panel-heading h2 {
        margin: 0 0 6px;
        color: #172033;
        font-size: 17px;
        font-weight: 700;
    }

    .service-panel-heading p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    .service-form-body {
        padding: 25px;
    }

    .service-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .service-field {
        display: flex;
        min-width: 0;
        flex-direction: column;
        gap: 8px;
    }

    .service-field-full {
        grid-column: 1 / -1;
    }

    .service-field label {
        color: #334155;
        font-size: 13px;
        font-weight: 650;
    }

    .service-field label .required {
        color: #dc2626;
    }

    .service-input,
    .service-textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d8dee8;
        border-radius: 9px;
        background: #fff;
        padding: 12px 14px;
        color: #172033;
        font: inherit;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
    }

    .service-input:focus,
    .service-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .service-textarea {
        min-height: 115px;
        resize: vertical;
        line-height: 1.6;
    }

    .service-field small {
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .service-field-error {
        color: #dc2626 !important;
        font-size: 12px;
    }

    .service-section-title {
        grid-column: 1 / -1;
        margin: 6px 0 -5px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
        color: #172033;
        font-size: 15px;
        font-weight: 750;
    }

    .service-total-box {
        grid-column: 1 / -1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 19px 21px;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        background: #eff6ff;
    }

    .service-total-label {
        color: #1e40af;
        font-size: 13px;
        font-weight: 650;
    }

    .service-total-note {
        display: block;
        margin-top: 5px;
        color: #64748b;
        font-size: 12px;
        font-weight: 400;
    }

    .service-total-value {
        color: #1d4ed8;
        font-size: 25px;
        font-weight: 800;
        white-space: nowrap;
    }

    .service-form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #e5e7eb;
    }

    .service-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        min-height: 40px;
        box-sizing: border-box;
        padding: 10px 17px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, border-color .2s;
    }

    .service-btn-light {
        border-color: #d8dee8;
        background: #fff;
        color: #475569;
    }

    .service-btn-light:hover {
        background: #f8fafc;
    }

    .service-btn-primary {
        background: #2563eb;
        color: #fff;
    }

    .service-btn-primary:hover {
        background: #1d4ed8;
    }

    .service-alert-error {
        margin-bottom: 20px;
        padding: 15px 18px;
        border: 1px solid #fecaca;
        border-radius: 10px;
        background: #fef2f2;
        color: #991b1b;
        font-size: 13px;
    }

    .service-alert-error ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    @media (max-width: 640px) {
        .service-form-heading h1 {
            font-size: 21px;
        }

        .service-form-body {
            padding: 18px;
        }

        .service-panel-heading {
            padding: 18px;
        }

        .service-form-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 18px;
        }

        .service-field-full,
        .service-section-title,
        .service-total-box {
            grid-column: auto;
        }

        .service-total-box {
            align-items: flex-start;
            flex-direction: column;
            gap: 9px;
        }

        .service-total-value {
            font-size: 23px;
        }

        .service-form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .service-form-actions .service-btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="service-form-page">

    <div class="service-form-heading">
        <div>
            <div class="service-breadcrumb">
                Admin / Data Master / Kelola Layanan / <span>Edit Layanan</span>
            </div>

            <h1>Edit Layanan</h1>
            <p>Perbarui informasi layanan dan rincian harga servis motor.</p>
        </div>

        <a href="{{ route('admin.layanan.index') }}" class="service-btn service-btn-light">
            ← Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="service-alert-error">
            <strong>Data belum bisa disimpan. Periksa kembali:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="service-form-panel">
        <div class="service-panel-heading">
            <h2>Informasi Layanan</h2>
            <p>Ubah data di bawah ini sesuai informasi layanan terbaru.</p>
        </div>

        <div class="service-form-body">
            <form
                action="{{ route('admin.layanan.update', $service->id) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="service-form-grid">

                    <div class="service-field service-field-full">
                        <label for="nama_servis">
                            Nama layanan <span class="required">*</span>
                        </label>

                        <input
                            id="nama_servis"
                            name="nama_servis"
                            type="text"
                            class="service-input"
                            value="{{ old('nama_servis', $service->nama_servis) }}"
                            placeholder="Contoh: Ganti Oli Mesin"
                            maxlength="255"
                            required
                        >

                        @error('nama_servis')
                            <small class="service-field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="service-field service-field-full">
                        <label for="deskripsi">
                            Deskripsi layanan <span class="required">*</span>
                        </label>

                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            class="service-textarea"
                            placeholder="Jelaskan pekerjaan atau layanan yang diberikan..."
                            required
                        >{{ old('deskripsi', $service->deskripsi) }}</textarea>

                        @error('deskripsi')
                            <small class="service-field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <h3 class="service-section-title">Rincian Harga</h3>

                    <div class="service-field">
                        <label for="harga_barang">
                            Harga barang / suku cadang (Rp) <span class="required">*</span>
                        </label>

                        <input
                            id="harga_barang"
                            name="harga_barang"
                            type="number"
                            class="service-input"
                            min="0"
                            step="1"
                            value="{{ old('harga_barang', $service->harga_barang ?? 0) }}"
                            placeholder="0"
                            required
                        >

                        <small>Masukkan harga barang atau suku cadang.</small>

                        @error('harga_barang')
                            <small class="service-field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="service-field">
                        <label for="biaya_jasa">
                            Biaya jasa servis (Rp) <span class="required">*</span>
                        </label>

                        <input
                            id="biaya_jasa"
                            name="biaya_jasa"
                            type="number"
                            class="service-input"
                            min="0"
                            step="1"
                            value="{{ old('biaya_jasa', $service->biaya_jasa ?? 0) }}"
                            placeholder="0"
                            required
                        >

                        <small>Masukkan biaya pengerjaan oleh mekanik.</small>

                        @error('biaya_jasa')
                            <small class="service-field-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="service-total-box">
                        <div>
                            <div class="service-total-label">Total Harga Layanan</div>
                            <span class="service-total-note">
                                Harga barang + biaya jasa servis
                            </span>
                        </div>

                        <div id="totalHargaPreview" class="service-total-value">
                            Rp0
                        </div>
                    </div>

                    <div class="service-field service-field-full">
                        <label for="estimasi_waktu">
                            Estimasi pengerjaan (menit) <span class="required">*</span>
                        </label>

                        <input
                            id="estimasi_waktu"
                            name="estimasi_waktu"
                            type="number"
                            class="service-input"
                            min="1"
                            step="1"
                            value="{{ old('estimasi_waktu', $service->estimasi_waktu) }}"
                            placeholder="Contoh: 30"
                            required
                        >

                        <small>Perkiraan waktu pengerjaan layanan dalam menit.</small>

                        @error('estimasi_waktu')
                            <small class="service-field-error">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="service-form-actions">
                    <a
                        href="{{ route('admin.layanan.index') }}"
                        class="service-btn service-btn-light"
                    >
                        Batal
                    </a>

                    <button type="submit" class="service-btn service-btn-primary">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const barangInput = document.getElementById('harga_barang');
        const jasaInput = document.getElementById('biaya_jasa');
        const totalPreview = document.getElementById('totalHargaPreview');

        if (!barangInput || !jasaInput || !totalPreview) {
            return;
        }

        function updateTotalHarga() {
            const barang = Math.max(0, Number(barangInput.value) || 0);
            const jasa = Math.max(0, Number(jasaInput.value) || 0);
            const total = barang + jasa;

            totalPreview.textContent = 'Rp' + total.toLocaleString('id-ID');
        }

        barangInput.addEventListener('input', updateTotalHarga);
        jasaInput.addEventListener('input', updateTotalHarga);

        updateTotalHarga();
    });
</script>
@endpush
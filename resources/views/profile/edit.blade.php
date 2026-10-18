@extends('layouts.customer')

@section('title', 'Profil Akun - Bengkel Royal Motor')

@push('styles')
<style>
    .pf-page { max-width: 820px; }
    .pf-head { margin-bottom: 20px; }
    .pf-head h1 { font-size: 24px; color: #102143; }
    .pf-head p { margin-top: 6px; font-size: 12px; color: #7182a3; line-height: 1.6; }

    .pf-alert {
        padding: 13px 16px; margin-bottom: 16px; border-radius: 10px;
        font-size: 12px; line-height: 1.7;
        color: #137849; background: #e8f8ef; border: 1px solid #bcebd0;
    }

    .pf-card {
        background: white; border: 1px solid #dce5f1; border-radius: 14px;
        box-shadow: 0 5px 16px #273d630b; padding: 22px; margin-bottom: 18px;
        scroll-margin-top: 90px;
    }
    .pf-card-title {
        display: flex; align-items: center; gap: 12px;
        padding-bottom: 16px; margin-bottom: 18px; border-bottom: 1px solid #e6edf7;
    }
    .pf-icon {
        width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
        background: linear-gradient(135deg, #3468d5, #355eb8); color: white;
        display: flex; align-items: center; justify-content: center;
    }
    .pf-card-title h2 { font-size: 15px; font-weight: 800; }
    .pf-card-title p { margin-top: 5px; font-size: 11px; color: #7890b9; line-height: 1.5; }

    .pf-field { margin-bottom: 15px; }
    .pf-field label { display: block; margin-bottom: 7px; font-size: 11px; font-weight: 700; color: #344765; }
    .pf-input {
        width: 100%; padding: 11px 13px; border: 1px solid #d8e1ed; border-radius: 9px;
        background: #fbfcfe; color: #14213d; font-size: 12px; outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .pf-input:focus { border-color: #3264d8; background: white; box-shadow: 0 0 0 3px #3264d81a; }
    .pf-error { margin-top: 6px; font-size: 11px; color: #d92f4d; }

    .pf-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-top: 6px; }
    .pf-btn {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 11px 18px; border: 0; border-radius: 9px;
        font-size: 12px; font-weight: 700; cursor: pointer;
        transition: background .2s, transform .2s;
    }
    .pf-btn:hover { transform: translateY(-1px); }
    .pf-btn-primary { background: #3264d8; color: white; box-shadow: 0 5px 14px #3264d82b; }
    .pf-btn-primary:hover { background: #244fb5; }
    .pf-btn-danger { background: #ffe7eb; color: #d92f4d; }
    .pf-btn-danger:hover { background: #ffd4db; }

    .pf-photo-row { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; margin-bottom: 16px; }
    .pf-photo {
        width: 92px; height: 92px; border-radius: 50%; overflow: hidden; flex-shrink: 0;
        background: linear-gradient(135deg, #d9e6ff, #9ebcff); color: #224c9c;
        display: flex; align-items: center; justify-content: center;
        font-size: 34px; font-weight: 800; border: 3px solid white; box-shadow: 0 4px 14px #17254126;
    }
    .pf-photo img { width: 100%; height: 100%; object-fit: cover; }
    .pf-hint { font-size: 11px; color: #7182a3; line-height: 1.7; }
    .pf-file { font-size: 12px; max-width: 100%; }

    @media (max-width: 700px) {
        .pf-card { padding: 16px 14px; }
        .pf-head h1 { font-size: 20px; }
    }
</style>
@endpush

@section('content')
@php $user = auth()->user(); @endphp

<div class="pf-page">
    <div class="pf-head">
        <h1>Profil Akun</h1>
        <p>Kelola informasi akun, nomor HP, foto profil, dan keamanan password Anda.</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="pf-alert">✓ Informasi profil berhasil disimpan.</div>
    @endif
    @if (session('status') === 'photo-updated')
        <div class="pf-alert">✓ Foto profil berhasil diperbarui.</div>
    @endif
    @if (session('status') === 'photo-deleted')
        <div class="pf-alert">✓ Foto profil berhasil dihapus.</div>
    @endif
    @if (session('status') === 'password-updated')
        <div class="pf-alert">✓ Password berhasil diganti.</div>
    @endif

    {{-- Informasi profil --}}
    <section id="profile-info" class="pf-card">
        <div class="pf-card-title">
            <div class="pf-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
            </div>
            <div>
                <h2>Informasi Profil</h2>
                <p>Perbarui nama, nomor HP, dan alamat email akun Anda.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="pf-field">
                <label for="name">Nama</label>
                <input id="name" name="name" type="text" class="pf-input"
                       value="{{ old('name', $user->name) }}" required autocomplete="name">
                @error('name') <div class="pf-error">{{ $message }}</div> @enderror
            </div>

            <div class="pf-field">
                <label for="phone">Nomor HP</label>
                <input id="phone" name="phone" type="tel" class="pf-input"
                       value="{{ old('phone', $user->phone) }}"
                       placeholder="Contoh: 081234567890"
                       inputmode="numeric" maxlength="16" autocomplete="tel">
                @error('phone')
                    <div class="pf-error">{{ $message }}</div>
                @else
                    <div class="pf-hint" style="margin-top:6px">Satu nomor HP hanya untuk satu akun.</div>
                @enderror
            </div>

            <div class="pf-field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="pf-input"
                       value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email') <div class="pf-error">{{ $message }}</div> @enderror
            </div>

            <div class="pf-actions">
                <button type="submit" class="pf-btn pf-btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </section>

    {{-- Foto profil --}}
    <section id="profile-photo" class="pf-card">
        <div class="pf-card-title">
            <div class="pf-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <circle cx="9" cy="10" r="2"/><path d="m21 15-5-5L5 20"/>
                </svg>
            </div>
            <div>
                <h2>Foto Profil</h2>
                <p>Foto akan tampil di pojok kanan atas semua halaman.</p>
            </div>
        </div>

        <div class="pf-photo-row">
            <div class="pf-photo" id="photoPreview">
                @if($user->profile_photo_url)
                    <img src="{{ $user->profile_photo_url }}" alt="Foto profil">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            <div class="pf-hint">
                Format JPG, PNG, atau WEBP.<br>
                Ukuran maksimal 2 MB.
            </div>
        </div>

        <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="pf-field">
                <input id="profile_photo" name="profile_photo" type="file" class="pf-file"
                       accept="image/png,image/jpeg,image/webp" required>
                @if($errors->updatePhoto->has('profile_photo'))
                    <div class="pf-error">{{ $errors->updatePhoto->first('profile_photo') }}</div>
                @endif
            </div>

            <div class="pf-actions">
                <button type="submit" class="pf-btn pf-btn-primary">Simpan Foto</button>
            </div>
        </form>

        @if($user->profile_photo)
            <form method="POST" action="{{ route('profile.photo.destroy') }}" style="margin-top:10px">
                @csrf
                @method('DELETE')
                <button type="submit" class="pf-btn pf-btn-danger"
                        onclick="return confirm('Hapus foto profil?')">Hapus Foto</button>
            </form>
        @endif
    </section>

    {{-- Ganti password --}}
    <section id="update-password" class="pf-card">
        <div class="pf-card-title">
            <div class="pf-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="4" y="10" width="16" height="11" rx="2"/>
                    <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                </svg>
            </div>
            <div>
                <h2>Ganti Password</h2>
                <p>Gunakan password yang panjang dan sulit ditebak.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="pf-field">
                <label for="current_password">Password Saat Ini</label>
                <input id="current_password" name="current_password" type="password"
                       class="pf-input" autocomplete="current-password">
                @if($errors->updatePassword->has('current_password'))
                    <div class="pf-error">{{ $errors->updatePassword->first('current_password') }}</div>
                @endif
            </div>

            <div class="pf-field">
                <label for="password">Password Baru</label>
                <input id="password" name="password" type="password"
                       class="pf-input" autocomplete="new-password">
                @if($errors->updatePassword->has('password'))
                    <div class="pf-error">{{ $errors->updatePassword->first('password') }}</div>
                @endif
            </div>

            <div class="pf-field">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                       class="pf-input" autocomplete="new-password">
            </div>

            <div class="pf-actions">
                <button type="submit" class="pf-btn pf-btn-primary">Simpan Password</button>
            </div>
        </form>
    </section>

</div>
@endsection

@push('scripts')
<script>
    const fotoInput = document.getElementById('profile_photo');
    const fotoPreview = document.getElementById('photoPreview');

    if (fotoInput && fotoPreview) {
        fotoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                fotoPreview.innerHTML = '<img src="' + e.target.result + '" alt="Pratinjau">';
            };
            reader.readAsDataURL(file);
        });
    }

    // Nomor HP: hanya angka dan tanda +
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function () {
            phoneInput.value = phoneInput.value.replace(/[^0-9+]/g, '');
        });
    }
</script>
@endpush
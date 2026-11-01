
<section class="sk-account-form">

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- NAME --}}
        <div class="sk-form-group">
            <label for="name" class="sk-form-label">Nama Lengkap</label>

            <input
                id="name"
                name="name"
                type="text"
                class="sk-form-input"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Masukkan nama lengkap"
            >

            @error('name')
                <p class="sk-form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div class="sk-form-group">
            <label for="email" class="sk-form-label">Alamat Email</label>

            <input
                id="email"
                name="email"
                type="email"
                class="sk-form-input"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                placeholder="nama@email.com"
            >

            @error('email')
                <p class="sk-form-error">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="sk-verification-box">
                    <div class="sk-verification-indicator">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 8v4"/>
                            <path d="M12 16h.01"/>
                        </svg>
                    </div>

                    <div class="sk-verification-content">
                        <p class="sk-verification-title">Email belum diverifikasi</p>
                        <p class="sk-verification-description">
                            Verifikasi alamat email untuk memastikan akun Anda tetap aman.
                        </p>

                        <button
                            form="send-verification"
                            type="submit"
                            class="sk-verification-button"
                        >
                            Kirim ulang email verifikasi
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <p class="sk-verification-success">
                                Email verifikasi baru berhasil dikirim.
                            </p>
                        @endif
                    </div>
                </div>
            @else
                <div class="sk-email-verified">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                    Email sudah terverifikasi
                </div>
            @endif
        </div>

        {{-- SAVE BUTTON --}}
        <div class="sk-form-actions">
            <button type="submit" class="sk-save-button">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/>
                    <path d="M17 21v-8H7v8"/>
                    <path d="M7 3v5h8"/>
                </svg>
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <span
                    class="sk-save-success"
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                    Perubahan berhasil disimpan.
                </span>
            @endif
        </div>
    </form>

    <style>
        .sk-account-form {
            width: 100%;
            font-family: 'Manrope', sans-serif;
        }

        .sk-account-form .sk-form-group {
            margin-bottom: 23px;
        }

        .sk-account-form .sk-form-label {
            display: block;
            margin-bottom: 9px;
            color: #684936;
            font-size: 12px;
            font-weight: 800;
        }

        .sk-account-form .sk-form-input {
            display: block;
            width: 100%;
            min-height: 46px;
            padding: 11px 14px;
            border: 1px solid #E9DED3;
            border-radius: 10px;
            outline: none;
            background: #FCFAF7;
            color: #493A30;
            font-family: 'Manrope', sans-serif;
            font-size: 13px;
            transition: border-color .2s, box-shadow .2s;
        }

        .sk-account-form .sk-form-input::placeholder {
            color: #B6A99D;
        }

        .sk-account-form .sk-form-input:focus {
            border-color: #A9876C;
            box-shadow: 0 0 0 3px rgba(181, 139, 107, .12);
        }

        .sk-account-form .sk-form-error {
            margin-top: 7px;
            color: #B4534B;
            font-size: 11px;
        }

        .sk-verification-box {
            display: flex;
            gap: 12px;
            padding: 15px;
            margin-top: 14px;
            border: 1px solid #EADCCB;
            border-radius: 11px;
            background: #FBF6EF;
        }

        .sk-verification-indicator {
            display: flex;
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #F0E3D3;
            color: #8B654D;
        }

        .sk-verification-indicator svg {
            width: 18px;
            height: 18px;
        }

        .sk-verification-title {
            margin: 0;
            color: #684936;
            font-size: 12px;
            font-weight: 800;
        }

        .sk-verification-description {
            margin: 5px 0 10px;
            color: #99877A;
            font-size: 11px;
            line-height: 1.6;
        }

        .sk-verification-button {
            padding: 0;
            border: none;
            background: transparent;
            color: #79583F;
            font-size: 11px;
            font-weight: 800;
            text-decoration: underline;
            cursor: pointer;
        }

        .sk-verification-success {
            display: block;
            margin-top: 9px;
            color: #528064;
            font-size: 11px;
            font-weight: 700;
        }

        .sk-email-verified {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 10px;
            color: #528064;
            font-size: 11px;
            font-weight: 700;
        }

        .sk-email-verified svg {
            width: 15px;
            height: 15px;
        }

        .sk-form-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
            padding-top: 5px;
        }

        .sk-save-button {
            display: inline-flex;
            min-height: 43px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 11px 19px;
            border: none;
            border-radius: 9px;
            background: #684936;
            color: #fff;
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: background .2s, transform .2s;
        }

        .sk-save-button:hover {
            background: #493126;
            transform: translateY(-1px);
        }

        .sk-save-button svg {
            width: 16px;
            height: 16px;
        }

        .sk-save-success {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #528064;
            font-size: 11px;
            font-weight: 700;
        }

        .sk-save-success svg {
            width: 15px;
            height: 15px;
        }

        @media (max-width: 480px) {
            .sk-form-actions {
                align-items: flex-start;
                flex-direction: column;
            }

            .sk-save-button {
                width: 100%;
            }
        }
    </style>
</section>

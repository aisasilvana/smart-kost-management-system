
<section class="sk-password-form">

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        {{-- CURRENT PASSWORD --}}
        <div class="sk-password-group">
            <label for="update_password_current_password" class="sk-password-label">
                Password Saat Ini
            </label>

            <div class="sk-password-input-wrapper">
                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="sk-password-input"
                    autocomplete="current-password"
                    placeholder="Masukkan password saat ini"
                >

                <button type="button" class="sk-password-toggle"
                    onclick="toggleSkPassword('update_password_current_password', this)"
                    aria-label="Tampilkan password">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            @if ($errors->updatePassword->has('current_password'))
                <p class="sk-password-error">
                    {{ $errors->updatePassword->first('current_password') }}
                </p>
            @endif
        </div>

        {{-- NEW PASSWORD --}}
        <div class="sk-password-group">
            <label for="update_password_password" class="sk-password-label">
                Password Baru
            </label>

            <div class="sk-password-input-wrapper">
                <input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="sk-password-input"
                    autocomplete="new-password"
                    placeholder="Masukkan password baru"
                >

                <button type="button" class="sk-password-toggle"
                    onclick="toggleSkPassword('update_password_password', this)"
                    aria-label="Tampilkan password">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            @if ($errors->updatePassword->has('password'))
                <p class="sk-password-error">
                    {{ $errors->updatePassword->first('password') }}
                </p>
            @endif

            <p class="sk-password-hint">
                Gunakan password yang kuat dan tidak mudah ditebak.
            </p>
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div class="sk-password-group">
            <label for="update_password_password_confirmation" class="sk-password-label">
                Konfirmasi Password Baru
            </label>

            <div class="sk-password-input-wrapper">
                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="sk-password-input"
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                >

                <button type="button" class="sk-password-toggle"
                    onclick="toggleSkPassword('update_password_password_confirmation', this)"
                    aria-label="Tampilkan password">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            @if ($errors->updatePassword->has('password_confirmation'))
                <p class="sk-password-error">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </p>
            @endif
        </div>

        {{-- ACTION --}}
        <div class="sk-password-actions">
            <button type="submit" class="sk-password-save">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/>
                    <path d="M17 21v-8H7v8"/>
                    <path d="M7 3v5h8"/>
                </svg>
                Perbarui Password
            </button>

            @if (session('status') === 'password-updated')
                <span
                    class="sk-password-success"
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                    Password berhasil diperbarui.
                </span>
            @endif
        </div>
    </form>

    <style>
        .sk-password-form {
            width: 100%;
            font-family: 'Manrope', sans-serif;
        }

        .sk-password-group {
            margin-bottom: 23px;
        }

        .sk-password-label {
            display: block;
            margin-bottom: 9px;
            color: #684936;
            font-size: 12px;
            font-weight: 800;
        }

        .sk-password-input-wrapper {
            position: relative;
        }

        .sk-password-input {
            display: block;
            width: 100%;
            min-height: 46px;
            padding: 11px 48px 11px 14px;
            border: 1px solid #E9DED3;
            border-radius: 10px;
            outline: none;
            background: #FCFAF7;
            color: #493A30;
            font-family: 'Manrope', sans-serif;
            font-size: 13px;
            transition: border-color .2s, box-shadow .2s;
        }

        .sk-password-input::placeholder {
            color: #B6A99D;
        }

        .sk-password-input:focus {
            border-color: #A9876C;
            box-shadow: 0 0 0 3px rgba(181, 139, 107, .12);
        }

        .sk-password-toggle {
            position: absolute;
            top: 50%;
            right: 13px;
            display: flex;
            width: 25px;
            height: 25px;
            align-items: center;
            justify-content: center;
            padding: 0;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #A18D7C;
            cursor: pointer;
        }

        .sk-password-toggle:hover {
            background: transparent;
            color: #684936;
            transform: translateY(-50%);
        }

        .sk-password-toggle svg {
            width: 18px;
            height: 18px;
        }

        .sk-password-error {
            margin-top: 7px;
            color: #B4534B;
            font-size: 11px;
        }

        .sk-password-hint {
            margin-top: 8px;
            color: #A18F80;
            font-size: 10px;
        }

        .sk-password-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
            padding-top: 5px;
        }

        .sk-password-save {
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

        .sk-password-save:hover {
            background: #493126;
            transform: translateY(-1px);
        }

        .sk-password-save svg {
            width: 16px;
            height: 16px;
        }

        .sk-password-success {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #528064;
            font-size: 11px;
            font-weight: 700;
        }

        .sk-password-success svg {
            width: 15px;
            height: 15px;
        }

        @media (max-width: 480px) {
            .sk-password-actions {
                align-items: flex-start;
                flex-direction: column;
            }

            .sk-password-save {
                width: 100%;
            }
        }
    </style>

    <script>
        function toggleSkPassword(inputId, button) {
            const input = document.getElementById(inputId);

            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            button.setAttribute(
                'aria-label',
                isPassword ? 'Sembunyikan password' : 'Tampilkan password'
            );
        }
    </script>
</section>

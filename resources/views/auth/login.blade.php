
<x-guest-layout>
    <div class="login-page">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');

            .login-page {
                font-family: 'Manrope', sans-serif;
                color: #493A30;
                width: 100%;
            }

            .login-wrapper {
                width: 100%;
                max-width: 440px;
                margin: 0 auto;
                padding: 24px;
            }

            .login-brand {
                text-align: center;
                margin-bottom: 34px;
            }

            .login-logo {
                font-size: 34px;
                font-weight: 800;
                letter-spacing: -2px;
                color: #493126;
                line-height: 1.2;
            }

            .login-logo span {
                color: #B58B6B;
            }

            .login-brand p {
                margin-top: 10px;
                color: #99877A;
                font-size: 13px;
            }

            .login-card {
                background: #FFFFFF;
                border: 1px solid #E9DED3;
                border-radius: 18px;
                padding: 34px;
                box-shadow: 0 12px 35px rgba(73, 49, 38, 0.06);
            }

            .login-heading {
                margin-bottom: 27px;
            }

            .login-heading h1 {
                font-size: 25px;
                font-weight: 800;
                letter-spacing: -0.8px;
                color: #493126;
                margin-bottom: 8px;
            }

            .login-heading p {
                font-size: 13px;
                color: #99877A;
                line-height: 1.7;
            }

            .login-field {
                margin-bottom: 20px;
            }

            .login-label {
                display: block;
                font-size: 12px;
                font-weight: 700;
                color: #684936;
                margin-bottom: 9px;
            }

            .login-input {
                width: 100%;
                height: 48px;
                border: 1px solid #E9DED3;
                border-radius: 9px;
                background: #FDFBF8;
                padding: 0 14px;
                color: #493A30;
                font-family: 'Manrope', sans-serif;
                font-size: 13px;
                outline: none;
                transition: 0.2s ease;
            }

            .login-input:focus {
                border-color: #8B654D;
                background: #FFFFFF;
                box-shadow: 0 0 0 3px rgba(139, 101, 77, 0.10);
            }

            .login-input::placeholder {
                color: #B5A69A;
            }

            .login-error {
                color: #C45B50;
                font-size: 11px;
                margin-top: 7px;
            }

            .login-options {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin: 5px 0 25px;
            }

            .remember-label {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #817064;
                font-size: 12px;
                cursor: pointer;
            }

            .remember-label input {
                width: 15px;
                height: 15px;
                accent-color: #684936;
                border-radius: 4px;
            }

            .forgot-link {
                font-size: 11px;
                font-weight: 700;
                color: #8B654D;
                text-decoration: none;
            }

            .forgot-link:hover {
                color: #493126;
                text-decoration: underline;
            }

            .login-button {
                width: 100%;
                height: 49px;
                border: none;
                border-radius: 9px;
                background: #684936;
                color: #FFFFFF;
                font-family: 'Manrope', sans-serif;
                font-size: 13px;
                font-weight: 800;
                cursor: pointer;
                transition: 0.2s ease;
            }

            .login-button:hover {
                background: #493126;
                transform: translateY(-1px);
                box-shadow: 0 7px 16px rgba(73, 49, 38, 0.15);
            }

            .login-button:active {
                transform: translateY(0);
            }

            .login-divider {
                height: 1px;
                background: #F0E8E0;
                margin: 25px 0 20px;
            }

            .login-footer {
                text-align: center;
                font-size: 11px;
                color: #A39488;
                line-height: 1.8;
            }

            .login-footer strong {
                color: #684936;
                font-weight: 800;
            }

            .login-alert {
                background: #F4F8F1;
                border: 1px solid #DCE9D5;
                color: #527447;
                border-radius: 8px;
                padding: 11px 13px;
                font-size: 12px;
                margin-bottom: 20px;
            }

            @media (max-width: 480px) {
                .login-wrapper {
                    padding: 16px;
                }

                .login-card {
                    padding: 25px 21px;
                }

                .login-heading h1 {
                    font-size: 23px;
                }

                .login-options {
                    align-items: flex-start;
                }
            }
        </style>

        <div class="login-wrapper">
            <div class="login-brand">
                <div class="login-logo">smartkost<span>.</span></div>
                <p>Smart management for better living.</p>
            </div>

            <div class="login-card">
                <div class="login-heading">
                    <h1>Selamat Datang!</h1>
                    <p>Masuk ke akun Smart Kost untuk mengelola hunian dan aktivitas kost Anda.</p>
                </div>

                <x-auth-session-status class="login-alert" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="login-field">
                        <label for="email" class="login-label">Alamat Email</label>
                        <input
                            id="email"
                            class="login-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            autofocus
                            autocomplete="username"
                        >

                        @if ($errors->get('email'))
                            <div class="login-error">
                                @foreach ($errors->get('email') as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="login-field">
                        <label for="password" class="login-label">Password</label>
                        <input
                            id="password"
                            class="login-input"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password"
                        >

                        @if ($errors->get('password'))
                            <div class="login-error">
                                @foreach ($errors->get('password') as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="login-options">
                        <label for="remember_me" class="remember-label">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                            >
                            <span>Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="login-button">
                        Masuk ke Akun
                    </button>
                </form>

                <div class="login-divider"></div>

                <div class="login-footer">
                    <strong>smartkost.</strong><br>
                    Platform manajemen kost yang praktis dan terintegrasi.
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>


<x-guest-layout>
    <div class="register-page">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap');

            .register-page {
                font-family: 'Manrope', sans-serif;
                color: #493A30;
                width: 100%;
            }

            .register-wrapper {
                width: 100%;
                max-width: 460px;
                margin: 0 auto;
                padding: 24px;
            }

            .register-brand {
                text-align: center;
                margin-bottom: 30px;
            }

            .register-logo {
                font-size: 34px;
                font-weight: 800;
                letter-spacing: -2px;
                color: #493126;
                line-height: 1.2;
            }

            .register-logo span {
                color: #B58B6B;
            }

            .register-brand p {
                margin-top: 10px;
                color: #99877A;
                font-size: 13px;
            }

            .register-card {
                background: #FFFFFF;
                border: 1px solid #E9DED3;
                border-radius: 18px;
                padding: 32px;
                box-shadow: 0 12px 35px rgba(73, 49, 38, 0.06);
            }

            .register-heading {
                margin-bottom: 25px;
            }

            .register-heading h1 {
                font-size: 25px;
                font-weight: 800;
                letter-spacing: -0.8px;
                color: #493126;
                margin-bottom: 8px;
            }

            .register-heading p {
                font-size: 13px;
                color: #99877A;
                line-height: 1.7;
            }

            .register-field {
                margin-bottom: 18px;
            }

            .register-label {
                display: block;
                font-size: 12px;
                font-weight: 700;
                color: #684936;
                margin-bottom: 9px;
            }

            .register-input {
                width: 100%;
                height: 47px;
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

            .register-input:focus {
                border-color: #8B654D;
                background: #FFFFFF;
                box-shadow: 0 0 0 3px rgba(139, 101, 77, 0.10);
            }

            .register-input::placeholder {
                color: #B5A69A;
            }

            .register-error {
                color: #C45B50;
                font-size: 11px;
                margin-top: 7px;
            }

            .register-button {
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

            .register-button:hover {
                background: #493126;
                transform: translateY(-1px);
                box-shadow: 0 7px 16px rgba(73, 49, 38, 0.15);
            }

            .register-button:active {
                transform: translateY(0);
            }

            .register-login {
                text-align: center;
                margin-top: 22px;
                font-size: 12px;
                color: #99877A;
            }

            .register-login a {
                color: #8B654D;
                font-weight: 800;
                text-decoration: none;
                margin-left: 4px;
            }

            .register-login a:hover {
                color: #493126;
                text-decoration: underline;
            }

            .register-divider {
                height: 1px;
                background: #F0E8E0;
                margin: 24px 0 18px;
            }

            .register-footer {
                text-align: center;
                font-size: 11px;
                color: #A39488;
                line-height: 1.8;
            }

            .register-footer strong {
                color: #684936;
                font-weight: 800;
            }

            @media (max-width: 480px) {
                .register-wrapper {
                    padding: 16px;
                }

                .register-card {
                    padding: 25px 21px;
                }

                .register-heading h1 {
                    font-size: 23px;
                }
            }
        </style>

        <div class="register-wrapper">
            <div class="register-brand">
                <div class="register-logo">smartkost<span>.</span></div>
                <p>Smart management for better living.</p>
            </div>

            <div class="register-card">
                <div class="register-heading">
                    <h1>Buat Akun Baru</h1>
                    <p>Daftarkan akun Anda untuk mulai menggunakan platform Smart Kost.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="register-field">
                        <label for="name" class="register-label">Nama Lengkap</label>
                        <input
                            id="name"
                            class="register-input"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            autofocus
                            autocomplete="name"
                        >

                        @if ($errors->get('name'))
                            <div class="register-error">
                                @foreach ($errors->get('name') as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="register-field">
                        <label for="email" class="register-label">Alamat Email</label>
                        <input
                            id="email"
                            class="register-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            autocomplete="username"
                        >

                        @if ($errors->get('email'))
                            <div class="register-error">
                                @foreach ($errors->get('email') as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="register-field">
                        <label for="password" class="register-label">Password</label>
                        <input
                            id="password"
                            class="register-input"
                            type="password"
                            name="password"
                            placeholder="Buat password"
                            required
                            autocomplete="new-password"
                        >

                        @if ($errors->get('password'))
                            <div class="register-error">
                                @foreach ($errors->get('password') as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="register-field">
                        <label for="password_confirmation" class="register-label">
                            Konfirmasi Password
                        </label>
                        <input
                            id="password_confirmation"
                            class="register-input"
                            type="password"
                            name="password_confirmation"
                            placeholder="Masukkan ulang password"
                            required
                            autocomplete="new-password"
                        >

                        @if ($errors->get('password_confirmation'))
                            <div class="register-error">
                                @foreach ($errors->get('password_confirmation') as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="register-button">
                        Buat Akun
                    </button>
                </form>

                <div class="register-login">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}">Masuk di sini</a>
                </div>

                <div class="register-divider"></div>

                <div class="register-footer">
                    <strong>smartkost.</strong><br>
                    Platform manajemen kost yang praktis dan terintegrasi.
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

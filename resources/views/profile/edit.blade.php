
<x-app-layout>
    <div class="sk-profile-page">
        <div class="sk-profile-container">

            {{-- PAGE HEADER --}}
            <div class="sk-profile-heading">
                <div>
                    <span class="sk-profile-eyebrow">ACCOUNT SETTINGS</span>
                    <h1>Pengaturan Profil</h1>
                    <p>Kelola informasi akun dan keamanan profil Smartkost Anda.</p>
                </div>

                <div class="sk-profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            </div>

            {{-- PROFILE OVERVIEW --}}
            <div class="sk-profile-overview">
                <div class="sk-profile-overview-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M5 21a7 7 0 0 1 14 0"/>
                    </svg>
                </div>

                <div class="sk-profile-overview-content">
                    <span>Profil Anda</span>
                    <h2>{{ auth()->user()->name }}</h2>
                    <p>{{ auth()->user()->email }}</p>
                </div>

                <div class="sk-profile-role">
                    {{ ucfirst(auth()->user()->role ?? 'User') }}
                </div>
            </div>

            {{-- PROFILE INFORMATION --}}
            <section class="sk-profile-section">
                <div class="sk-profile-section-heading">
                    <div class="sk-profile-section-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"/>
                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                        </svg>
                    </div>
                    <div>
                        <h2>Informasi Profil</h2>
                        <p>Perbarui nama dan alamat email akun Anda.</p>
                    </div>
                </div>

                <div class="sk-profile-form">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </section>

            {{-- PASSWORD --}}
            <section class="sk-profile-section">
                <div class="sk-profile-section-heading">
                    <div class="sk-profile-section-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            <circle cx="12" cy="16" r="1"/>
                        </svg>
                    </div>
                    <div>
                        <h2>Keamanan Password</h2>
                        <p>Gunakan password yang kuat untuk menjaga keamanan akun.</p>
                    </div>
                </div>

                <div class="sk-profile-form">
                    @include('profile.partials.update-password-form')
                </div>
            </section>

            {{-- DELETE ACCOUNT --}}
            <section class="sk-profile-section sk-profile-danger">
                <div class="sk-profile-section-heading">
                    <div class="sk-profile-section-icon sk-profile-danger-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"/>
                            <path d="M8 6V4h8v2"/>
                            <path d="m19 6-1 14H6L5 6"/>
                            <path d="M10 11v5M14 11v5"/>
                        </svg>
                    </div>
                    <div>
                        <h2>Hapus Akun</h2>
                        <p>Kelola penghapusan akun Smartkost Anda.</p>
                    </div>
                </div>

                <div class="sk-profile-form">
                    @include('profile.partials.delete-user-form')
                </div>
            </section>

            <div class="sk-profile-footer">
                <span>smartkost.</span>
                <p>Manage your account, stay in control.</p>
            </div>

        </div>
    </div>

    <style>
        .sk-profile-page {
            min-height: 100vh;
            padding: 42px 24px 60px;
            background: #F7F2EB;
            color: #493A30;
            font-family: 'Manrope', sans-serif;
        }

        .sk-profile-container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .sk-profile-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            margin-bottom: 28px;
        }

        .sk-profile-eyebrow {
            display: block;
            margin-bottom: 10px;
            color: #A1846D;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .sk-profile-heading h1 {
            margin: 0;
            color: #493126;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .sk-profile-heading p {
            margin: 8px 0 0;
            color: #99877A;
            font-size: 13px;
        }

        .sk-profile-avatar {
            display: flex;
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: #684936;
            color: #fff;
            font-size: 23px;
            font-weight: 800;
        }

        .sk-profile-overview {
            display: flex;
            align-items: center;
            gap: 17px;
            padding: 24px;
            margin-bottom: 25px;
            border: 1px solid #E9DED3;
            border-radius: 17px;
            background: #fff;
        }

        .sk-profile-overview-icon,
        .sk-profile-section-icon {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            background: #F3EAE0;
            color: #79583F;
        }

        .sk-profile-overview-icon {
            width: 52px;
            height: 52px;
            border-radius: 15px;
        }

        .sk-profile-overview-icon svg {
            width: 24px;
            height: 24px;
        }

        .sk-profile-overview-content {
            min-width: 0;
        }

        .sk-profile-overview-content span {
            color: #A1846D;
            font-size: 11px;
            font-weight: 700;
        }

        .sk-profile-overview-content h2 {
            margin: 3px 0;
            color: #493126;
            font-size: 17px;
            font-weight: 800;
        }

        .sk-profile-overview-content p {
            margin: 0;
            color: #99877A;
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .sk-profile-role {
            margin-left: auto;
            padding: 7px 13px;
            border-radius: 20px;
            background: #F3EAE0;
            color: #79583F;
            font-size: 11px;
            font-weight: 800;
        }

        .sk-profile-section {
            padding: 27px;
            margin-bottom: 22px;
            border: 1px solid #E9DED3;
            border-radius: 17px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(73, 49, 38, .025);
        }

        .sk-profile-section-heading {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 22px;
            margin-bottom: 23px;
            border-bottom: 1px solid #F0E8E0;
        }

        .sk-profile-section-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
        }

        .sk-profile-section-icon svg {
            width: 20px;
            height: 20px;
        }

        .sk-profile-section-heading h2 {
            margin: 0;
            color: #493126;
            font-size: 15px;
            font-weight: 800;
        }

        .sk-profile-section-heading p {
            margin: 5px 0 0;
            color: #99877A;
            font-size: 11px;
        }

        .sk-profile-form {
            max-width: 680px;
        }

        .sk-profile-form h2 {
            color: #493126;
        }

        .sk-profile-form p {
            color: #99877A;
        }

        .sk-profile-form label {
            color: #684936;
            font-size: 12px;
            font-weight: 700;
        }

        .sk-profile-form input:not([type="checkbox"]),
        .sk-profile-form select,
        .sk-profile-form textarea {
            width: 100%;
            border: 1px solid #E9DED3;
            border-radius: 9px;
            background: #FCFAF7;
            color: #493A30;
            font-size: 13px;
            box-shadow: none;
        }

        .sk-profile-form input:not([type="checkbox"]) {
            min-height: 43px;
            padding: 10px 13px;
        }

        .sk-profile-form input:focus,
        .sk-profile-form select:focus,
        .sk-profile-form textarea:focus {
            border-color: #A9876C;
            outline: none;
            box-shadow: 0 0 0 3px rgba(181, 139, 107, .12);
        }

        .sk-profile-form button,
        .sk-profile-form [type="submit"] {
            min-height: 39px;
            padding: 9px 18px;
            border: none;
            border-radius: 9px;
            background: #684936;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            transition: background .2s ease, transform .2s ease;
        }

        .sk-profile-form button:hover,
        .sk-profile-form [type="submit"]:hover {
            background: #493126;
            transform: translateY(-1px);
        }

        .sk-profile-danger {
            border-color: #EBDDD5;
        }

        .sk-profile-danger-icon {
            background: #F9ECE8;
            color: #A65D4E;
        }

        .sk-profile-danger .sk-profile-form button,
        .sk-profile-danger .sk-profile-form [type="submit"] {
            background: #A65D4E;
        }

        .sk-profile-danger .sk-profile-form button:hover,
        .sk-profile-danger .sk-profile-form [type="submit"]:hover {
            background: #874638;
        }

        .sk-profile-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 20px 3px 0;
        }

        .sk-profile-footer span {
            color: #684936;
            font-family: 'DM Sans', sans-serif;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .sk-profile-footer p {
            margin: 0;
            color: #A99A8D;
            font-size: 10px;
        }

        @media (max-width: 640px) {
            .sk-profile-page {
                padding: 28px 15px 45px;
            }

            .sk-profile-heading h1 {
                font-size: 24px;
            }

            .sk-profile-section {
                padding: 20px 17px;
            }

            .sk-profile-overview {
                padding: 18px;
            }

            .sk-profile-role {
                font-size: 10px;
            }

            .sk-profile-footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</x-app-layout>

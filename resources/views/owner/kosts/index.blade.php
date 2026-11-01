<x-app-layout>
    <div class="sk-page">
        <div class="sk-container">

            {{-- PAGE HEADER --}}
            <div class="sk-page-heading">
                <div>
                    <div class="sk-eyebrow sk-page-eyebrow">
                        PROPERTY MANAGEMENT
                    </div>

                    <h1 class="sk-section-heading sk-page-title">
                        Properti Kost Saya
                    </h1>

                    <p class="sk-section-description">
                        Kelola semua properti kost Anda dalam satu tempat.
                    </p>
                </div>

                <a href="{{ route('owner.kosts.create') }}" class="sk-btn">
                    <span>+</span> Tambah Properti
                </a>
            </div>

            {{-- WELCOME BANNER --}}
            <section class="sk-property-banner">
                <div class="sk-property-banner-content">
                    <div class="sk-property-banner-label">
                        YOUR PROPERTY, YOUR CARE
                    </div>

                    <h2>
                        Tempat nyaman dimulai dari
                        pengelolaan yang baik.
                    </h2>

                    <p>
                        Pantau dan kelola informasi setiap properti kost Anda
                        dengan lebih mudah melalui Smart Kost.
                    </p>
                </div>

                <div class="sk-property-banner-icon">
                    <svg viewBox="0 0 100 100" aria-hidden="true">
                        <path d="M12 45 50 13l38 32"></path>
                        <path d="M22 40v47h56V40"></path>
                        <path d="M40 87V58h20v29"></path>
                        <path d="M30 51h10M60 51h10"></path>
                        <path d="M45 30h10"></path>
                    </svg>
                </div>
            </section>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="sk-alert sk-alert-success">
                    <span class="sk-alert-icon">✓</span>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if($errors->any())
                <div class="sk-alert sk-alert-error">
                    <span class="sk-alert-icon">!</span>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- PROPERTY SUMMARY --}}
            <section class="sk-property-summary">

                <div class="sk-property-summary-card">
                    <div class="sk-property-summary-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 10.5 12 3l9 7.5"></path>
                            <path d="M5.5 9.5V21h13V9.5"></path>
                            <path d="M9 21v-7h6v7"></path>
                        </svg>
                    </div>

                    <div>
                        <div class="sk-property-summary-number">
                            {{ $kosts->count() }}
                        </div>
                        <div class="sk-property-summary-label">
                            Total Properti Kost
                        </div>
                    </div>
                </div>

                <div class="sk-property-summary-card">
                    <div class="sk-property-summary-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="4" y="4" width="16" height="16" rx="1"></rect>
                            <path d="M4 9h16M4 14h16M9 4v16M14 4v16"></path>
                        </svg>
                    </div>

                    <div>
                        <div class="sk-property-summary-number">
                            {{ $kosts->sum(fn($kost) => $kost->rooms->count()) }}
                        </div>
                        <div class="sk-property-summary-label">
                            Total Kamar
                        </div>
                    </div>
                </div>

            </section>

            {{-- PROPERTY LIST HEADER --}}
            <div class="sk-property-list-header">
                <div>
                    <h2 class="sk-section-heading">
                        Daftar Properti
                    </h2>

                    <p class="sk-section-description">
                        Semua kost yang terdaftar pada akun Anda.
                    </p>
                </div>

                <span class="sk-property-count">
                    {{ $kosts->count() }} Properti
                </span>
            </div>

            {{-- PROPERTY CARDS --}}
            @forelse($kosts as $kost)

                <article class="sk-property-card">

                    <div class="sk-property-card-main">

                        {{-- PROPERTY ICON --}}
                        <div class="sk-property-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 10.5 12 3l9 7.5"></path>
                                <path d="M5.5 9.5V21h13V9.5"></path>
                                <path d="M9 21v-7h6v7"></path>
                                <path d="M8 11h.01M16 11h.01"></path>
                            </svg>
                        </div>

                        {{-- PROPERTY INFORMATION --}}
                        <div class="sk-property-information">

                            <div class="sk-property-name-row">
                                <h3>{{ $kost->name }}</h3>

                                <span class="sk-property-status">
                                    Terdaftar
                                </span>
                            </div>

                            <div class="sk-property-address">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"></path>
                                    <circle cx="12" cy="10" r="2.5"></circle>
                                </svg>

                                <span>{{ $kost->address }}</span>
                            </div>

                            <p class="sk-property-description">
                                {{ $kost->description ?: 'Belum ada deskripsi properti.' }}
                            </p>

                        </div>

                        {{-- ROOM SUMMARY --}}
                        <div class="sk-property-room-box">
                            <div class="sk-property-room-label">
                                Total Kamar
                            </div>

                            <div class="sk-property-room-number">
                                {{ $kost->rooms->count() }}
                            </div>

                            <div class="sk-property-room-caption">
                                Kamar terdaftar
                            </div>
                        </div>

                    </div>

                    {{-- PROPERTY ACTIONS --}}
                    <div class="sk-property-actions">

                        <a href="{{ route('owner.kosts.rooms.index', $kost->id) }}"
                           class="sk-property-action sk-property-action-primary">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="4" y="4" width="16" height="16" rx="1"></rect>
                                <path d="M4 9h16M4 14h16"></path>
                            </svg>
                            Kelola Kamar
                            <span>→</span>
                        </a>

                        <a href="{{ route('owner.kosts.edit', $kost->id) }}"
                           class="sk-property-action sk-property-action-edit">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m14 5 5 5"></path>
                                <path d="M4 20h4l11-11a2.1 2.1 0 0 0-4-4L4 16v4Z"></path>
                            </svg>
                            Edit Properti
                        </a>

                        <form action="{{ route('owner.kosts.destroy', $kost->id) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus properti ini?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="sk-property-action sk-property-action-delete">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3 6h18"></path>
                                    <path d="M8 6V4h8v2"></path>
                                    <path d="m19 6-1 14H6L5 6"></path>
                                    <path d="M10 11v5M14 11v5"></path>
                                </svg>
                                Hapus
                            </button>

                        </form>

                    </div>

                </article>

            @empty

                {{-- EMPTY STATE --}}
                <div class="sk-property-empty">

                    <div class="sk-property-empty-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 10.5 12 3l9 7.5"></path>
                            <path d="M5.5 9.5V21h13V9.5"></path>
                            <path d="M9 21v-7h6v7"></path>
                        </svg>
                    </div>

                    <h3>Belum Ada Properti</h3>

                    <p>
                        Mulai dengan menambahkan properti kost pertama Anda.
                    </p>

                    <a href="{{ route('owner.kosts.create') }}"
                       class="sk-btn">
                        + Tambah Kost Pertama
                    </a>

                </div>

            @endforelse

            {{-- FOOTER --}}
            <footer class="sk-footer">
                <strong class="sk-footer-brand">smartkost.</strong>
                <span>Your space, beautifully managed.</span>

                <div>
                    © {{ date('Y') }} Smart Kost Management System
                </div>
            </footer>

        </div>
    </div>

    {{-- PAGE SPECIFIC STYLES --}}
    <style>
        .sk-page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 28px;
        }

        .sk-page-eyebrow {
            color: var(--brown-light);
        }

        .sk-page-title {
            margin-top: 8px;
            font-size: 30px;
        }

        .sk-property-banner {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
            min-height: 175px;
            padding: 30px 35px;
            margin-bottom: 28px;
            overflow: hidden;
            border-radius: 17px;
            color: white;
            background: linear-gradient(110deg, #493126, #8B654D);
            box-shadow: 0 10px 28px rgba(73,49,38,.10);
        }

        .sk-property-banner-content {
            position: relative;
            z-index: 2;
            max-width: 650px;
        }

        .sk-property-banner-label {
            color: #E7D3BE;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .sk-property-banner h2 {
            margin-top: 10px;
            color: white;
            font-family: 'Manrope', sans-serif;
            font-size: 23px;
            font-weight: 800;
            line-height: 1.5;
        }

        .sk-property-banner p {
            margin-top: 8px;
            color: #F0E2D5;
            font-size: 12px;
            line-height: 1.8;
        }

        .sk-property-banner-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 105px;
            height: 105px;
            border: 1px solid rgba(255,255,255,.20);
            border-radius: 25px;
            background: rgba(255,255,255,.08);
        }

        .sk-property-banner-icon svg {
            width: 65px;
            height: 65px;
            fill: none;
            stroke: #F0DCC9;
            stroke-width: 1.3;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
        }

        .sk-alert-success {
            background: #EAF2E9;
            color: #55775B;
            border: 1px solid #D6E6D3;
        }

        .sk-alert-error {
            background: #F8E8E4;
            color: #A75E52;
            border: 1px solid #EFD3CC;
        }

        .sk-alert-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(255,255,255,.65);
            font-weight: 800;
        }

        .sk-property-summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 32px;
        }

        .sk-property-summary-card {
            display: flex;
            align-items: center;
            gap: 17px;
            padding: 22px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow);
            transition: .25s ease;
        }

        .sk-property-summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(73,49,38,.09);
        }

        .sk-property-summary-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 13px;
            background: var(--cream);
            color: var(--brown);
        }

        .sk-property-summary-icon svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-property-summary-number {
            color: var(--brown-dark);
            font-size: 27px;
            font-weight: 800;
        }

        .sk-property-summary-label {
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .sk-property-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .sk-property-count {
            padding: 8px 14px;
            border-radius: 30px;
            background: var(--cream-dark);
            color: var(--brown);
            font-size: 11px;
            font-weight: 800;
        }

        .sk-property-card {
            padding: 25px;
            margin-bottom: 17px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            transition: transform .3s ease, box-shadow .3s ease;
            animation: skFadeUp .5s ease both;
        }

        .sk-property-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(73,49,38,.09);
        }

        .sk-property-card-main {
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        .sk-property-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            border-radius: 14px;
            background: var(--cream);
            color: var(--brown);
        }

        .sk-property-icon svg {
            width: 27px;
            height: 27px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-property-information {
            flex: 1;
            min-width: 0;
        }

        .sk-property-name-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .sk-property-name-row h3 {
            color: var(--brown-dark);
            font-size: 19px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .sk-property-status {
            padding: 5px 10px;
            border-radius: 20px;
            background: #EAF2E9;
            color: #55775B;
            font-size: 9px;
            font-weight: 800;
        }

        .sk-property-address {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            margin-top: 9px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .sk-property-address svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            margin-top: 1px;
            fill: none;
            stroke: var(--brown-light);
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-property-description {
            margin-top: 10px;
            color: var(--brown-medium);
            font-size: 11px;
            line-height: 1.8;
        }

        .sk-property-room-box {
            min-width: 125px;
            padding: 16px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--cream);
            text-align: center;
        }

        .sk-property-room-label {
            color: var(--muted);
            font-size: 10px;
        }

        .sk-property-room-number {
            margin-top: 5px;
            color: var(--brown-dark);
            font-size: 27px;
            font-weight: 800;
        }

        .sk-property-room-caption {
            margin-top: 3px;
            color: var(--muted);
            font-size: 9px;
        }

        .sk-property-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            padding-top: 19px;
            margin-top: 21px;
            border-top: 1px solid var(--border);
        }

        .sk-property-actions form {
            margin: 0;
        }

        .sk-property-action {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            min-height: 38px;
            padding: 9px 14px;
            border: 0;
            border-radius: 8px;
            font-family: 'Manrope', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: .25s ease;
        }

        .sk-property-action svg {
            width: 15px;
            height: 15px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-property-action:hover {
            transform: translateY(-2px);
        }

        .sk-property-action-primary {
            background: var(--brown);
            color: white;
        }

        .sk-property-action-primary:hover {
            background: var(--brown-dark);
        }

        .sk-property-action-edit {
            background: var(--cream-dark);
            color: var(--brown);
        }

        .sk-property-action-edit:hover {
            background: var(--beige);
        }

        .sk-property-action-delete {
            background: #F8E8E4;
            color: #A75E52;
        }

        .sk-property-action-delete:hover {
            background: #F1D8D2;
        }

        .sk-property-empty {
            padding: 55px 25px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .sk-property-empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 75px;
            height: 75px;
            margin: 0 auto 18px;
            border-radius: 20px;
            background: var(--cream);
            color: var(--brown-light);
        }

        .sk-property-empty-icon svg {
            width: 38px;
            height: 38px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.4;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-property-empty h3 {
            color: var(--brown-dark);
            font-size: 20px;
            font-weight: 800;
        }

        .sk-property-empty p {
            margin: 9px 0 22px;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .sk-property-banner {
                padding: 25px;
            }

            .sk-property-banner h2 {
                font-size: 19px;
            }

            .sk-property-banner-icon {
                width: 75px;
                height: 75px;
            }

            .sk-property-banner-icon svg {
                width: 48px;
                height: 48px;
            }

            .sk-property-card-main {
                flex-wrap: wrap;
            }

            .sk-property-room-box {
                width: 100%;
                text-align: left;
            }

            .sk-property-summary {
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .sk-page-title {
                font-size: 25px;
            }

            .sk-property-banner {
                padding: 22px;
            }

            .sk-property-banner-icon {
                display: none;
            }

            .sk-property-summary {
                grid-template-columns: 1fr;
            }

            .sk-property-card {
                padding: 18px;
            }

            .sk-property-icon {
                width: 47px;
                height: 47px;
            }

            .sk-property-name-row h3 {
                font-size: 16px;
            }

            .sk-property-actions {
                align-items: stretch;
            }

            .sk-property-actions > a,
            .sk-property-actions > form {
                flex: 1 1 100%;
            }

            .sk-property-actions form button {
                width: 100%;
            }
        }
    </style>
</x-app-layout>
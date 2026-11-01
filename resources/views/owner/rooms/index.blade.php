<x-app-layout>
    <div class="sk-page">
        <div class="sk-container">

            {{-- HEADER --}}
            <div class="sk-room-page-header">
                <div>
                    <div class="sk-eyebrow sk-room-eyebrow">
                        ROOM MANAGEMENT
                    </div>

                    <h1 class="sk-section-heading sk-room-page-title">
                        Manajemen Kamar
                    </h1>

                    <p class="sk-section-description">
                        Kelola kamar pada properti {{ $kost->name }}.
                    </p>
                </div>

                <a href="{{ route('owner.kosts.rooms.create', $kost->id) }}"
                   class="sk-btn">
                    <span>+</span> Tambah Kamar
                </a>
            </div>

            {{-- PROPERTY INFORMATION --}}
            <section class="sk-room-property-banner">
                <div class="sk-room-property-content">
                    <div class="sk-room-property-label">
                        PROPERTI YANG DIKELOLA
                    </div>

                    <h2>{{ $kost->name }}</h2>

                    <div class="sk-room-property-address">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/>
                            <circle cx="12" cy="10" r="2.5"/>
                        </svg>
                        {{ $kost->address }}
                    </div>
                </div>

                <a href="{{ route('owner.kosts.index') }}"
                   class="sk-room-back-link">
                    <span>←</span> Daftar Properti
                </a>
            </section>

            {{-- NOTIFICATIONS --}}
            @if(session('success'))
                <div class="sk-room-alert sk-room-alert-success">
                    <span>✓</span>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="sk-room-alert sk-room-alert-error">
                    <span>!</span>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="sk-room-alert sk-room-alert-error">
                    <span>!</span>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- ROOM STATISTICS --}}
            <section class="sk-room-stat-grid">

                <div class="sk-room-stat-card">
                    <div class="sk-room-stat-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="4" y="4" width="16" height="16" rx="1"/>
                            <path d="M4 9h16M4 14h16M9 4v16M14 4v16"/>
                        </svg>
                    </div>

                    <div>
                        <div class="sk-room-stat-number">
                            {{ $rooms->count() }}
                        </div>
                        <div class="sk-room-stat-label">
                            Total Kamar
                        </div>
                    </div>
                </div>

                <div class="sk-room-stat-card">
                    <div class="sk-room-stat-icon sk-room-stat-available">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m4 12 5 5L20 6"/>
                        </svg>
                    </div>

                    <div>
                        <div class="sk-room-stat-number">
                            {{ $rooms->where('status', 'available')->count() }}
                        </div>
                        <div class="sk-room-stat-label">
                            Kamar Tersedia
                        </div>
                    </div>
                </div>

                <div class="sk-room-stat-card">
                    <div class="sk-room-stat-icon sk-room-stat-occupied">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="8" r="3.5"/>
                            <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                        </svg>
                    </div>

                    <div>
                        <div class="sk-room-stat-number">
                            {{ $rooms->where('status', 'occupied')->count() }}
                        </div>
                        <div class="sk-room-stat-label">
                            Kamar Terisi
                        </div>
                    </div>
                </div>

            </section>

            {{-- ROOM LIST HEADER --}}
            <section class="sk-room-list-section">

                <div class="sk-room-list-header">
                    <div>
                        <h2 class="sk-section-heading">
                            Daftar Kamar
                        </h2>

                        <p class="sk-section-description">
                            Informasi kamar dan harga sewa bulanan.
                        </p>
                    </div>

                    <span class="sk-room-count">
                        {{ $rooms->count() }} Kamar
                    </span>
                </div>

                {{-- ROOM CARDS --}}
                @forelse($rooms as $room)

                    <article class="sk-room-card">

                        <div class="sk-room-card-main">

                            {{-- ROOM ICON --}}
                            <div class="sk-room-card-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3 19V8"/>
                                    <path d="M21 19V8"/>
                                    <path d="M3 13h18"/>
                                    <path d="M5 8V5h5v8"/>
                                    <path d="M10 10h9a2 2 0 0 1 2 2v7H3"/>
                                </svg>
                            </div>

                            {{-- ROOM INFORMATION --}}
                            <div class="sk-room-information">
                                <div class="sk-room-number-label">
                                    NOMOR KAMAR
                                </div>

                                <h3>{{ $room->room_number }}</h3>

                                <p>{{ $kost->name }}</p>
                            </div>

                            {{-- PRICE --}}
                            <div class="sk-room-price">
                                <div class="sk-room-price-label">
                                    Harga sewa per bulan
                                </div>

                                <div class="sk-room-price-value">
                                    Rp {{ number_format((float) $room->monthly_price, 0, ',', '.') }}
                                </div>

                                <div class="sk-room-price-caption">
                                    Pembayaran bulanan
                                </div>
                            </div>

                            {{-- STATUS --}}
                            <div class="sk-room-status-wrapper">
                                @if($room->status === 'available')
                                    <span class="sk-room-status sk-room-status-available">
                                        <span class="sk-room-status-dot"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="sk-room-status sk-room-status-occupied">
                                        <span class="sk-room-status-dot"></span>
                                        Terisi
                                    </span>
                                @endif
                            </div>

                        </div>

                        {{-- ACTIONS --}}
                        <div class="sk-room-actions">

                            <a href="{{ route('owner.kosts.rooms.edit', [$kost->id, $room->id]) }}"
                               class="sk-room-action sk-room-action-edit">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="m14 5 5 5"/>
                                    <path d="M4 20h4L19 9a2.1 2.1 0 0 0-4-4L4 16v4Z"/>
                                </svg>
                                Edit Kamar
                            </a>

                            <form action="{{ route('owner.kosts.rooms.destroy', [$kost->id, $room->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="sk-room-action sk-room-action-delete">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M3 6h18"/>
                                        <path d="M8 6V4h8v2"/>
                                        <path d="m19 6-1 14H6L5 6"/>
                                        <path d="M10 11v5M14 11v5"/>
                                    </svg>
                                    Hapus Kamar
                                </button>
                            </form>

                        </div>

                    </article>

                @empty

                    {{-- EMPTY STATE --}}
                    <div class="sk-room-empty">

                        <div class="sk-room-empty-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 19V8"/>
                                <path d="M21 19V8"/>
                                <path d="M3 13h18"/>
                                <path d="M5 8V5h5v8"/>
                                <path d="M10 10h9a2 2 0 0 1 2 2v7H3"/>
                            </svg>
                        </div>

                        <h3>Belum Ada Kamar</h3>

                        <p>
                            Tambahkan kamar pertama untuk properti ini.
                        </p>

                        <a href="{{ route('owner.kosts.rooms.create', $kost->id) }}"
                           class="sk-btn">
                            + Tambah Kamar
                        </a>

                    </div>

                @endforelse

            </section>

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

    {{-- PAGE STYLES --}}
    <style>
        .sk-room-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 27px;
        }

        .sk-room-eyebrow {
            color: var(--brown-light);
        }

        .sk-room-page-title {
            margin-top: 8px;
            font-size: 29px;
        }

        .sk-room-property-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            padding: 25px 28px;
            margin-bottom: 25px;
            background: linear-gradient(110deg, #493126, #8B654D);
            border-radius: 16px;
            box-shadow: 0 10px 28px rgba(73,49,38,.10);
            color: white;
        }

        .sk-room-property-label {
            color: #E7D3BE;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .sk-room-property-content h2 {
            margin-top: 8px;
            color: white;
            font-size: 21px;
            font-weight: 800;
        }

        .sk-room-property-address {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 7px;
            color: #F0E2D5;
            font-size: 11px;
        }

        .sk-room-property-address svg {
            width: 15px;
            height: 15px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .sk-room-back-link {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 11px 16px;
            background: #F7F2EB;
            border-radius: 8px;
            color: #493126;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
            transition: .25s ease;
        }

        .sk-room-back-link:hover {
            background: white;
            transform: translateY(-2px);
        }

        .sk-room-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            margin-bottom: 18px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
        }

        .sk-room-alert-success {
            background: #EAF2E9;
            color: #55775B;
            border: 1px solid #D6E6D3;
        }

        .sk-room-alert-error {
            background: #F8E8E4;
            color: #A75E52;
            border: 1px solid #EFD3CC;
        }

        .sk-room-stat-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
        }

        .sk-room-stat-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 22px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow);
            transition: .3s ease;
            animation: skFadeUp .55s ease both;
        }

        .sk-room-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 13px 28px rgba(73,49,38,.09);
        }

        .sk-room-stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            border-radius: 13px;
            background: var(--cream);
            color: var(--brown);
        }

        .sk-room-stat-icon svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-room-stat-available {
            background: #EAF2E9;
            color: #63836B;
        }

        .sk-room-stat-occupied {
            background: #F5EBDD;
            color: #A47C5D;
        }

        .sk-room-stat-number {
            color: var(--brown-dark);
            font-size: 27px;
            font-weight: 800;
        }

        .sk-room-stat-label {
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .sk-room-list-section {
            margin-top: 34px;
        }

        .sk-room-list-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .sk-room-count {
            padding: 8px 13px;
            background: var(--cream-dark);
            border-radius: 30px;
            color: var(--brown);
            font-size: 10px;
            font-weight: 800;
        }

        .sk-room-card {
            padding: 23px;
            margin-bottom: 15px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: var(--shadow);
            transition: transform .3s ease, box-shadow .3s ease;
            animation: skFadeUp .5s ease both;
        }

        .sk-room-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(73,49,38,.09);
        }

        .sk-room-card-main {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .sk-room-card-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            background: var(--cream);
            border-radius: 14px;
            color: var(--brown);
        }

        .sk-room-card-icon svg {
            width: 28px;
            height: 28px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.6;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-room-information {
            flex: 1;
            min-width: 110px;
        }

        .sk-room-number-label {
            color: var(--muted);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.1px;
        }

        .sk-room-information h3 {
            margin-top: 5px;
            color: var(--brown-dark);
            font-size: 20px;
            font-weight: 800;
        }

        .sk-room-information p {
            margin-top: 5px;
            color: var(--muted);
            font-size: 10px;
        }

        .sk-room-price {
            min-width: 190px;
        }

        .sk-room-price-label {
            color: var(--muted);
            font-size: 10px;
        }

        .sk-room-price-value {
            margin-top: 6px;
            color: var(--brown);
            font-size: 18px;
            font-weight: 800;
        }

        .sk-room-price-caption {
            margin-top: 4px;
            color: #B5A69A;
            font-size: 9px;
        }

        .sk-room-status-wrapper {
            min-width: 100px;
        }

        .sk-room-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
        }

        .sk-room-status-available {
            background: #EAF2E9;
            color: #55775B;
        }

        .sk-room-status-occupied {
            background: #FFF4DF;
            color: #9A6B22;
        }

        .sk-room-status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        .sk-room-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            padding-top: 18px;
            margin-top: 20px;
            border-top: 1px solid var(--border);
        }

        .sk-room-actions form {
            margin: 0;
        }

        .sk-room-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 37px;
            padding: 9px 14px;
            border: none;
            border-radius: 8px;
            font-family: 'Manrope', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: .25s ease;
        }

        .sk-room-action svg {
            width: 15px;
            height: 15px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-room-action:hover {
            transform: translateY(-2px);
        }

        .sk-room-action-edit {
            background: var(--cream-dark);
            color: var(--brown);
        }

        .sk-room-action-edit:hover {
            background: var(--beige);
        }

        .sk-room-action-delete {
            background: #F8E8E4;
            color: #A75E52;
        }

        .sk-room-action-delete:hover {
            background: #F1D8D2;
        }

        .sk-room-empty {
            padding: 55px 20px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .sk-room-empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 75px;
            height: 75px;
            margin: 0 auto 17px;
            border-radius: 20px;
            background: var(--cream);
            color: var(--brown-light);
        }

        .sk-room-empty-icon svg {
            width: 37px;
            height: 37px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sk-room-empty h3 {
            color: var(--brown-dark);
            font-size: 20px;
            font-weight: 800;
        }

        .sk-room-empty p {
            margin: 8px 0 22px;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 900px) {
            .sk-room-card-main {
                gap: 14px;
            }

            .sk-room-price {
                min-width: 150px;
            }
        }

        @media (max-width: 768px) {
            .sk-room-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .sk-room-stat-card:last-child {
                grid-column: 1 / -1;
            }

            .sk-room-property-banner {
                align-items: flex-start;
            }

            .sk-room-price {
                width: calc(100% - 76px);
                margin-left: 76px;
            }

            .sk-room-status-wrapper {
                margin-left: 76px;
            }
        }

        @media (max-width: 480px) {
            .sk-room-page-title {
                font-size: 25px;
            }

            .sk-room-stat-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .sk-room-stat-card:last-child {
                grid-column: auto;
            }

            .sk-room-card {
                padding: 18px;
            }

            .sk-room-card-main {
                align-items: flex-start;
            }

            .sk-room-price {
                width: 100%;
                margin-left: 0;
                padding-top: 14px;
                border-top: 1px solid var(--border);
            }

            .sk-room-status-wrapper {
                margin-left: 0;
            }

            .sk-room-actions > a,
            .sk-room-actions > form {
                flex: 1 1 100%;
            }

            .sk-room-actions form button {
                width: 100%;
            }
        }
    </style>
</x-app-layout>
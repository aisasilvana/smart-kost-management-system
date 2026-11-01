
<x-app-layout>
    <div class="sk-page">
        <div class="sk-container tenant-dashboard">

            @php
                $tenant = auth()->user()->tenant;

                $activeAssignment = $tenant
                    ? $tenant->roomAssignments()
                        ->with(['room.kost'])
                        ->where('status', 'active')
                        ->latest()
                        ->first()
                    : null;

                $bills = $tenant
                    ? \App\Models\Bill::with('payments')
                        ->whereHas('roomAssignment', function ($query) use ($tenant) {
                            $query->where('tenant_id', $tenant->id);
                        })
                        ->latest()
                        ->get()
                    : collect();

                $unpaidBills = $bills->where('status', 'unpaid');
                $paidBills = $bills->where('status', 'paid');
                $totalUnpaid = $unpaidBills->sum('amount');

                $pendingPayments = $bills->filter(function ($bill) {
                    return $bill->status !== 'paid'
                        && $bill->payments->where('status', 'pending')->isNotEmpty();
                })->count();

                $recentBills = $bills->take(3);
            @endphp

            {{-- WELCOME SECTION --}}
            <section class="tenant-welcome">
                <div class="tenant-welcome-content">
                    <span class="tenant-welcome-label">TENANT DASHBOARD</span>

                    <h1>
                        Selamat Datang,<br>
                        {{ auth()->user()->name }}!
                    </h1>

                    <p>
                        Kelola informasi hunian dan pantau pembayaran
                        sewa Anda dengan mudah melalui Smart Kost.
                    </p>

                    <a href="{{ route('tenant.payments.index') }}"
                       class="tenant-welcome-button">
                        Lihat Tagihan Saya
                        <svg viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14m-6-6 6 6-6 6"/>
                        </svg>
                    </a>
                </div>

                <div class="tenant-welcome-decoration">
                    <div class="tenant-house-icon">
                        <svg viewBox="0 0 180 150" fill="none">
                            <path d="M20 72L90 15L160 72V135H20V72Z"
                                stroke="currentColor" stroke-width="5"
                                stroke-linejoin="round"/>
                            <path d="M70 135V88H110V135"
                                stroke="currentColor" stroke-width="5"/>
                            <path d="M38 85H60V107H38V85Z"
                                stroke="currentColor" stroke-width="4"/>
                            <path d="M120 85H142V107H120V85Z"
                                stroke="currentColor" stroke-width="4"/>
                            <path d="M77 48H103"
                                stroke="currentColor" stroke-width="4"
                                stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="tenant-decoration-dot dot-one"></span>
                    <span class="tenant-decoration-dot dot-two"></span>
                    <span class="tenant-decoration-dot dot-three"></span>
                </div>
            </section>

            {{-- TENANT ALERT --}}
            @if(!$tenant)
                <div class="tenant-dashboard-alert">
                    <svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 8v4m0 4h.01"/>
                    </svg>
                    <div>
                        <strong>Data penghuni belum terdaftar</strong>
                        <p>
                            Silakan hubungi Owner untuk menghubungkan akun
                            Anda dengan data penghuni kost.
                        </p>
                    </div>
                </div>
            @endif

            {{-- OVERVIEW --}}
            <section class="tenant-section">
                <div class="tenant-section-heading">
                    <div>
                        <span class="tenant-section-label">OVERVIEW</span>
                        <h2>Ringkasan Saya</h2>
                        <p>Informasi singkat mengenai hunian dan pembayaran Anda.</p>
                    </div>
                </div>

                <div class="tenant-overview-grid">

                    <div class="tenant-overview-card">
                        <div class="tenant-overview-top">
                            <div class="tenant-overview-icon residence-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V10Z"/>
                                    <path d="M9 21v-8h6v8"/>
                                </svg>
                            </div>
                            <span>Status Hunian</span>
                        </div>
                        <strong class="overview-status">
                            {{ $activeAssignment ? 'Aktif' : 'Belum Ada' }}
                        </strong>
                        <small>
                            {{ $activeAssignment ? 'Sedang menempati kamar' : 'Belum memiliki penempatan aktif' }}
                        </small>
                    </div>

                    <div class="tenant-overview-card">
                        <div class="tenant-overview-top">
                            <div class="tenant-overview-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round">
                                    <rect x="4" y="3" width="16" height="18" rx="2"/>
                                    <path d="M8 8h8M8 12h8M8 16h4"/>
                                </svg>
                            </div>
                            <span>Total Tagihan</span>
                        </div>
                        <strong>{{ $bills->count() }}</strong>
                        <small>Seluruh tagihan tercatat</small>
                    </div>

                    <div class="tenant-overview-card">
                        <div class="tenant-overview-top">
                            <div class="tenant-overview-icon unpaid-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 7v5l3 2"/>
                                </svg>
                            </div>
                            <span>Belum Dibayar</span>
                        </div>
                        <strong>{{ $unpaidBills->count() }}</strong>
                        <small>Tagihan yang masih terbuka</small>
                    </div>

                    <div class="tenant-overview-card">
                        <div class="tenant-overview-top">
                            <div class="tenant-overview-icon paid-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="m8 12 3 3 5-6"/>
                                </svg>
                            </div>
                            <span>Sudah Dibayar</span>
                        </div>
                        <strong>{{ $paidBills->count() }}</strong>
                        <small>Tagihan yang telah lunas</small>
                    </div>

                </div>
            </section>

            {{-- RESIDENCE AND PAYMENT --}}
            <section class="tenant-content-grid">

                {{-- RESIDENCE --}}
                <div class="tenant-room-card">
                    <div class="tenant-section-heading">
                        <div>
                            <span class="tenant-section-label">MY RESIDENCE</span>
                            <h2>Informasi Hunian</h2>
                        </div>
                    </div>

                    @if($activeAssignment)
                        <div class="tenant-room-content">

                            <div class="tenant-room-image">
                                <svg viewBox="0 0 100 100" fill="none">
                                    <path d="M15 45L50 15L85 45V85H15V45Z"
                                        stroke="currentColor" stroke-width="4"
                                        stroke-linejoin="round"/>
                                    <path d="M39 85V57H61V85"
                                        stroke="currentColor" stroke-width="4"/>
                                    <path d="M25 50H37V62H25V50Z"
                                        stroke="currentColor" stroke-width="3"/>
                                    <path d="M63 50H75V62H63V50Z"
                                        stroke="currentColor" stroke-width="3"/>
                                </svg>
                            </div>

                            <div class="tenant-room-details">
                                <span class="tenant-room-status">
                                    <span></span>
                                    PENEMPATAN AKTIF
                                </span>

                                <h3>
                                    {{ $activeAssignment->room->kost->name ?? 'Kost' }}
                                </h3>

                                <p>
                                    Kamar {{ $activeAssignment->room->room_number }}
                                </p>

                                <div class="tenant-room-price">
                                    Rp{{ number_format($activeAssignment->room->monthly_price, 0, ',', '.') }}
                                    <small>/ bulan</small>
                                </div>

                                <div class="tenant-room-date">
                                    <svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.7"
                                        stroke-linecap="round">
                                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                                        <path d="M16 3v4M8 3v4M3 10h18"/>
                                    </svg>
                                    Mulai menempati:
                                    {{ \Carbon\Carbon::parse($activeAssignment->start_date)->format('d M Y') }}
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="tenant-no-room">
                            <div class="tenant-no-room-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.7"
                                    stroke-linecap="round">
                                    <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V10Z"/>
                                    <path d="M9 21v-8h6v8"/>
                                </svg>
                            </div>
                            <h3>Belum Ada Informasi Hunian</h3>
                            <p>
                                Informasi kamar akan muncul setelah Owner
                                menempatkan Anda ke kamar kost.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- PAYMENT SUMMARY --}}
                <div class="tenant-payment-summary">
                    <div class="tenant-section-heading">
                        <div>
                            <span class="tenant-section-label">PAYMENT SUMMARY</span>
                            <h2>Ringkasan Pembayaran</h2>
                        </div>
                    </div>

                    <div class="tenant-payment-total">
                        <span>Total Belum Dibayar</span>
                        <strong>
                            Rp{{ number_format($totalUnpaid, 0, ',', '.') }}
                        </strong>
                        <small>Akumulasi tagihan yang belum lunas</small>
                    </div>

                    <div class="tenant-payment-summary-row">
                        <div>
                            <span class="summary-dot pending-dot"></span>
                            Menunggu Verifikasi
                        </div>
                        <strong>{{ $pendingPayments }} tagihan</strong>
                    </div>

                    <div class="tenant-payment-summary-row">
                        <div>
                            <span class="summary-dot paid-dot"></span>
                            Tagihan Lunas
                        </div>
                        <strong>{{ $paidBills->count() }} tagihan</strong>
                    </div>

                    <a href="{{ route('tenant.payments.index') }}"
                       class="tenant-payment-link">
                        Buka Halaman Pembayaran
                        <svg viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round">
                            <path d="M5 12h14m-6-6 6 6-6 6"/>
                        </svg>
                    </a>
                </div>

            </section>

            {{-- RECENT BILLS --}}
            <section class="tenant-section">
                <div class="tenant-section-heading recent-heading">
                    <div>
                        <span class="tenant-section-label">RECENT ACTIVITY</span>
                        <h2>Tagihan Terbaru</h2>
                        <p>Pantau beberapa tagihan terakhir Anda.</p>
                    </div>

                    <a href="{{ route('tenant.payments.index') }}"
                       class="tenant-view-all">
                        Lihat Semua
                        <span>→</span>
                    </a>
                </div>

                <div class="tenant-recent-panel">
                    @forelse($recentBills as $bill)
                        @php
                            $latestPayment = $bill->payments
                                ->sortByDesc('created_at')
                                ->first();

                            if ($bill->status === 'paid') {
                                $recentStatus = 'Lunas';
                                $recentClass = 'paid';
                            } elseif ($latestPayment?->status === 'pending') {
                                $recentStatus = 'Menunggu Verifikasi';
                                $recentClass = 'pending';
                            } elseif ($latestPayment?->status === 'rejected') {
                                $recentStatus = 'Ditolak';
                                $recentClass = 'rejected';
                            } else {
                                $recentStatus = 'Belum Dibayar';
                                $recentClass = 'unpaid';
                            }
                        @endphp

                        <div class="tenant-recent-item">
                            <div class="tenant-recent-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.7"
                                    stroke-linecap="round">
                                    <rect x="4" y="3" width="16" height="18" rx="2"/>
                                    <path d="M8 8h8M8 12h8M8 16h4"/>
                                </svg>
                            </div>

                            <div class="tenant-recent-info">
                                <strong>
                                    {{ \Carbon\Carbon::parse($bill->billing_month)->translatedFormat('F Y') }}
                                </strong>
                                <small>
                                    Jatuh tempo:
                                    {{ \Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}
                                </small>
                            </div>

                            <div class="tenant-recent-amount">
                                <strong>
                                    Rp{{ number_format((float) $bill->amount, 0, ',', '.') }}
                                </strong>
                                <span class="tenant-recent-status {{ $recentClass }}">
                                    {{ $recentStatus }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="tenant-recent-empty">
                            Belum ada riwayat tagihan.
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- QUICK ACCESS --}}
            <section class="tenant-quick-section">
                <div class="tenant-section-heading">
                    <div>
                        <span class="tenant-section-label">QUICK ACCESS</span>
                        <h2>Akses Cepat</h2>
                        <p>Akses fitur yang sering Anda gunakan.</p>
                    </div>
                </div>

                <div class="tenant-quick-grid">

                    <a href="{{ route('tenant.payments.index') }}"
                       class="tenant-quick-card">
                        <div class="tenant-quick-icon">
                            <svg viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round">
                                <rect x="4" y="3" width="16" height="18" rx="2"/>
                                <path d="M8 8h8M8 12h8M8 16h4"/>
                            </svg>
                        </div>

                        <div>
                            <strong>Tagihan Saya</strong>
                            <small>Lihat dan bayar tagihan sewa</small>
                        </div>

                        <span class="tenant-quick-arrow">→</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="tenant-quick-card">
                        <div class="tenant-quick-icon">
                            <svg viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M4 21v-2a8 8 0 0 1 16 0v2"/>
                            </svg>
                        </div>

                        <div>
                            <strong>Profil Saya</strong>
                            <small>Kelola informasi akun</small>
                        </div>

                        <span class="tenant-quick-arrow">→</span>
                    </a>

                </div>
            </section>

            {{-- FOOTER --}}
            <div class="tenant-dashboard-footer">
                <span>Smart Kost Management System</span>
                <span>Tenant Dashboard</span>
            </div>

        </div>
    </div>

    <style>
        .tenant-dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 35px;
            font-family: 'Manrope', sans-serif;
            color: #493A30;
        }

        .tenant-welcome {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow: hidden;
            min-height: 235px;
            padding: 38px 42px;
            border-radius: 17px;
            background: linear-gradient(115deg, #493126, #806047);
            color: #FFFFFF;
            box-sizing: border-box;
        }

        .tenant-welcome-content {
            position: relative;
            z-index: 2;
            max-width: 570px;
        }

        .tenant-welcome-label,
        .tenant-section-label {
            display: block;
            margin-bottom: 9px;
            color: #C49B7B;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.7px;
        }

        .tenant-welcome h1 {
            margin: 0 0 12px;
            color: #FFFFFF;
            font-size: 29px;
            font-weight: 800;
            line-height: 1.35;
            letter-spacing: -.7px;
        }

        .tenant-welcome-content p {
            max-width: 470px;
            margin: 0 0 23px;
            color: #EAD9CA;
            font-size: 11px;
            line-height: 1.8;
        }

        .tenant-welcome-button {
            display: inline-flex;
            align-items: center;
            gap: 17px;
            padding: 12px 17px;
            border-radius: 8px;
            background: #F7F2EB;
            color: #493126;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
            transition: .2s ease;
        }

        .tenant-welcome-button:hover {
            transform: translateY(-2px);
            background: #FFFFFF;
        }

        .tenant-welcome-button svg {
            width: 15px;
            height: 15px;
        }

        .tenant-welcome-decoration {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 210px;
            height: 190px;
            flex-shrink: 0;
            border-radius: 50%;
            background: rgba(255,255,255,.07);
        }

        .tenant-house-icon {
            width: 145px;
            color: #EAD9CA;
        }

        .tenant-decoration-dot {
            position: absolute;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: #D8B99C;
        }

        .dot-one { top: 20px; right: 30px; }
        .dot-two { bottom: 20px; left: 20px; }
        .dot-three { top: 85px; left: 5px; width: 7px; height: 7px; }

        .tenant-dashboard-alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #EADBC9;
            border-radius: 10px;
            background: #FAF5EF;
            color: #806047;
        }

        .tenant-dashboard-alert svg {
            width: 19px;
            height: 19px;
            flex-shrink: 0;
        }

        .tenant-dashboard-alert strong {
            display: block;
            margin-bottom: 4px;
            font-size: 11px;
        }

        .tenant-dashboard-alert p {
            margin: 0;
            font-size: 10px;
            line-height: 1.7;
        }

        .tenant-section {
            margin-top: 32px;
        }

        .tenant-section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 17px;
        }

        .tenant-section-heading .tenant-section-label {
            margin-bottom: 6px;
        }

        .tenant-section-heading h2 {
            margin: 0;
            color: #493126;
            font-size: 17px;
            font-weight: 800;
        }

        .tenant-section-heading p {
            margin: 5px 0 0;
            color: #99877A;
            font-size: 10px;
        }

        .tenant-overview-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
        }

        .tenant-overview-card {
            min-width: 0;
            padding: 19px;
            border: 1px solid #E9DED3;
            border-radius: 13px;
            background: #FFFFFF;
            transition: .2s ease;
        }

        .tenant-overview-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(73,49,38,.06);
        }

        .tenant-overview-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 13px;
        }

        .tenant-overview-icon,
        .tenant-quick-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            border-radius: 10px;
            background: #F3E9DF;
            color: #684936;
        }

        .tenant-overview-icon svg,
        .tenant-quick-icon svg {
            width: 20px;
            height: 20px;
        }

        .tenant-overview-icon.unpaid-icon {
            background: #FFF3E5;
            color: #A87532;
        }

        .tenant-overview-icon.paid-icon {
            background: #EAF3E9;
            color: #47734A;
        }

        .tenant-overview-top > span {
            color: #99877A;
            font-size: 10px;
            font-weight: 700;
        }

        .tenant-overview-card > strong {
            display: block;
            margin: 7px 0 5px;
            color: #493126;
            font-size: 25px;
            font-weight: 800;
        }

        .tenant-overview-card > strong.overview-status {
            font-size: 20px;
        }

        .tenant-overview-card > small {
            color: #99877A;
            font-size: 9px;
            line-height: 1.6;
        }

        .tenant-content-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 18px;
            margin-top: 32px;
        }

        .tenant-room-card,
        .tenant-payment-summary {
            min-width: 0;
            padding: 23px;
            border: 1px solid #E9DED3;
            border-radius: 14px;
            background: #FFFFFF;
        }

        .tenant-room-content {
            display: flex;
            align-items: center;
            gap: 19px;
            padding-top: 5px;
        }

        .tenant-room-image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 105px;
            height: 105px;
            flex-shrink: 0;
            border-radius: 13px;
            background: #F3E9DF;
            color: #806047;
        }

        .tenant-room-image svg {
            width: 75px;
        }

        .tenant-room-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #60805D;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .8px;
        }

        .tenant-room-status span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #60805D;
        }

        .tenant-room-details h3 {
            margin: 7px 0 4px;
            color: #493126;
            font-size: 15px;
            font-weight: 800;
        }

        .tenant-room-details p {
            margin: 0;
            color: #99877A;
            font-size: 10px;
        }

        .tenant-room-price {
            margin-top: 13px;
            color: #684936;
            font-size: 16px;
            font-weight: 800;
        }

        .tenant-room-price small {
            color: #99877A;
            font-size: 10px;
            font-weight: 500;
        }

        .tenant-room-date {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 9px;
            color: #99877A;
            font-size: 9px;
        }

        .tenant-room-date svg {
            width: 13px;
            height: 13px;
        }

        .tenant-no-room {
            padding: 22px 0;
        }

        .tenant-no-room-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            margin-bottom: 13px;
            border-radius: 12px;
            background: #F3E9DF;
            color: #806047;
        }

        .tenant-no-room-icon svg {
            width: 23px;
            height: 23px;
        }

        .tenant-no-room h3 {
            margin: 0 0 7px;
            color: #493126;
            font-size: 13px;
            font-weight: 800;
        }

        .tenant-no-room p {
            margin: 0;
            color: #99877A;
            font-size: 10px;
            line-height: 1.7;
        }

        .tenant-payment-total {
            padding: 17px;
            border-radius: 10px;
            background: #F7F2EB;
        }

        .tenant-payment-total span {
            display: block;
            color: #99877A;
            font-size: 10px;
        }

        .tenant-payment-total strong {
            display: block;
            margin-top: 9px;
            color: #493126;
            font-size: 22px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .tenant-payment-total small {
            display: block;
            margin-top: 5px;
            color: #99877A;
            font-size: 9px;
        }

        .tenant-payment-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 14px 0;
            border-bottom: 1px solid #F0E9E2;
            color: #99877A;
            font-size: 10px;
        }

        .tenant-payment-summary-row > div {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tenant-payment-summary-row strong {
            color: #493126;
            font-size: 10px;
        }

        .summary-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .pending-dot { background: #C58A35; }
        .paid-dot { background: #60805D; }

        .tenant-payment-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-top: 18px;
            padding: 13px 15px;
            border-radius: 8px;
            background: #684936;
            color: #FFFFFF;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
            transition: .2s ease;
        }

        .tenant-payment-link:hover {
            background: #493126;
        }

        .tenant-payment-link svg {
            width: 15px;
            height: 15px;
        }

        .recent-heading {
            margin-bottom: 15px;
        }

        .tenant-view-all {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #8B654D;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
        }

        .tenant-view-all:hover {
            color: #493126;
        }

        .tenant-recent-panel {
            overflow: hidden;
            border: 1px solid #E9DED3;
            border-radius: 13px;
            background: #FFFFFF;
        }

        .tenant-recent-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 16px 19px;
            border-bottom: 1px solid #F0E9E2;
        }

        .tenant-recent-item:last-child {
            border-bottom: none;
        }

        .tenant-recent-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 39px;
            height: 39px;
            flex-shrink: 0;
            border-radius: 10px;
            background: #F3E9DF;
            color: #684936;
        }

        .tenant-recent-icon svg {
            width: 19px;
            height: 19px;
        }

        .tenant-recent-info {
            min-width: 0;
        }

        .tenant-recent-info strong,
        .tenant-recent-info small {
            display: block;
        }

        .tenant-recent-info strong {
            color: #493126;
            font-size: 11px;
            font-weight: 800;
        }

        .tenant-recent-info small {
            margin-top: 5px;
            color: #99877A;
            font-size: 9px;
        }

        .tenant-recent-amount {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 5px;
            margin-left: auto;
            text-align: right;
        }

        .tenant-recent-amount > strong {
            color: #493126;
            font-size: 11px;
            font-weight: 800;
        }

        .tenant-recent-status {
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 8px;
            font-weight: 800;
        }

        .tenant-recent-status.paid {
            background: #EAF3E9;
            color: #47734A;
        }

        .tenant-recent-status.pending {
            background: #FFF3DF;
            color: #A66B13;
        }

        .tenant-recent-status.rejected {
            background: #FCEAE7;
            color: #C65345;
        }

        .tenant-recent-status.unpaid {
            background: #F1EEE9;
            color: #806C5D;
        }

        .tenant-recent-empty {
            padding: 35px 20px;
            color: #99877A;
            font-size: 11px;
            text-align: center;
        }

        .tenant-quick-section {
            margin-top: 32px;
        }

        .tenant-quick-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .tenant-quick-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 17px;
            border: 1px solid #E9DED3;
            border-radius: 12px;
            background: #FFFFFF;
            text-decoration: none;
            transition: .2s ease;
        }

        .tenant-quick-card:hover {
            border-color: #B58B6B;
            transform: translateY(-2px);
            box-shadow: 0 7px 17px rgba(73,49,38,.05);
        }

        .tenant-quick-icon {
            margin: 0;
        }

        .tenant-quick-card strong,
        .tenant-quick-card small {
            display: block;
        }

        .tenant-quick-card strong {
            color: #493126;
            font-size: 11px;
            font-weight: 800;
        }

        .tenant-quick-card small {
            margin-top: 5px;
            color: #99877A;
            font-size: 9px;
        }

        .tenant-quick-arrow {
            margin-left: auto;
            color: #806047;
        }

        .tenant-dashboard-footer {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 18px 3px 0;
            color: #A39488;
            font-size: 10px;
        }

        @media (max-width: 1000px) {
            .tenant-overview-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .tenant-content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .tenant-welcome {
                min-height: auto;
                padding: 28px 22px;
            }

            .tenant-welcome h1 {
                font-size: 23px;
            }

            .tenant-welcome-decoration {
                display: none;
            }

            .tenant-overview-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .tenant-overview-card {
                padding: 14px;
            }

            .tenant-overview-top {
                align-items: flex-start;
                flex-direction: column;
            }

            .tenant-overview-card > strong {
                font-size: 22px;
            }

            .tenant-room-content {
                align-items: flex-start;
                flex-direction: column;
            }

            .tenant-quick-grid {
                grid-template-columns: 1fr;
            }

            .tenant-recent-item {
                padding: 14px 12px;
                gap: 9px;
            }

            .tenant-recent-amount > strong {
                font-size: 9px;
            }

            .tenant-dashboard-footer {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</x-app-layout>

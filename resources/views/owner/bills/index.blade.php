
<x-app-layout>
    <div class="sk-page">
        <div class="sk-container">

            {{-- HEADER --}}
            <div class="bill-heading">
                <div>
                    <span class="bill-eyebrow">FINANCIAL MANAGEMENT</span>
                    <h1>Manajemen Tagihan</h1>
                    <p>Kelola dan pantau tagihan sewa bulanan seluruh penghuni kost Anda.</p>
                </div>

                <a href="{{ route('owner.bills.create') }}" class="bill-primary-button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Buat Tagihan
                </a>
            </div>

            {{-- NOTIFICATION --}}
            @if (session('success'))
                <div class="bill-alert success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bill-alert error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bill-alert error">
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- STATISTICS --}}
            <div class="bill-stat-grid">

                <div class="bill-stat-card">
                    <div class="bill-stat-top">
                        <div class="bill-stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round">
                                <path d="M7 3h10l3 3v15H4V3z"/>
                                <path d="M8 10h8M8 14h8M8 18h5"/>
                            </svg>
                        </div>
                        <span class="bill-stat-label">TOTAL TAGIHAN</span>
                    </div>
                    <strong>{{ $totalBills }}</strong>
                    <small>Seluruh tagihan tercatat</small>
                </div>

                <div class="bill-stat-card">
                    <div class="bill-stat-top">
                        <div class="bill-stat-icon unpaid-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>
                        </div>
                        <span class="bill-stat-label">BELUM DIBAYAR</span>
                    </div>
                    <strong>{{ $unpaidBills }}</strong>
                    <small>Menunggu pembayaran penghuni</small>
                </div>

                <div class="bill-stat-card">
                    <div class="bill-stat-top">
                        <div class="bill-stat-icon paid-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="m8 12 3 3 5-6"/>
                            </svg>
                        </div>
                        <span class="bill-stat-label">SUDAH DIBAYAR</span>
                    </div>
                    <strong>{{ $paidBills }}</strong>
                    <small>Tagihan yang telah lunas</small>
                </div>

                <div class="bill-stat-card">
                    <div class="bill-stat-top">
                        <div class="bill-stat-icon money-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round">
                                <rect x="2" y="5" width="20" height="14" rx="2"/>
                                <path d="M2 10h20"/>
                                <circle cx="12" cy="14" r="2"/>
                            </svg>
                        </div>
                        <span class="bill-stat-label">TOTAL BELUM DIBAYAR</span>
                    </div>
                    <strong class="bill-money">
                        Rp{{ number_format($totalUnpaid, 0, ',', '.') }}
                    </strong>
                    <small>Akumulasi tagihan unpaid</small>
                </div>

            </div>

            {{-- BILL TABLE --}}
            <div class="bill-table-card">

                <div class="bill-table-heading">
                    <div>
                        <span class="bill-section-label">TRANSACTION OVERVIEW</span>
                        <h2>Daftar Tagihan</h2>
                        <p>Rincian tagihan berdasarkan penempatan kamar penghuni.</p>
                    </div>

                    <div class="bill-total-badge">
                        {{ $bills->count() }} Tagihan
                    </div>
                </div>

                @if ($bills->isEmpty())

                    <div class="bill-empty">
                        <div class="bill-empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7 3h10l3 3v15H4V3z"/>
                                <path d="M8 10h8M8 14h8M8 18h5"/>
                            </svg>
                        </div>

                        <h3>Belum Ada Tagihan</h3>
                        <p>
                            Belum ada tagihan yang tercatat. Buat tagihan pertama
                            untuk penghuni kost Anda.
                        </p>

                        <a href="{{ route('owner.bills.create') }}" class="bill-primary-button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Buat Tagihan
                        </a>
                    </div>

                @else

                    <div class="bill-table-wrapper">
                        <table class="bill-table">
                            <thead>
                                <tr>
                                    <th>Penghuni</th>
                                    <th>Kamar / Kost</th>
                                    <th>Periode</th>
                                    <th>Jumlah</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($bills as $bill)
                                    @php
                                        $tenant = $bill->roomAssignment?->tenant;
                                        $tenantUser = $tenant?->user;
                                        $room = $bill->roomAssignment?->room;
                                        $kost = $room?->kost;

                                        $tenantName = $tenantUser?->name ?? 'Penghuni tidak ditemukan';

                                        $billingMonth = $bill->billing_month
                                            ? \Carbon\Carbon::parse($bill->billing_month)->translatedFormat('F Y')
                                            : '-';

                                        $dueDate = $bill->due_date
                                            ? \Carbon\Carbon::parse($bill->due_date)->format('d/m/Y')
                                            : '-';
                                    @endphp

                                    <tr>
                                        {{-- TENANT --}}
                                        <td>
                                            <div class="bill-tenant">
                                                <div class="bill-avatar">
                                                    {{ strtoupper(substr($tenantName, 0, 1)) }}
                                                </div>

                                                <div class="bill-tenant-detail">
                                                    <strong>{{ $tenantName }}</strong>
                                                    <small>{{ $tenant?->phone ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- ROOM --}}
                                        <td>
                                            <div class="bill-room-detail">
                                                <strong>
                                                    Kamar {{ $room?->room_number ?? '-' }}
                                                </strong>
                                                <small>{{ $kost?->name ?? '-' }}</small>
                                            </div>
                                        </td>

                                        {{-- PERIOD --}}
                                        <td>
                                            <span class="bill-period">
                                                {{ $billingMonth }}
                                            </span>
                                        </td>

                                        {{-- AMOUNT --}}
                                        <td>
                                            <span class="bill-amount">
                                                Rp{{ number_format((float) $bill->amount, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        {{-- DUE DATE --}}
                                        <td>
                                            <span class="bill-due-date">
                                                {{ $dueDate }}
                                            </span>
                                        </td>

                                        {{-- STATUS --}}
                                        <td>
                                            @if ($bill->status === 'paid')
                                                <span class="bill-status paid">
                                                    <span class="status-dot"></span>
                                                    Lunas
                                                </span>
                                            @elseif ($bill->status === 'pending')
                                                <span class="bill-status pending">
                                                    <span class="status-dot"></span>
                                                    Menunggu
                                                </span>
                                            @else
                                                <span class="bill-status unpaid">
                                                    <span class="status-dot"></span>
                                                    Belum Dibayar
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif

            </div>

            <div class="bill-footer">
                <span>Smart Kost Management System</span>
                <span>Billing Management</span>
            </div>

        </div>
    </div>

    <style>
        .bill-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .bill-eyebrow,
        .bill-section-label {
            display: block;
            margin-bottom: 9px;
            color: #A87959;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.8px;
        }

        .bill-heading h1 {
            margin: 0 0 8px;
            color: #493126;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -0.8px;
        }

        .bill-heading p,
        .bill-table-heading p {
            margin: 0;
            color: #99877A;
            font-size: 12px;
            line-height: 1.7;
        }

        .bill-primary-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 43px;
            padding: 0 19px;
            border-radius: 9px;
            background: #684936;
            color: white;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
            transition: .25s ease;
        }

        .bill-primary-button svg {
            width: 16px;
            height: 16px;
        }

        .bill-primary-button:hover {
            background: #493126;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 7px 15px rgba(73, 49, 38, .13);
        }

        .bill-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .bill-stat-card {
            min-width: 0;
            padding: 19px;
            border: 1px solid #E9DED3;
            border-radius: 13px;
            background: #FFFFFF;
            transition: .25s ease;
        }

        .bill-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 9px 22px rgba(73, 49, 38, .06);
        }

        .bill-stat-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .bill-stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 37px;
            height: 37px;
            border-radius: 10px;
            background: #F7F2EB;
            color: #8B654D;
            flex-shrink: 0;
        }

        .bill-stat-icon svg {
            width: 19px;
            height: 19px;
        }

        .bill-stat-icon.unpaid-icon {
            background: #FFF3E5;
            color: #A87532;
        }

        .bill-stat-icon.paid-icon {
            background: #EAF3E9;
            color: #47734A;
        }

        .bill-stat-icon.money-icon {
            background: #F0EAF5;
            color: #80619B;
        }

        .bill-stat-label {
            color: #99877A;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .5px;
            line-height: 1.5;
        }

        .bill-stat-card > strong {
            display: block;
            margin-bottom: 6px;
            color: #493126;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -1px;
            overflow-wrap: anywhere;
        }

        .bill-stat-card .bill-money {
            font-size: 18px;
            letter-spacing: -.5px;
            margin-top: 5px;
        }

        .bill-stat-card > small {
            display: block;
            color: #99877A;
            font-size: 10px;
        }

        .bill-table-card {
            overflow: hidden;
            border: 1px solid #E9DED3;
            border-radius: 15px;
            background: #FFFFFF;
        }

        .bill-table-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 22px;
            border-bottom: 1px solid #EEE5DC;
            flex-wrap: wrap;
        }

        .bill-table-heading h2 {
            margin: 0 0 6px;
            color: #493126;
            font-size: 16px;
            font-weight: 800;
        }

        .bill-section-label {
            margin-bottom: 6px;
            font-size: 9px;
        }

        .bill-total-badge {
            padding: 7px 12px;
            border-radius: 20px;
            background: #F7F2EB;
            color: #684936;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .bill-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .bill-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .bill-table th {
            padding: 15px 16px;
            background: #FAF7F3;
            color: #99877A;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .6px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .bill-table td {
            padding: 16px;
            border-bottom: 1px solid #F0E9E2;
            color: #493126;
            font-size: 11px;
            white-space: nowrap;
        }

        .bill-table tbody tr {
            transition: background .2s ease;
        }

        .bill-table tbody tr:hover {
            background: #FDFBF9;
        }

        .bill-table tbody tr:last-child td {
            border-bottom: none;
        }

        .bill-tenant {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 175px;
        }

        .bill-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 37px;
            height: 37px;
            flex-shrink: 0;
            border-radius: 11px;
            background: #EFE5D9;
            color: #684936;
            font-size: 13px;
            font-weight: 800;
        }

        .bill-tenant-detail strong,
        .bill-tenant-detail small,
        .bill-room-detail strong,
        .bill-room-detail small {
            display: block;
        }

        .bill-tenant-detail strong,
        .bill-room-detail strong {
            color: #493126;
            font-size: 11px;
            font-weight: 800;
        }

        .bill-tenant-detail small,
        .bill-room-detail small {
            margin-top: 5px;
            color: #99877A;
            font-size: 10px;
        }

        .bill-period {
            color: #684936;
            font-weight: 700;
        }

        .bill-amount {
            color: #493126;
            font-weight: 800;
        }

        .bill-due-date {
            color: #806F63;
            font-weight: 600;
        }

        .bill-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 800;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .bill-status.paid {
            background: #EAF3E9;
            color: #47734A;
        }

        .bill-status.unpaid {
            background: #FFF0DF;
            color: #9A6330;
        }

        .bill-status.pending {
            background: #F0EAFA;
            color: #7655A1;
        }

        .bill-empty {
            padding: 60px 20px;
            text-align: center;
        }

        .bill-empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 65px;
            height: 65px;
            margin: 0 auto 17px;
            border-radius: 19px;
            background: #F7F2EB;
            color: #8B654D;
        }

        .bill-empty-icon svg {
            width: 29px;
            height: 29px;
        }

        .bill-empty h3 {
            margin: 0 0 8px;
            color: #493126;
            font-size: 16px;
            font-weight: 800;
        }

        .bill-empty p {
            max-width: 360px;
            margin: 0 auto 20px;
            color: #99877A;
            font-size: 11px;
            line-height: 1.8;
        }

        .bill-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 16px;
            margin-bottom: 20px;
            border-radius: 9px;
            font-size: 11px;
        }

        .bill-alert svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .bill-alert.success {
            color: #386A43;
            background: #EDF6ED;
            border: 1px solid #D5E9D5;
        }

        .bill-alert.error {
            display: block;
            color: #A33B35;
            background: #FFF1EF;
            border: 1px solid #F1D0CC;
        }

        .bill-alert ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .bill-footer {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 18px 3px 0;
            color: #A39488;
            font-size: 10px;
        }

        @media (max-width: 1100px) {
            .bill-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .bill-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .bill-heading h1 {
                font-size: 23px;
            }

            .bill-heading .bill-primary-button {
                width: 100%;
                box-sizing: border-box;
            }

            .bill-stat-grid {
                grid-template-columns: 1fr;
            }

            .bill-table-heading {
                padding: 18px;
            }

            .bill-footer {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</x-app-layout>

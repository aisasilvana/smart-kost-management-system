
<x-app-layout>
    <div class="sk-page">
        <div class="sk-container payment-page">

            {{-- HEADER --}}
            <div class="payment-heading">
                <div>
                    <span class="payment-eyebrow">FINANCIAL MANAGEMENT</span>
                    <h1>Manajemen Pembayaran</h1>
                    <p>Kelola dan verifikasi transaksi pembayaran penghuni kost Anda.</p>
                </div>

                <div class="payment-heading-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <path d="M2 10h20"/>
                        <path d="M7 15h3"/>
                    </svg>
                </div>
            </div>

            {{-- NOTIFICATIONS --}}
            @if(session('success'))
                <div class="payment-alert success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="payment-alert error">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="payment-alert error">
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- STATISTICS --}}
            <div class="payment-stat-grid">

                <div class="payment-stat-card">
                    <div class="payment-stat-top">
                        <div class="payment-stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round">
                                <rect x="3" y="3" width="18" height="18" rx="3"/>
                                <path d="M8 8h8M8 12h8M8 16h5"/>
                            </svg>
                        </div>
                        <span>TOTAL PEMBAYARAN</span>
                    </div>
                    <strong>{{ $totalPayments }}</strong>
                    <small>Seluruh transaksi tercatat</small>
                </div>

                <div class="payment-stat-card">
                    <div class="payment-stat-top">
                        <div class="payment-stat-icon pending-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>
                        </div>
                        <span>MENUNGGU VERIFIKASI</span>
                    </div>
                    <strong>{{ $pendingPayments }}</strong>
                    <small>Perlu diperiksa oleh Owner</small>
                </div>

                <div class="payment-stat-card">
                    <div class="payment-stat-top">
                        <div class="payment-stat-icon approved-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="m8 12 3 3 5-6"/>
                            </svg>
                        </div>
                        <span>DISETUJUI</span>
                    </div>
                    <strong>{{ $approvedPayments }}</strong>
                    <small>Pembayaran berhasil diverifikasi</small>
                </div>

                <div class="payment-stat-card">
                    <div class="payment-stat-top">
                        <div class="payment-stat-icon rejected-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="m9 9 6 6m0-6-6 6"/>
                            </svg>
                        </div>
                        <span>DITOLAK</span>
                    </div>
                    <strong>{{ $rejectedPayments }}</strong>
                    <small>Pembayaran tidak disetujui</small>
                </div>

            </div>

            {{-- PAYMENT LIST --}}
            <div class="payment-list-panel">

                <div class="payment-list-heading">
                    <div>
                        <span class="payment-section-label">TRANSACTION OVERVIEW</span>
                        <h2>Daftar Pembayaran</h2>
                        <p>Periksa detail transaksi dan lakukan verifikasi pembayaran penghuni.</p>
                    </div>

                    <span class="payment-count">
                        {{ $payments->count() }} Transaksi
                    </span>
                </div>

                <div class="payment-list-content">

                    @forelse($payments as $payment)

                        @php
                            $bill = $payment->bill;
                            $assignment = $bill?->roomAssignment;
                            $tenant = $assignment?->tenant;
                            $room = $assignment?->room;
                            $kost = $room?->kost;

                            $tenantName = $tenant?->user?->name
                                ?? 'Tenant tidak ditemukan';

                            $statusColors = [
                                'pending' => ['#FFF3DF', '#A66B13'],
                                'approved' => ['#EAF3E9', '#47734A'],
                                'rejected' => ['#FCEAE7', '#C65345'],
                            ];

                            $colors = $statusColors[$payment->status]
                                ?? ['#F1F1F1', '#555555'];

                            $billingMonth = $bill?->billing_month
                                ? \Carbon\Carbon::parse($bill->billing_month)->translatedFormat('F Y')
                                : '-';
                        @endphp

                        <article class="payment-card">

                            {{-- CARD HEADER --}}
                            <div class="payment-card-header">

                                <div class="payment-tenant">
                                    <div class="payment-avatar">
                                        {{ strtoupper(substr($tenantName, 0, 1)) }}
                                    </div>

                                    <div>
                                        <h3>{{ $tenantName }}</h3>
                                        <p>
                                            {{ $kost?->name ?? 'Kost tidak ditemukan' }}
                                            <span class="payment-separator">·</span>
                                            Kamar {{ $room?->room_number ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <span class="payment-status"
                                    style="background: {{ $colors[0] }}; color: {{ $colors[1] }};">
                                    <span class="payment-status-dot"
                                        style="background: {{ $colors[1] }};"></span>
                                    {{ ucfirst($payment->status) }}
                                </span>

                            </div>

                            {{-- PAYMENT DETAILS --}}
                            <div class="payment-details">

                                <div class="payment-detail-item">
                                    <span>Periode Tagihan</span>
                                    <strong>{{ $billingMonth }}</strong>
                                </div>

                                <div class="payment-detail-item">
                                    <span>Jumlah Pembayaran</span>
                                    <strong class="payment-amount">
                                        Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}
                                    </strong>
                                </div>

                                <div class="payment-detail-item">
                                    <span>Metode Pembayaran</span>
                                    <strong>
                                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                    </strong>
                                </div>

                                <div class="payment-detail-item">
                                    <span>Tanggal Pengiriman</span>
                                    <strong>
                                        {{ $payment->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </strong>
                                </div>

                            </div>

                            {{-- PAYMENT PROOF --}}
                            @if($payment->proof_path)

                                <div class="payment-proof-section">
                                    <div class="payment-proof-heading">
                                        <div class="payment-proof-icon">
                                            <svg viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.7"
                                                stroke-linecap="round">
                                                <rect x="3" y="3" width="18" height="18" rx="3"/>
                                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                                <path d="m21 15-5-5L5 21"/>
                                            </svg>
                                        </div>

                                        <div>
                                            <strong>Bukti Pembayaran</strong>
                                            <small>Dokumen yang dikirim oleh penghuni</small>
                                        </div>
                                    </div>

                                    <a
                                        href="{{ asset('storage/' . $payment->proof_path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="payment-proof-link"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $payment->proof_path) }}"
                                            alt="Bukti pembayaran {{ $tenantName }}"
                                        >

                                        <span>
                                            <svg viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round">
                                                <path d="M14 3h7v7M10 14 21 3"/>
                                                <path d="M19 13v7H4V5h7"/>
                                            </svg>
                                            Lihat ukuran penuh
                                        </span>
                                    </a>
                                </div>

                            @else

                                <div class="payment-no-proof">
                                    <svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.7"
                                        stroke-linecap="round">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 8v4m0 4h.01"/>
                                    </svg>
                                    Bukti pembayaran belum tersedia.
                                </div>

                            @endif

                            {{-- PENDING ACTIONS --}}
                            @if($payment->status === 'pending')

                                <div class="payment-action-section">

                                    <div class="payment-action-heading">
                                        <h4>Tindakan Verifikasi</h4>
                                        <p>Periksa bukti pembayaran sebelum mengambil keputusan.</p>
                                    </div>

                                    <div class="payment-actions">

                                        <form
                                            action="{{ route('owner.payments.verify', $payment->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menyetujui pembayaran ini?')"
                                        >
                                            @csrf

                                            <button type="submit" class="payment-approve-button">
                                                <svg viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round">
                                                    <path d="m5 12 4 4L19 6"/>
                                                </svg>
                                                Setujui Pembayaran
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('owner.payments.reject', $payment->id) }}"
                                            method="POST"
                                            class="payment-reject-form"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menolak pembayaran ini?')"
                                        >
                                            @csrf

                                            <input
                                                type="text"
                                                name="rejection_reason"
                                                placeholder="Masukkan alasan penolakan"
                                                value="{{ old('rejection_reason') }}"
                                                required
                                                maxlength="1000"
                                            >

                                            <button type="submit" class="payment-reject-button">
                                                Tolak Pembayaran
                                            </button>
                                        </form>

                                    </div>

                                </div>

                            {{-- APPROVED --}}
                            @elseif($payment->status === 'approved')

                                <div class="payment-result approved-result">
                                    <div class="payment-result-icon">
                                        <svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round">
                                            <path d="m5 12 4 4L19 6"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <strong>Pembayaran telah disetujui</strong>
                                        <p>
                                            Diverifikasi oleh
                                            {{ $payment->verifiedBy?->name ?? 'Owner' }}
                                            @if($payment->verified_at)
                                                pada {{ $payment->verified_at->format('d M Y, H:i') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                            {{-- REJECTED --}}
                            @elseif($payment->status === 'rejected')

                                <div class="payment-result rejected-result">
                                    <div class="payment-result-icon">
                                        <svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round">
                                            <path d="m9 9 6 6m0-6-6 6"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <strong>Pembayaran ditolak</strong>
                                        <p>
                                            Alasan:
                                            {{ $payment->rejection_reason ?? 'Tidak ada keterangan.' }}
                                        </p>
                                    </div>
                                </div>

                            @endif

                        </article>

                    @empty

                        <div class="payment-empty">
                            <div class="payment-empty-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                                    <path d="M2 10h20M7 15h3"/>
                                </svg>
                            </div>

                            <h3>Belum Ada Pembayaran</h3>
                            <p>
                                Pembayaran yang dikirim oleh penghuni akan muncul
                                di halaman ini dan siap untuk diverifikasi.
                            </p>
                        </div>

                    @endforelse

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="payment-footer">
                <span>Smart Kost Management System</span>
                <span>Payment Management</span>
            </div>

        </div>
    </div>

    <style>
        .payment-page {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 35px;
            font-family: 'Manrope', sans-serif;
            color: #493A30;
        }

        .payment-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 27px;
        }

        .payment-eyebrow,
        .payment-section-label {
            display: block;
            margin-bottom: 8px;
            color: #A87959;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.7px;
        }

        .payment-heading h1 {
            margin: 0 0 7px;
            color: #493126;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .payment-heading p {
            margin: 0;
            color: #99877A;
            font-size: 12px;
            line-height: 1.7;
        }

        .payment-heading-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            border-radius: 15px;
            background: #EFE5D9;
            color: #684936;
        }

        .payment-heading-icon svg {
            width: 25px;
            height: 25px;
        }

        .payment-alert {
            padding: 13px 16px;
            margin-bottom: 19px;
            border-radius: 10px;
            font-size: 11px;
            line-height: 1.7;
        }

        .payment-alert.success {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #D5E9D5;
            background: #EDF6ED;
            color: #386A43;
        }

        .payment-alert.success svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .payment-alert.error {
            border: 1px solid #F1D0CC;
            background: #FFF1EF;
            color: #A33B35;
        }

        .payment-alert ul {
            margin: 7px 0 0;
            padding-left: 19px;
        }

        .payment-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .payment-stat-card {
            min-width: 0;
            padding: 19px;
            border: 1px solid #E9DED3;
            border-radius: 13px;
            background: #FFFFFF;
            transition: .25s ease;
        }

        .payment-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 9px 22px rgba(73, 49, 38, .06);
        }

        .payment-stat-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .payment-stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 37px;
            height: 37px;
            flex-shrink: 0;
            border-radius: 10px;
            background: #F7F2EB;
            color: #8B654D;
        }

        .payment-stat-icon svg {
            width: 19px;
            height: 19px;
        }

        .payment-stat-icon.pending-icon {
            background: #FFF3E5;
            color: #A87532;
        }

        .payment-stat-icon.approved-icon {
            background: #EAF3E9;
            color: #47734A;
        }

        .payment-stat-icon.rejected-icon {
            background: #FCEAE7;
            color: #C65345;
        }

        .payment-stat-top span {
            color: #99877A;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .4px;
            line-height: 1.5;
        }

        .payment-stat-card > strong {
            display: block;
            margin-bottom: 5px;
            color: #493126;
            font-size: 27px;
            font-weight: 800;
        }

        .payment-stat-card > small {
            color: #99877A;
            font-size: 10px;
        }

        .payment-list-panel {
            overflow: hidden;
            border: 1px solid #E9DED3;
            border-radius: 15px;
            background: #FFFFFF;
        }

        .payment-list-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 22px;
            border-bottom: 1px solid #EEE5DC;
            flex-wrap: wrap;
        }

        .payment-section-label {
            margin-bottom: 6px;
            font-size: 9px;
        }

        .payment-list-heading h2 {
            margin: 0 0 6px;
            color: #493126;
            font-size: 16px;
            font-weight: 800;
        }

        .payment-list-heading p {
            margin: 0;
            color: #99877A;
            font-size: 11px;
            line-height: 1.7;
        }

        .payment-count {
            padding: 7px 12px;
            border-radius: 20px;
            background: #F7F2EB;
            color: #684936;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .payment-list-content {
            padding: 21px;
        }

        .payment-card {
            padding: 21px;
            margin-bottom: 17px;
            border: 1px solid #E9DED3;
            border-radius: 13px;
            background: #FFFFFF;
            transition: .25s ease;
        }

        .payment-card:last-child {
            margin-bottom: 0;
        }

        .payment-card:hover {
            border-color: #D9C5B3;
            box-shadow: 0 6px 18px rgba(73, 49, 38, .04);
        }

        .payment-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .payment-tenant {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .payment-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            background: #EFE5D9;
            color: #684936;
            font-size: 15px;
            font-weight: 800;
        }

        .payment-tenant h3 {
            margin: 0 0 5px;
            color: #493126;
            font-size: 13px;
            font-weight: 800;
        }

        .payment-tenant p {
            margin: 0;
            color: #99877A;
            font-size: 10px;
        }

        .payment-separator {
            padding: 0 4px;
        }

        .payment-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 800;
        }

        .payment-status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .payment-details {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-top: 22px;
            padding: 17px 0;
            border-top: 1px solid #F0E9E2;
            border-bottom: 1px solid #F0E9E2;
        }

        .payment-detail-item {
            min-width: 0;
        }

        .payment-detail-item > span {
            display: block;
            margin-bottom: 7px;
            color: #99877A;
            font-size: 10px;
        }

        .payment-detail-item > strong {
            display: block;
            color: #493126;
            font-size: 11px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .payment-detail-item .payment-amount {
            color: #684936;
            font-size: 13px;
        }

        .payment-proof-section {
            margin-top: 20px;
        }

        .payment-proof-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .payment-proof-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 10px;
            background: #F7F2EB;
            color: #8B654D;
        }

        .payment-proof-icon svg {
            width: 18px;
            height: 18px;
        }

        .payment-proof-heading strong,
        .payment-proof-heading small {
            display: block;
        }

        .payment-proof-heading strong {
            color: #493126;
            font-size: 11px;
            font-weight: 800;
        }

        .payment-proof-heading small {
            margin-top: 4px;
            color: #99877A;
            font-size: 9px;
        }

        .payment-proof-link {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 7px;
            text-decoration: none;
        }

        .payment-proof-link img {
            display: block;
            width: 210px;
            max-width: 100%;
            max-height: 170px;
            object-fit: cover;
            border: 1px solid #E9DED3;
            border-radius: 10px;
            transition: .2s ease;
        }

        .payment-proof-link:hover img {
            border-color: #B58B6B;
            opacity: .9;
        }

        .payment-proof-link span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #8B654D;
            font-size: 10px;
            font-weight: 700;
        }

        .payment-proof-link span svg {
            width: 13px;
            height: 13px;
        }

        .payment-no-proof {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 19px;
            padding: 12px;
            border-radius: 9px;
            background: #FAF5EF;
            color: #8B654D;
            font-size: 10px;
        }

        .payment-no-proof svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .payment-action-section {
            margin-top: 22px;
            padding-top: 19px;
            border-top: 1px solid #F0E9E2;
        }

        .payment-action-heading {
            margin-bottom: 13px;
        }

        .payment-action-heading h4 {
            margin: 0 0 5px;
            color: #493126;
            font-size: 11px;
            font-weight: 800;
        }

        .payment-action-heading p {
            margin: 0;
            color: #99877A;
            font-size: 10px;
        }

        .payment-actions {
            display: flex;
            align-items: center;
            gap: 11px;
            flex-wrap: wrap;
        }

        .payment-approve-button,
        .payment-reject-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 41px;
            padding: 0 16px;
            border: none;
            border-radius: 8px;
            font-family: 'Manrope', sans-serif;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s ease;
        }

        .payment-approve-button {
            background: #684936;
            color: #FFFFFF;
        }

        .payment-approve-button:hover {
            background: #493126;
            transform: translateY(-1px);
        }

        .payment-approve-button svg {
            width: 15px;
            height: 15px;
        }

        .payment-reject-form {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            flex: 1;
        }

        .payment-reject-form input {
            min-width: 190px;
            max-width: 300px;
            flex: 1;
            height: 41px;
            box-sizing: border-box;
            padding: 0 12px;
            border: 1px solid #E9DED3;
            border-radius: 8px;
            background: #FFFFFF;
            color: #493126;
            font-family: 'Manrope', sans-serif;
            font-size: 10px;
            outline: none;
        }

        .payment-reject-form input:focus {
            border-color: #B58B6B;
            box-shadow: 0 0 0 3px rgba(181, 139, 107, .12);
        }

        .payment-reject-button {
            background: #C65345;
            color: #FFFFFF;
        }

        .payment-reject-button:hover {
            background: #A83F34;
            transform: translateY(-1px);
        }

        .payment-result {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            margin-top: 20px;
            padding: 14px;
            border-radius: 10px;
        }

        .payment-result-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            flex-shrink: 0;
            border-radius: 9px;
        }

        .payment-result-icon svg {
            width: 17px;
            height: 17px;
        }

        .payment-result strong {
            display: block;
            margin-bottom: 5px;
            font-size: 11px;
            font-weight: 800;
        }

        .payment-result p {
            margin: 0;
            font-size: 10px;
            line-height: 1.7;
        }

        .approved-result {
            background: #EDF5EA;
            color: #47734A;
        }

        .approved-result .payment-result-icon {
            background: #DDEBDD;
        }

        .rejected-result {
            background: #FFF1EF;
            color: #A34E3D;
        }

        .rejected-result .payment-result-icon {
            background: #F5DEDA;
        }

        .payment-empty {
            padding: 55px 20px;
            text-align: center;
        }

        .payment-empty-icon {
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

        .payment-empty-icon svg {
            width: 29px;
            height: 29px;
        }

        .payment-empty h3 {
            margin: 0 0 8px;
            color: #493126;
            font-size: 15px;
            font-weight: 800;
        }

        .payment-empty p {
            max-width: 390px;
            margin: 0 auto;
            color: #99877A;
            font-size: 11px;
            line-height: 1.8;
        }

        .payment-footer {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 18px 3px 0;
            color: #A39488;
            font-size: 10px;
        }

        @media (max-width: 1000px) {
            .payment-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .payment-details {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .payment-heading h1 {
                font-size: 23px;
            }

            .payment-stat-grid {
                grid-template-columns: 1fr;
            }

            .payment-list-content {
                padding: 13px;
            }

            .payment-card {
                padding: 16px;
            }

            .payment-details {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 17px 10px;
            }

            .payment-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .payment-actions form {
                width: 100%;
            }

            .payment-approve-button,
            .payment-reject-button {
                width: 100%;
                box-sizing: border-box;
            }

            .payment-reject-form {
                flex-direction: column;
                align-items: stretch;
            }

            .payment-reject-form input {
                width: 100%;
                max-width: none;
            }

            .payment-footer {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</x-app-layout>


<x-app-layout>
    <div class="sk-page">
        <div class="sk-container tenant-payment-page">

            {{-- HEADER --}}
            <div class="tenant-payment-heading">
                <div>
                    <span class="tenant-payment-eyebrow">MY FINANCIAL OVERVIEW</span>
                    <h1>Tagihan & Pembayaran</h1>
                    <p>Pantau tagihan dan kelola pembayaran kost Anda dengan mudah.</p>
                </div>

                <div class="tenant-payment-heading-icon">
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
                <div class="tenant-payment-alert success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="tenant-payment-alert error">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="tenant-payment-alert error">
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- PAYMENT SUMMARY --}}
            @php
                $totalBills = $bills->count();
                $paidBills = $bills->where('status', 'paid')->count();
                $unpaidBills = $bills->where('status', '!=', 'paid')->count();

                $totalOutstanding = $bills
                    ->where('status', '!=', 'paid')
                    ->sum('amount');
            @endphp

            <div class="tenant-payment-summary">

                <div class="tenant-payment-stat">
                    <div class="tenant-payment-stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round">
                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                            <path d="M8 8h8M8 12h8M8 16h5"/>
                        </svg>
                    </div>
                    <span>Total Tagihan</span>
                    <strong>{{ $totalBills }}</strong>
                    <small>Seluruh tagihan Anda</small>
                </div>

                <div class="tenant-payment-stat">
                    <div class="tenant-payment-stat-icon paid">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="m8 12 3 3 5-6"/>
                        </svg>
                    </div>
                    <span>Tagihan Lunas</span>
                    <strong>{{ $paidBills }}</strong>
                    <small>Pembayaran telah disetujui</small>
                </div>

                <div class="tenant-payment-stat">
                    <div class="tenant-payment-stat-icon unpaid">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 2"/>
                        </svg>
                    </div>
                    <span>Belum Lunas</span>
                    <strong>{{ $unpaidBills }}</strong>
                    <small>Tagihan yang belum selesai</small>
                </div>

                <div class="tenant-payment-stat">
                    <div class="tenant-payment-stat-icon amount">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20"/>
                        </svg>
                    </div>
                    <span>Total Belum Dibayar</span>
                    <strong class="outstanding-amount">
                        Rp{{ number_format((float) $totalOutstanding, 0, ',', '.') }}
                    </strong>
                    <small>Akumulasi tagihan belum lunas</small>
                </div>

            </div>

            {{-- BILL LIST --}}
            <div class="tenant-payment-panel">

                <div class="tenant-payment-panel-heading">
                    <div>
                        <span class="tenant-payment-section-label">BILLING OVERVIEW</span>
                        <h2>Daftar Tagihan</h2>
                        <p>Informasi tagihan bulanan dan riwayat pembayaran Anda.</p>
                    </div>

                    <span class="tenant-payment-count">
                        {{ $totalBills }} Tagihan
                    </span>
                </div>

                <div class="tenant-payment-list">

                    @forelse($bills as $bill)

                        @php
                            $latestPayment = $bill->payments
                                ->sortByDesc('created_at')
                                ->first();

                            $room = $bill->roomAssignment?->room;
                            $kost = $room?->kost;

                            $billingMonth = \Carbon\Carbon::parse(
                                $bill->billing_month
                            )->translatedFormat('F Y');

                            $dueDate = \Carbon\Carbon::parse(
                                $bill->due_date
                            );

                            $isOverdue = $bill->status !== 'paid'
                                && $dueDate->isPast()
                                && !$dueDate->isToday();

                            if ($bill->status === 'paid') {
                                $statusLabel = 'Lunas';
                                $statusClass = 'paid';
                            } elseif ($latestPayment?->status === 'pending') {
                                $statusLabel = 'Menunggu Verifikasi';
                                $statusClass = 'pending';
                            } elseif ($latestPayment?->status === 'rejected') {
                                $statusLabel = 'Ditolak';
                                $statusClass = 'rejected';
                            } elseif ($isOverdue) {
                                $statusLabel = 'Terlambat';
                                $statusClass = 'overdue';
                            } else {
                                $statusLabel = 'Belum Dibayar';
                                $statusClass = 'unpaid';
                            }
                        @endphp

                        <article class="tenant-bill-card">

                            {{-- BILL HEADER --}}
                            <div class="tenant-bill-header">

                                <div class="tenant-bill-title">
                                    <div class="tenant-bill-icon">
                                        <svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.7"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="4" y="3" width="16" height="18" rx="2"/>
                                            <path d="M8 8h8M8 12h8M8 16h4"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <span class="tenant-bill-label">TAGIHAN BULANAN</span>
                                        <h3>{{ $billingMonth }}</h3>
                                    </div>
                                </div>

                                <span class="tenant-bill-status {{ $statusClass }}">
                                    <span></span>
                                    {{ $statusLabel }}
                                </span>

                            </div>

                            {{-- BILL INFORMATION --}}
                            <div class="tenant-bill-information">

                                <div>
                                    <span>Nama Kost</span>
                                    <strong>{{ $kost?->name ?? '-' }}</strong>
                                </div>

                                <div>
                                    <span>Nomor Kamar</span>
                                    <strong>{{ $room?->room_number ?? '-' }}</strong>
                                </div>

                                <div>
                                    <span>Jatuh Tempo</span>
                                    <strong class="{{ $isOverdue ? 'overdue-text' : '' }}">
                                        {{ $dueDate->format('d M Y') }}
                                    </strong>
                                </div>

                            </div>

                            {{-- AMOUNT --}}
                            <div class="tenant-bill-amount">
                                <span>Total Tagihan</span>
                                <strong>
                                    Rp{{ number_format((float) $bill->amount, 0, ',', '.') }}
                                </strong>
                            </div>

                            {{-- PAID --}}
                            @if($bill->status === 'paid')

                                <div class="tenant-payment-result paid-result">
                                    <div class="tenant-payment-result-icon">
                                        <svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round">
                                            <path d="m5 12 4 4L19 6"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <strong>Pembayaran Berhasil</strong>
                                        <p>
                                            Tagihan ini telah lunas dan diverifikasi oleh Owner.
                                        </p>
                                    </div>
                                </div>

                            {{-- PENDING --}}
                            @elseif($latestPayment && $latestPayment->status === 'pending')

                                <div class="tenant-payment-result pending-result">
                                    <div class="tenant-payment-result-icon">
                                        <svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M12 7v5l3 2"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <strong>Menunggu Verifikasi Owner</strong>
                                        <p>
                                            Bukti pembayaran Anda telah dikirim.
                                            Silakan tunggu proses verifikasi.
                                        </p>
                                    </div>
                                </div>

                                @if($latestPayment->proof_path)
                                    <a
                                        href="{{ asset('storage/' . $latestPayment->proof_path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="tenant-proof-link"
                                    >
                                        <svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round">
                                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <path d="m21 15-5-5L5 21"/>
                                        </svg>
                                        Lihat bukti pembayaran
                                    </a>
                                @endif

                            {{-- REJECTED OR UNPAID --}}
                            @else

                                @if($latestPayment && $latestPayment->status === 'rejected')

                                    <div class="tenant-payment-result rejected-result">
                                        <div class="tenant-payment-result-icon">
                                            <svg viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round">
                                                <path d="m9 9 6 6m0-6-6 6"/>
                                            </svg>
                                        </div>

                                        <div>
                                            <strong>Pembayaran Ditolak</strong>
                                            <p>
                                                Alasan:
                                                {{ $latestPayment->rejection_reason ?? 'Tidak ada keterangan.' }}
                                            </p>
                                            <small>
                                                Silakan kirim ulang bukti pembayaran yang benar.
                                            </small>
                                        </div>
                                    </div>

                                @endif

                                {{-- PAYMENT FORM --}}
                                <div class="tenant-payment-form-section">

                                    <div class="tenant-payment-form-heading">
                                        <div>
                                            <span class="tenant-payment-section-label">
                                                PAYMENT SUBMISSION
                                            </span>
                                            <h4>Kirim Bukti Pembayaran</h4>
                                            <p>
                                                Pastikan pembayaran sudah dilakukan
                                                sebelum mengunggah bukti transaksi.
                                            </p>
                                        </div>
                                    </div>

                                    <form
                                        method="POST"
                                        action="{{ route('tenant.payments.store', $bill) }}"
                                        enctype="multipart/form-data"
                                        class="tenant-payment-form"
                                    >
                                        @csrf

                                        <div class="tenant-form-group">
                                            <label for="payment_method_{{ $bill->id }}">
                                                Metode Pembayaran
                                            </label>

                                            <select
                                                name="payment_method"
                                                id="payment_method_{{ $bill->id }}"
                                                required
                                            >
                                                <option value="">Pilih metode pembayaran</option>
                                                <option value="bank_transfer"
                                                    {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>
                                                    Transfer Bank
                                                </option>
                                                <option value="e_wallet"
                                                    {{ old('payment_method') === 'e_wallet' ? 'selected' : '' }}>
                                                    E-Wallet
                                                </option>
                                                <option value="cash"
                                                    {{ old('payment_method') === 'cash' ? 'selected' : '' }}>
                                                    Tunai
                                                </option>
                                            </select>
                                        </div>

                                        <div class="tenant-form-group">
                                            <label for="proof_{{ $bill->id }}">
                                                Bukti Pembayaran
                                            </label>

                                            <div class="tenant-file-wrapper">
                                                <input
                                                    type="file"
                                                    name="proof"
                                                    id="proof_{{ $bill->id }}"
                                                    accept=".jpg,.jpeg,.png"
                                                    required
                                                >
                                            </div>

                                            <small>
                                                Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                                            </small>
                                        </div>

                                        <button type="submit" class="tenant-submit-button">
                                            <svg viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M22 2 11 13"/>
                                                <path d="m22 2-7 20-4-9-9-4 20-7Z"/>
                                            </svg>
                                            Kirim Bukti Pembayaran
                                        </button>

                                    </form>
                                </div>

                            @endif

                        </article>

                    @empty

                        <div class="tenant-payment-empty">
                            <div class="tenant-payment-empty-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.6"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="4" y="3" width="16" height="18" rx="2"/>
                                    <path d="M8 8h8M8 12h8M8 16h4"/>
                                </svg>
                            </div>

                            <h3>Belum Ada Tagihan</h3>
                            <p>
                                Tagihan bulanan Anda akan muncul di halaman ini
                                setelah Owner membuat tagihan.
                            </p>
                        </div>

                    @endforelse

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="tenant-payment-footer">
                <span>Smart Kost Management System</span>
                <span>Tenant Payment Center</span>
            </div>

        </div>
    </div>

    <style>
        .tenant-payment-page {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 35px;
            font-family: 'Manrope', sans-serif;
            color: #493A30;
        }

        .tenant-payment-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 27px;
        }

        .tenant-payment-eyebrow,
        .tenant-payment-section-label {
            display: block;
            margin-bottom: 7px;
            color: #A87959;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .tenant-payment-heading h1 {
            margin: 0 0 7px;
            color: #493126;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .tenant-payment-heading p {
            margin: 0;
            color: #99877A;
            font-size: 12px;
            line-height: 1.7;
        }

        .tenant-payment-heading-icon {
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

        .tenant-payment-heading-icon svg {
            width: 25px;
            height: 25px;
        }

        .tenant-payment-alert {
            padding: 13px 16px;
            margin-bottom: 19px;
            border-radius: 10px;
            font-size: 11px;
            line-height: 1.7;
        }

        .tenant-payment-alert.success {
            display: flex;
            align-items: center;
            gap: 9px;
            border: 1px solid #D5E9D5;
            background: #EDF6ED;
            color: #386A43;
        }

        .tenant-payment-alert.success svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .tenant-payment-alert.error {
            border: 1px solid #F1D0CC;
            background: #FFF1EF;
            color: #A33B35;
        }

        .tenant-payment-alert ul {
            margin: 7px 0 0;
            padding-left: 19px;
        }

        .tenant-payment-summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .tenant-payment-stat {
            min-width: 0;
            padding: 19px;
            border: 1px solid #E9DED3;
            border-radius: 13px;
            background: #FFFFFF;
            transition: .25s ease;
        }

        .tenant-payment-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 9px 22px rgba(73, 49, 38, .06);
        }

        .tenant-payment-stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 37px;
            height: 37px;
            margin-bottom: 13px;
            border-radius: 10px;
            background: #F7F2EB;
            color: #8B654D;
        }

        .tenant-payment-stat-icon svg {
            width: 19px;
            height: 19px;
        }

        .tenant-payment-stat-icon.paid {
            background: #EAF3E9;
            color: #47734A;
        }

        .tenant-payment-stat-icon.unpaid {
            background: #FFF3E5;
            color: #A87532;
        }

        .tenant-payment-stat-icon.amount {
            background: #EFE5D9;
            color: #684936;
        }

        .tenant-payment-stat > span {
            display: block;
            margin-bottom: 7px;
            color: #99877A;
            font-size: 10px;
            font-weight: 700;
        }

        .tenant-payment-stat > strong {
            display: block;
            margin-bottom: 5px;
            color: #493126;
            font-size: 26px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .tenant-payment-stat > strong.outstanding-amount {
            font-size: 19px;
        }

        .tenant-payment-stat > small {
            color: #99877A;
            font-size: 9px;
        }

        .tenant-payment-panel {
            overflow: hidden;
            border: 1px solid #E9DED3;
            border-radius: 15px;
            background: #FFFFFF;
        }

        .tenant-payment-panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 22px;
            border-bottom: 1px solid #EEE5DC;
            flex-wrap: wrap;
        }

        .tenant-payment-section-label {
            margin-bottom: 6px;
            font-size: 9px;
        }

        .tenant-payment-panel-heading h2 {
            margin: 0 0 6px;
            color: #493126;
            font-size: 16px;
            font-weight: 800;
        }

        .tenant-payment-panel-heading p {
            margin: 0;
            color: #99877A;
            font-size: 11px;
            line-height: 1.7;
        }

        .tenant-payment-count {
            padding: 7px 12px;
            border-radius: 20px;
            background: #F7F2EB;
            color: #684936;
            font-size: 10px;
            font-weight: 800;
        }

        .tenant-payment-list {
            padding: 21px;
        }

        .tenant-bill-card {
            padding: 21px;
            margin-bottom: 17px;
            border: 1px solid #E9DED3;
            border-radius: 13px;
            background: #FFFFFF;
            transition: .25s ease;
        }

        .tenant-bill-card:last-child {
            margin-bottom: 0;
        }

        .tenant-bill-card:hover {
            border-color: #D9C5B3;
            box-shadow: 0 6px 18px rgba(73, 49, 38, .04);
        }

        .tenant-bill-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .tenant-bill-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .tenant-bill-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            background: #EFE5D9;
            color: #684936;
        }

        .tenant-bill-icon svg {
            width: 21px;
            height: 21px;
        }

        .tenant-bill-label {
            display: block;
            margin-bottom: 4px;
            color: #A87959;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .tenant-bill-title h3 {
            margin: 0;
            color: #493126;
            font-size: 17px;
            font-weight: 800;
        }

        .tenant-bill-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 800;
        }

        .tenant-bill-status > span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .tenant-bill-status.paid {
            background: #EAF3E9;
            color: #47734A;
        }

        .tenant-bill-status.pending {
            background: #FFF3DF;
            color: #A66B13;
        }

        .tenant-bill-status.rejected {
            background: #FCEAE7;
            color: #C65345;
        }

        .tenant-bill-status.unpaid {
            background: #F1EEE9;
            color: #806C5D;
        }

        .tenant-bill-status.overdue {
            background: #FCEAE7;
            color: #C65345;
        }

        .tenant-bill-information {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 21px;
            padding: 17px 0;
            border-top: 1px solid #F0E9E2;
            border-bottom: 1px solid #F0E9E2;
        }

        .tenant-bill-information span,
        .tenant-bill-information strong {
            display: block;
        }

        .tenant-bill-information span {
            margin-bottom: 7px;
            color: #99877A;
            font-size: 10px;
        }

        .tenant-bill-information strong {
            color: #493126;
            font-size: 11px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .tenant-bill-information strong.overdue-text {
            color: #C65345;
        }

        .tenant-bill-amount {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 18px 0 3px;
        }

        .tenant-bill-amount span {
            color: #99877A;
            font-size: 11px;
            font-weight: 700;
        }

        .tenant-bill-amount strong {
            color: #684936;
            font-size: 20px;
            font-weight: 800;
        }

        .tenant-payment-result {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            margin-top: 20px;
            padding: 14px;
            border-radius: 10px;
        }

        .tenant-payment-result-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            flex-shrink: 0;
            border-radius: 9px;
        }

        .tenant-payment-result-icon svg {
            width: 17px;
            height: 17px;
        }

        .tenant-payment-result strong {
            display: block;
            margin-bottom: 5px;
            font-size: 11px;
            font-weight: 800;
        }

        .tenant-payment-result p {
            margin: 0;
            font-size: 10px;
            line-height: 1.7;
        }

        .tenant-payment-result small {
            display: block;
            margin-top: 5px;
            font-size: 9px;
            line-height: 1.7;
        }

        .paid-result {
            background: #EDF5EA;
            color: #47734A;
        }

        .paid-result .tenant-payment-result-icon {
            background: #DDEBDD;
        }

        .pending-result {
            background: #FFF6E8;
            color: #986B2C;
        }

        .pending-result .tenant-payment-result-icon {
            background: #F9E9C9;
        }

        .rejected-result {
            background: #FFF1EF;
            color: #A34E3D;
        }

        .rejected-result .tenant-payment-result-icon {
            background: #F5DEDA;
        }

        .tenant-proof-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 12px;
            color: #8B654D;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
        }

        .tenant-proof-link:hover {
            color: #493126;
            text-decoration: underline;
        }

        .tenant-proof-link svg {
            width: 16px;
            height: 16px;
        }

        .tenant-payment-form-section {
            margin-top: 23px;
            padding-top: 20px;
            border-top: 1px solid #F0E9E2;
        }

        .tenant-payment-form-heading h4 {
            margin: 0 0 6px;
            color: #493126;
            font-size: 14px;
            font-weight: 800;
        }

        .tenant-payment-form-heading p {
            margin: 0;
            color: #99877A;
            font-size: 10px;
            line-height: 1.7;
        }

        .tenant-payment-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 17px;
            margin-top: 19px;
        }

        .tenant-form-group {
            min-width: 0;
        }

        .tenant-form-group label {
            display: block;
            margin-bottom: 8px;
            color: #493126;
            font-size: 10px;
            font-weight: 800;
        }

        .tenant-form-group select,
        .tenant-form-group input[type="file"] {
            width: 100%;
            min-height: 43px;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #E9DED3;
            border-radius: 8px;
            background: #FFFFFF;
            color: #493A30;
            font-family: 'Manrope', sans-serif;
            font-size: 10px;
            outline: none;
        }

        .tenant-form-group select:focus,
        .tenant-form-group input[type="file"]:focus {
            border-color: #B58B6B;
            box-shadow: 0 0 0 3px rgba(181, 139, 107, .12);
        }

        .tenant-form-group > small {
            display: block;
            margin-top: 7px;
            color: #99877A;
            font-size: 9px;
        }

        .tenant-file-wrapper {
            width: 100%;
        }

        .tenant-submit-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 43px;
            align-self: end;
            padding: 0 18px;
            border: none;
            border-radius: 8px;
            background: #684936;
            color: #FFFFFF;
            font-family: 'Manrope', sans-serif;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s ease;
        }

        .tenant-submit-button:hover {
            background: #493126;
            transform: translateY(-1px);
        }

        .tenant-submit-button svg {
            width: 15px;
            height: 15px;
        }

        .tenant-payment-empty {
            padding: 55px 20px;
            text-align: center;
        }

        .tenant-payment-empty-icon {
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

        .tenant-payment-empty-icon svg {
            width: 29px;
            height: 29px;
        }

        .tenant-payment-empty h3 {
            margin: 0 0 8px;
            color: #493126;
            font-size: 15px;
            font-weight: 800;
        }

        .tenant-payment-empty p {
            max-width: 390px;
            margin: 0 auto;
            color: #99877A;
            font-size: 11px;
            line-height: 1.8;
        }

        .tenant-payment-footer {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 18px 3px 0;
            color: #A39488;
            font-size: 10px;
        }

        @media (max-width: 1000px) {
            .tenant-payment-summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .tenant-payment-heading h1 {
                font-size: 23px;
            }

            .tenant-payment-summary {
                grid-template-columns: 1fr;
            }

            .tenant-payment-list {
                padding: 13px;
            }

            .tenant-bill-card {
                padding: 16px;
            }

            .tenant-bill-information {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .tenant-payment-form {
                grid-template-columns: 1fr;
            }

            .tenant-submit-button {
                width: 100%;
            }

            .tenant-payment-footer {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</x-app-layout>

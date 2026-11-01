<x-app-layout>
    <div class="sk-page">
        <div class="sk-container">

            <!-- TOP HEADER -->
            <div class="sk-topbar" style="margin: -34px -42px 30px;">
                <div>
                    <div class="sk-topbar-title">Dashboard</div>
                    <div class="sk-topbar-subtitle">Overview properti Anda</div>
                </div>

                <div class="sk-topbar-user">
                    <span class="sk-user-indicator"></span>
                    {{ Auth::user()->name }}
                </div>
            </div>

            <!-- HERO -->
            <section class="sk-hero">
                <div class="sk-hero-content">
                    <div class="sk-eyebrow">WELCOME TO SMART KOST</div>

                    <h1>
                        Ruang nyaman,<br>
                        pengelolaan lebih mudah.
                    </h1>

                    <p>
                        Selamat datang, {{ Auth::user()->name }}.
                        Kelola properti, kamar, dan penghuni Anda
                        dalam satu tempat dengan Smart Kost.
                    </p>

                    <a href="{{ route('owner.kosts.index') }}" class="sk-hero-button">
                        Jelajahi Properti
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                <div class="sk-hero-decoration" aria-hidden="true"></div>
            </section>

            <!-- PROPERTY STATISTICS -->
            <section class="sk-section">
                <div class="sk-section-header">
                    <div>
                        <h2 class="sk-section-heading">Ringkasan Properti</h2>
                        <p class="sk-section-description">
                            Pantau kondisi properti Anda hari ini.
                        </p>
                    </div>
                </div>

                <div class="sk-stat-grid">

                    <div class="sk-stat-card">
                        <div class="sk-stat-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 10.5 12 3l9 7.5"></path>
                                <path d="M5.5 9.5V21h13V9.5"></path>
                                <path d="M9 21v-7h6v7"></path>
                            </svg>
                        </div>
                        <div class="sk-stat-number">{{ $kosts }}</div>
                        <div class="sk-stat-label">Total Properti Kost</div>
                        <div class="sk-stat-caption">Properti terdaftar</div>
                    </div>

                    <div class="sk-stat-card">
                        <div class="sk-stat-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="4" y="4" width="16" height="16" rx="1"></rect>
                                <path d="M4 9h16M4 14h16M9 4v16M14 4v16"></path>
                            </svg>
                        </div>
                        <div class="sk-stat-number">{{ $rooms }}</div>
                        <div class="sk-stat-label">Total Kamar</div>
                        <div class="sk-stat-caption">Seluruh kamar properti</div>
                    </div>

                    <div class="sk-stat-card">
                        <div class="sk-stat-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="8" r="3.5"></circle>
                                <path d="M5 21v-2a7 7 0 0 1 14 0v2"></path>
                            </svg>
                        </div>
                        <div class="sk-stat-number">{{ $tenants }}</div>
                        <div class="sk-stat-label">Total Penghuni</div>
                        <div class="sk-stat-caption">Penghuni terdaftar</div>
                    </div>

                    <div class="sk-stat-card">
                        <div class="sk-stat-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m4 12 5 5L20 6"></path>
                            </svg>
                        </div>
                        <div class="sk-stat-number">{{ $availableRooms }}</div>
                        <div class="sk-stat-label">Kamar Tersedia</div>
                        <div class="sk-stat-caption">Siap untuk disewakan</div>
                    </div>

                </div>
            </section>

            <!-- FINANCIAL OVERVIEW -->
            <section class="sk-section">
                <div class="sk-section-header">
                    <div>
                        <h2 class="sk-section-heading">Ringkasan Keuangan</h2>
                        <p class="sk-section-description">
                            Informasi pemasukan dan aktivitas pembayaran bulan ini.
                        </p>
                    </div>
                    <span class="sk-period-label">
                        {{ now()->translatedFormat('F Y') }}
                    </span>
                </div>

                <div class="sk-finance-grid">

                    <div class="sk-finance-card sk-finance-primary">
                        <div class="sk-finance-top">
                            <div class="sk-finance-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2v20"></path>
                                    <path d="M17 6H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <span class="sk-finance-overline">PEMASUKAN</span>
                        </div>

                        <div class="sk-finance-label">Pemasukan Bulan Ini</div>
                        <div class="sk-finance-value">
                            Rp {{ number_format((float) $monthlyIncome, 0, ',', '.') }}
                        </div>
                        <div class="sk-finance-note">
                            Total pembayaran yang telah disetujui
                        </div>

                        <a href="{{ route('owner.income.index') }}" class="sk-finance-link">
                            Lihat Rekap Pemasukan <span>→</span>
                        </a>
                    </div>

                    <div class="sk-finance-card">
                        <div class="sk-finance-top">
                            <div class="sk-finance-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M4 5h16v14H4z"></path>
                                    <path d="M8 9h8M8 13h5"></path>
                                    <path d="m15 16 2 2 4-4"></path>
                                </svg>
                            </div>
                            <span class="sk-finance-overline">TRANSAKSI</span>
                        </div>

                        <div class="sk-finance-label">Transaksi Berhasil</div>
                        <div class="sk-finance-value">
                            {{ $monthlyTransactions }}
                        </div>
                        <div class="sk-finance-note">
                            Pembayaran disetujui bulan ini
                        </div>

                        <a href="{{ route('owner.payments.index') }}" class="sk-finance-link">
                            Lihat Pembayaran <span>→</span>
                        </a>
                    </div>

                    <div class="sk-finance-card">
                        <div class="sk-finance-top">
                            <div class="sk-finance-icon sk-finance-icon-warning">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M12 7v5l3 2"></path>
                                </svg>
                            </div>
                            <span class="sk-finance-overline">PERLU DIPERIKSA</span>
                        </div>

                        <div class="sk-finance-label">Menunggu Verifikasi</div>
                        <div class="sk-finance-value sk-finance-value-warning">
                            {{ $pendingPayments }}
                        </div>
                        <div class="sk-finance-note">
                            Pembayaran belum diproses
                        </div>

                        <a href="{{ route('owner.payments.index') }}" class="sk-finance-link">
                            Periksa Pembayaran <span>→</span>
                        </a>
                    </div>

                </div>
            </section>

            <!-- ROOM OCCUPANCY -->
            <section class="sk-section">
                <div class="sk-section-header">
                    <div>
                        <h2 class="sk-section-heading">Tingkat Keterisian Kamar</h2>
                        <p class="sk-section-description">
                            Pantau penggunaan kamar pada seluruh properti Anda.
                        </p>
                    </div>
                </div>

                <div class="sk-occupancy-card">
                    <div class="sk-occupancy-top">
                        <div>
                            <div class="sk-occupancy-label">Persentase Keterisian</div>
                            <div class="sk-occupancy-percentage">
                                {{ number_format($occupancyRate, 1, ',', '.') }}%
                            </div>
                        </div>

                        <div class="sk-occupancy-total">
                            <div class="sk-occupancy-label">Kamar Terisi</div>
                            <div class="sk-occupancy-count">
                                {{ $occupiedRooms }} <span>/ {{ $rooms }}</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="sk-progress-track"
                        role="progressbar"
                        aria-label="Persentase keterisian kamar"
                        aria-valuenow="{{ min(100, max(0, $occupancyRate)) }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    >
                        <div
                            class="sk-progress-bar"
                            style="width: {{ min(100, max(0, $occupancyRate)) }}%;"
                        ></div>
                    </div>

                    <div class="sk-occupancy-legend">
                        <div>
                            <span class="sk-legend-dot sk-legend-occupied"></span>
                            {{ $occupiedRooms }} kamar terisi
                        </div>
                        <div>
                            <span class="sk-legend-dot sk-legend-available"></span>
                            {{ $availableRooms }} kamar tersedia
                        </div>
                    </div>
                </div>
            </section>

            <!-- QUICK ACCESS -->
            <section class="sk-section">
                <div class="sk-section-header">
                    <div>
                        <h2 class="sk-section-heading">Kelola Smart Kost</h2>
                        <p class="sk-section-description">
                            Semua kebutuhan pengelolaan kost dalam satu tempat.
                        </p>
                    </div>
                </div>

                <div class="sk-quick-grid">

                    <a href="{{ route('owner.kosts.index') }}" class="sk-card">
                        <div class="sk-card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 10.5 12 3l9 7.5"></path>
                                <path d="M5.5 9.5V21h13V9.5"></path>
                                <path d="M9 21v-7h6v7"></path>
                            </svg>
                        </div>
                        <h3 class="sk-card-title">Manajemen Kost</h3>
                        <p class="sk-card-description">
                            Kelola informasi properti, nama kost, alamat, dan deskripsi.
                        </p>
                        <div class="sk-card-link">
                            Kelola Properti <span>→</span>
                        </div>
                    </a>

                    <a href="{{ route('owner.kosts.index') }}" class="sk-card">
                        <div class="sk-card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 19V8"></path>
                                <path d="M21 19V8"></path>
                                <path d="M3 13h18"></path>
                                <path d="M5 8V5h5v8"></path>
                                <path d="M10 10h9a2 2 0 0 1 2 2v7H3"></path>
                            </svg>
                        </div>
                        <h3 class="sk-card-title">Manajemen Kamar</h3>
                        <p class="sk-card-description">
                            Atur nomor kamar, harga sewa, dan ketersediaan kamar.
                        </p>
                        <div class="sk-card-link">
                            Pilih Properti untuk Kelola Kamar <span>→</span>
                        </div>
                    </a>

                    <a href="{{ route('owner.tenants.index') }}" class="sk-card">
                        <div class="sk-card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="8" r="3.5"></circle>
                                <path d="M5 21v-2a7 7 0 0 1 14 0v2"></path>
                            </svg>
                        </div>
                        <h3 class="sk-card-title">Manajemen Penghuni</h3>
                        <p class="sk-card-description">
                            Lihat dan kelola informasi penghuni yang terdaftar.
                        </p>
                        <div class="sk-card-link">
                            Kelola Penghuni <span>→</span>
                        </div>
                    </a>

                    <a href="{{ route('owner.bills.index') }}" class="sk-card">
                        <div class="sk-card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"></path>
                                <path d="M9 8h6M9 12h6M9 16h3"></path>
                            </svg>
                        </div>
                        <h3 class="sk-card-title">Manajemen Tagihan</h3>
                        <p class="sk-card-description">
                            Kelola tagihan sewa dan pantau status pembayaran penghuni.
                        </p>
                        <div class="sk-card-link">
                            Kelola Tagihan <span>→</span>
                        </div>
                    </a>

                    <a href="{{ route('owner.payments.index') }}" class="sk-card">
                        <div class="sk-card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                <path d="M3 10h18"></path>
                                <path d="m8 15 2 2 4-4"></path>
                            </svg>
                        </div>
                        <h3 class="sk-card-title">Verifikasi Pembayaran</h3>
                        <p class="sk-card-description">
                            Periksa bukti pembayaran dan proses verifikasi transaksi.
                        </p>
                        <div class="sk-card-link">
                            Periksa Pembayaran <span>→</span>
                        </div>
                    </a>

                    <a href="{{ route('owner.income.index') }}" class="sk-card">
                        <div class="sk-card-icon">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4 19V5"></path>
                                <path d="M4 19h17"></path>
                                <path d="m7 15 4-4 3 2 6-7"></path>
                                <path d="M16 6h4v4"></path>
                            </svg>
                        </div>
                        <h3 class="sk-card-title">Rekap Pemasukan</h3>
                        <p class="sk-card-description">
                            Pantau pemasukan, grafik keuangan, dan unduh laporan PDF maupun Excel.
                        </p>
                        <div class="sk-card-link">
                            Lihat Laporan <span>→</span>
                        </div>
                    </a>

                </div>
            </section>

            <!-- RECENT PAYMENT ACTIVITY -->
            <section class="sk-section">
                <div class="sk-section-header sk-activity-header">
                    <div>
                        <h2 class="sk-section-heading">Aktivitas Pembayaran Terbaru</h2>
                        <p class="sk-section-description">
                            Lima transaksi terbaru pada seluruh properti Anda.
                        </p>
                    </div>

                    <a href="{{ route('owner.payments.index') }}" class="sk-view-all">
                        Lihat Semua <span>→</span>
                    </a>
                </div>

                <div class="sk-activity-card">
                    @forelse($recentPayments as $payment)
                        @php
                            $bill = $payment->bill;
                            $assignment = $bill?->roomAssignment;
                            $tenant = $assignment?->tenant;
                            $room = $assignment?->room;
                            $kost = $room?->kost;

                            $statusColors = [
                                'approved' => ['approved', 'Disetujui'],
                                'pending' => ['pending', 'Menunggu'],
                                'rejected' => ['rejected', 'Ditolak'],
                            ];

                            $statusStyle = $statusColors[$payment->status]
                                ?? ['default', ucfirst($payment->status)];
                        @endphp

                        <div class="sk-activity-item">
                            <div class="sk-activity-person">
                                <div class="sk-activity-avatar">
                                    {{ strtoupper(substr($tenant?->user?->name ?? 'T', 0, 1)) }}
                                </div>

                                <div class="sk-activity-details">
                                    <div class="sk-activity-name">
                                        {{ $tenant?->user?->name ?? 'Tenant tidak ditemukan' }}
                                    </div>

                                    <div class="sk-activity-property">
                                        {{ $kost?->name ?? '-' }}
                                        <span>·</span>
                                        Kamar {{ $room?->room_number ?? '-' }}
                                    </div>

                                    <div class="sk-activity-meta">
                                        Transaksi #{{ $payment->id }}
                                        ·
                                        {{ $payment->created_at?->format('d M Y, H:i') ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="sk-activity-payment">
                                <div class="sk-activity-amount">
                                    Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}
                                </div>

                                <span class="sk-status-badge sk-status-{{ $statusStyle[0] }}">
                                    {{ $statusStyle[1] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="sk-empty-state">
                            <div class="sk-empty-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="4" y="3" width="16" height="18" rx="2"></rect>
                                    <path d="M8 8h8M8 12h8M8 16h5"></path>
                                </svg>
                            </div>

                            <h3>Belum Ada Aktivitas Pembayaran</h3>
                            <p>Transaksi pembayaran akan muncul di sini.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- FOOTER -->
            <footer class="sk-footer">
                <strong class="sk-footer-brand">smartkost.</strong>
                <span>Your space, beautifully managed.</span>
                <div>© {{ date('Y') }} Smart Kost Management System</div>
            </footer>

        </div>
    </div>
</x-app-layout>
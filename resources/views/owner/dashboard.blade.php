
<x-app-layout>

    <div class="sk-page">
        <div class="sk-container">

            <!-- TOP HEADER -->
            <div class="sk-topbar"
                 style="margin: -34px -42px 30px;">

                <div>
                    <div class="sk-topbar-title">Dashboard</div>
                    <div style="font-size: 11px; color: #99877A; margin-top: 3px;">
                        Overview properti Anda
                    </div>
                </div>

                <div class="sk-topbar-user">
                    {{ Auth::user()->name }}
                </div>

            </div>


            <!-- HERO -->
            <section class="sk-hero">

                <div class="sk-hero-content">

                    <div class="sk-eyebrow">
                        WELCOME TO SMART KOST
                    </div>

                    <h1>
                        Ruang nyaman,<br>
                        pengelolaan lebih mudah.
                    </h1>

                    <p>
                        Selamat datang, {{ Auth::user()->name }}.
                        Kelola properti, kamar, dan penghuni Anda
                        dalam satu tempat dengan Smart Kost.
                    </p>

                    <a href="{{ route('owner.kosts.index') }}"
                       class="sk-hero-button">
                        Jelajahi Properti &nbsp; →
                    </a>

                </div>

            </section>


            <!-- STATISTICS -->
            <section class="sk-section">

                <div>
                    <h2 class="sk-section-heading">
                        Ringkasan Properti
                    </h2>

                    <p class="sk-section-description">
                        Pantau kondisi properti Anda hari ini.
                    </p>
                </div>

                <div class="sk-stat-grid">

                    <div class="sk-stat-card">
                        <div class="sk-stat-icon">⌂</div>

                        <div class="sk-stat-number">
                            {{ $kosts }}
                        </div>

                        <div class="sk-stat-label">
                            Total Properti Kost
                        </div>
                    </div>


                    <div class="sk-stat-card">
                        <div class="sk-stat-icon">▦</div>

                        <div class="sk-stat-number">
                            {{ $rooms }}
                        </div>

                        <div class="sk-stat-label">
                            Total Kamar
                        </div>
                    </div>


                    <div class="sk-stat-card">
                        <div class="sk-stat-icon">♙</div>

                        <div class="sk-stat-number">
                            {{ $tenants }}
                        </div>

                        <div class="sk-stat-label">
                            Total Penghuni
                        </div>
                    </div>


                    <div class="sk-stat-card">
                        <div class="sk-stat-icon">✓</div>

                        <div class="sk-stat-number">
                            {{ $availableRooms }}
                        </div>

                        <div class="sk-stat-label">
                            Kamar Tersedia
                        </div>
                    </div>

                </div>

            </section>


            <!-- QUICK ACCESS -->
            <section class="sk-section">

                <div>
                    <h2 class="sk-section-heading">
                        Kelola Smart Kost
                    </h2>

                    <p class="sk-section-description">
                        Semua kebutuhan pengelolaan kost dalam satu tempat.
                    </p>
                </div>

                <div class="sk-quick-grid">

                    <a href="{{ route('owner.kosts.index') }}"
                       class="sk-card">

                        <div class="sk-card-icon">🏡</div>

                        <h3 class="sk-card-title">
                            Manajemen Kost
                        </h3>

                        <p class="sk-card-description">
                            Kelola informasi properti, nama kost,
                            alamat, dan deskripsi.
                        </p>

                        <div class="sk-card-link">
                            Kelola Properti →
                        </div>

                    </a>


                    <a href="{{ route('owner.kosts.index') }}"
                       class="sk-card">

                        <div class="sk-card-icon">🛏</div>

                        <h3 class="sk-card-title">
                            Manajemen Kamar
                        </h3>

                        <p class="sk-card-description">
                            Atur nomor kamar, harga sewa,
                            dan ketersediaan kamar.
                        </p>

                        <div class="sk-card-link">
                            Pilih Properti untuk Kelola Kamar →
                        </div>

                    </a>


                    <a href="{{ route('owner.tenants.index') }}"
                       class="sk-card">

                        <div class="sk-card-icon">♙</div>

                        <h3 class="sk-card-title">
                            Manajemen Penghuni
                        </h3>

                        <p class="sk-card-description">
                            Lihat dan kelola informasi penghuni
                            yang terdaftar.
                        </p>

                        <div class="sk-card-link">
                            Kelola Penghuni →
                        </div>

                    </a>

                </div>

            </section>


            <!-- FOOTER -->
            <footer class="sk-footer">
                <strong style="color: #684936;">smartkost.</strong>
                &nbsp; Your space, beautifully managed.
                <br>
                © {{ date('Y') }} Smart Kost Management System
            </footer>

        </div>
    </div>

</x-app-layout>

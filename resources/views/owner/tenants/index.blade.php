
<x-app-layout>
    <div class="sk-page">
        <div class="sk-container">

            <style>
                .tenant-page {
                    animation: tenantFadeIn .45s ease both;
                }

                @keyframes tenantFadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(12px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .tenant-list-heading {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 20px;
                    margin-bottom: 27px;
                }

                .tenant-eyebrow {
                    display: block;
                    color: #A67C62;
                    font-size: 10px;
                    font-weight: 800;
                    letter-spacing: 1.8px;
                    margin-bottom: 8px;
                }

                .tenant-list-heading h1 {
                    color: #493126;
                    font-size: 27px;
                    font-weight: 800;
                    margin: 0 0 7px;
                }

                .tenant-list-heading p,
                .tenant-table-heading p {
                    color: #99877A;
                    font-size: 11px;
                    margin: 0;
                    line-height: 1.7;
                }

                .tenant-add-button,
                .tenant-assignment-button {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    min-height: 42px;
                    padding: 0 17px;
                    border-radius: 9px;
                    background: #684936;
                    color: #FFFFFF;
                    text-decoration: none;
                    font-size: 11px;
                    font-weight: 800;
                    white-space: nowrap;
                    transition: all .2s ease;
                }

                .tenant-add-button:hover,
                .tenant-assignment-button:hover {
                    background: #493126;
                    transform: translateY(-2px);
                    box-shadow: 0 5px 12px rgba(73,49,38,.12);
                }

                .tenant-add-button svg,
                .tenant-assignment-button svg {
                    width: 15px;
                    height: 15px;
                }

                .tenant-summary {
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                    gap: 16px;
                    margin-bottom: 24px;
                }

                .tenant-summary-card {
                    position: relative;
                    overflow: hidden;
                    padding: 21px;
                    background: #FFFFFF;
                    border: 1px solid #E9DED3;
                    border-radius: 14px;
                    transition: transform .2s ease, box-shadow .2s ease;
                }

                .tenant-summary-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 8px 20px rgba(73,49,38,.06);
                }

                .tenant-summary-top {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 10px;
                }

                .tenant-summary-label {
                    color: #99877A;
                    font-size: 11px;
                    font-weight: 600;
                }

                .tenant-summary-icon {
                    width: 36px;
                    height: 36px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 10px;
                    background: #F7F2EB;
                    color: #8B654D;
                }

                .tenant-summary-icon svg {
                    width: 19px;
                    height: 19px;
                }

                .tenant-summary-card strong {
                    display: block;
                    margin: 12px 0 4px;
                    color: #493126;
                    font-size: 27px;
                    font-weight: 800;
                }

                .tenant-summary-card small {
                    color: #99877A;
                    font-size: 10px;
                }

                .tenant-table-card {
                    overflow: hidden;
                    background: #FFFFFF;
                    border: 1px solid #E9DED3;
                    border-radius: 15px;
                    box-shadow: 0 4px 15px rgba(73,49,38,.025);
                }

                .tenant-table-heading {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 15px;
                    padding: 22px 23px;
                    border-bottom: 1px solid #EEE5DC;
                }

                .tenant-table-heading h2 {
                    color: #493126;
                    font-size: 15px;
                    font-weight: 800;
                    margin: 0 0 5px;
                }

                .tenant-table-wrapper {
                    width: 100%;
                    overflow-x: auto;
                }

                .tenant-table {
                    width: 100%;
                    border-collapse: collapse;
                    text-align: left;
                }

                .tenant-table th {
                    padding: 15px 17px;
                    background: #FAF7F3;
                    color: #99877A;
                    font-size: 9px;
                    font-weight: 800;
                    letter-spacing: .8px;
                    text-transform: uppercase;
                    white-space: nowrap;
                }

                .tenant-table td {
                    padding: 16px 17px;
                    border-bottom: 1px solid #F0E9E2;
                    color: #493126;
                    font-size: 11px;
                    vertical-align: middle;
                }

                .tenant-table tbody tr:last-child td {
                    border-bottom: none;
                }

                .tenant-table tbody tr {
                    transition: background .2s ease;
                }

                .tenant-table tbody tr:hover {
                    background: #FDFBF9;
                }

                .tenant-person {
                    display: flex;
                    align-items: center;
                    gap: 11px;
                    min-width: 185px;
                }

                .tenant-avatar {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 38px;
                    height: 38px;
                    flex-shrink: 0;
                    border-radius: 11px;
                    background: #EFE5D9;
                    color: #684936;
                    font-size: 14px;
                    font-weight: 800;
                }

                .tenant-person strong,
                .tenant-person small,
                .tenant-emergency,
                .tenant-kost {
                    display: block;
                }

                .tenant-person strong {
                    color: #493126;
                    font-size: 11px;
                    font-weight: 800;
                }

                .tenant-person small,
                .tenant-emergency,
                .tenant-kost {
                    margin-top: 5px;
                    color: #99877A;
                    font-size: 9px;
                }

                .tenant-phone {
                    color: #493126;
                    font-size: 11px;
                    white-space: nowrap;
                }

                .tenant-room {
                    display: block;
                    color: #493126;
                    font-size: 11px;
                    font-weight: 800;
                }

                .tenant-muted {
                    color: #99877A;
                    font-size: 10px;
                }

                .tenant-status {
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    padding: 7px 10px;
                    border-radius: 20px;
                    font-size: 9px;
                    font-weight: 800;
                    white-space: nowrap;
                }

                .tenant-status::before {
                    content: "";
                    width: 6px;
                    height: 6px;
                    border-radius: 50%;
                    background: currentColor;
                }

                .tenant-status.occupied {
                    background: #E8F1E8;
                    color: #49734C;
                }

                .tenant-status.available {
                    background: #F2EDE7;
                    color: #8B725E;
                }

                .tenant-actions {
                    display: flex;
                    flex-wrap: wrap;
                    align-items: center;
                    gap: 6px;
                    min-width: 190px;
                }

                .tenant-actions form {
                    margin: 0;
                }

                .tenant-action {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    min-height: 29px;
                    padding: 0 9px;
                    border: none;
                    border-radius: 6px;
                    font-family: inherit;
                    font-size: 9px;
                    font-weight: 800;
                    text-decoration: none;
                    cursor: pointer;
                    white-space: nowrap;
                    transition: all .2s ease;
                }

                .tenant-action:hover {
                    filter: brightness(.96);
                    transform: translateY(-1px);
                }

                .tenant-action.edit {
                    background: #F0E8DF;
                    color: #684936;
                }

                .tenant-action.assign {
                    background: #E8F1E8;
                    color: #49734C;
                }

                .tenant-action.finish {
                    background: #FFF0DF;
                    color: #9A6330;
                }

                .tenant-action.delete {
                    background: #FBECEB;
                    color: #B44C45;
                }

                .tenant-notification {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    padding: 13px 16px;
                    margin-bottom: 19px;
                    border-radius: 10px;
                    font-size: 11px;
                }

                .tenant-notification svg {
                    width: 17px;
                    height: 17px;
                    flex-shrink: 0;
                }

                .tenant-notification.success {
                    color: #386A43;
                    background: #EDF6ED;
                    border: 1px solid #D5E9D5;
                }

                .tenant-notification.error {
                    color: #A33B35;
                    background: #FFF1EF;
                    border: 1px solid #F1D0CC;
                }

                .tenant-empty {
                    padding: 65px 20px;
                    text-align: center;
                }

                .tenant-empty-icon {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 65px;
                    height: 65px;
                    margin: 0 auto 17px;
                    border-radius: 18px;
                    background: #F7F2EB;
                    color: #8B654D;
                }

                .tenant-empty-icon svg {
                    width: 30px;
                    height: 30px;
                }

                .tenant-empty h3 {
                    margin: 0 0 8px;
                    color: #493126;
                    font-size: 16px;
                    font-weight: 800;
                }

                .tenant-empty p {
                    max-width: 330px;
                    margin: 0 auto 20px;
                    color: #99877A;
                    font-size: 11px;
                    line-height: 1.8;
                }

                @media (max-width: 768px) {
                    .tenant-list-heading,
                    .tenant-table-heading {
                        align-items: flex-start;
                        flex-direction: column;
                    }

                    .tenant-summary {
                        grid-template-columns: 1fr;
                    }

                    .tenant-add-button,
                    .tenant-assignment-button {
                        width: 100%;
                        box-sizing: border-box;
                    }

                    .tenant-list-heading h1 {
                        font-size: 23px;
                    }
                }
            </style>

            <div class="tenant-page">

                <!-- Page Header -->
                <div class="tenant-list-heading">
                    <div>
                        <span class="tenant-eyebrow">TENANT MANAGEMENT</span>

                        <h1>Manajemen Penghuni</h1>

                        <p>
                            Kelola data penghuni dan penempatan kamar kost Anda.
                        </p>
                    </div>

                    <a href="{{ route('owner.tenants.create') }}"
                       class="tenant-add-button">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Tambah Penghuni
                    </a>
                </div>

                <!-- Notifications -->
                @if (session('success'))
                    <div class="tenant-notification success">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="m5 12 4 4L19 6"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="tenant-notification error">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 8v4m0 4h.01"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Summary -->
                <div class="tenant-summary">

                    <div class="tenant-summary-card">
                        <div class="tenant-summary-top">
                            <span class="tenant-summary-label">
                                Total Penghuni
                            </span>

                            <div class="tenant-summary-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="1.7"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                        </div>

                        <strong>{{ $tenants->count() }}</strong>
                        <small>Penghuni terdaftar</small>
                    </div>

                    <div class="tenant-summary-card">
                        <div class="tenant-summary-top">
                            <span class="tenant-summary-label">
                                Sedang Menempati Kamar
                            </span>

                            <div class="tenant-summary-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="1.7"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 21V8l9-5 9 5v13"/>
                                    <path d="M9 21v-6h6v6M3 10h18"/>
                                </svg>
                            </div>
                        </div>

                        <strong>
                            {{ $tenants->filter(function ($tenant) {
                                return $tenant->roomAssignments
                                    ->contains('status', 'active');
                            })->count() }}
                        </strong>

                        <small>Penempatan aktif</small>
                    </div>

                    <div class="tenant-summary-card">
                        <div class="tenant-summary-top">
                            <span class="tenant-summary-label">
                                Belum Menempati Kamar
                            </span>

                            <div class="tenant-summary-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="1.7"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 8v8m-4-4h8"/>
                                </svg>
                            </div>
                        </div>

                        <strong>
                            {{ $tenants->filter(function ($tenant) {
                                return !$tenant->roomAssignments
                                    ->contains('status', 'active');
                            })->count() }}
                        </strong>

                        <small>Belum memiliki penempatan aktif</small>
                    </div>

                </div>

                <!-- Tenant Table -->
                <div class="tenant-table-card">

                    <div class="tenant-table-heading">
                        <div>
                            <h2>Daftar Penghuni</h2>
                            <p>
                                Informasi akun dan status tempat tinggal penghuni.
                            </p>
                        </div>

                        <a href="{{ route('owner.assignments.create') }}"
                           class="tenant-assignment-button">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Tempatkan ke Kamar
                        </a>
                    </div>

                    @if ($tenants->isEmpty())

                        <div class="tenant-empty">
                            <div class="tenant-empty-icon">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="1.6"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                </svg>
                            </div>

                            <h3>Belum Ada Penghuni</h3>

                            <p>
                                Mulai tambahkan penghuni untuk mengelola
                                data kost Anda.
                            </p>

                            <a href="{{ route('owner.tenants.create') }}"
                               class="tenant-add-button">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                Tambah Penghuni
                            </a>
                        </div>

                    @else

                        <div class="tenant-table-wrapper">
                            <table class="tenant-table">

                                <thead>
                                    <tr>
                                        <th>Penghuni</th>
                                        <th>Kontak</th>
                                        <th>Kamar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($tenants as $tenant)

                                        @php
                                            $activeAssignment = $tenant->roomAssignments
                                                ->firstWhere('status', 'active');
                                        @endphp

                                        <tr>

                                            <!-- Tenant Identity -->
                                            <td>
                                                <div class="tenant-person">

                                                    <div class="tenant-avatar">
                                                        {{ strtoupper(substr($tenant->user->name ?? '?', 0, 1)) }}
                                                    </div>

                                                    <div>
                                                        <strong>
                                                            {{ $tenant->user->name ?? 'Akun tidak ditemukan' }}
                                                        </strong>

                                                        <small>
                                                            {{ $tenant->user->email ?? '-' }}
                                                        </small>
                                                    </div>

                                                </div>
                                            </td>

                                            <!-- Contact -->
                                            <td>
                                                <span class="tenant-phone">
                                                    {{ $tenant->phone }}
                                                </span>

                                                @if ($tenant->emergency_contact)
                                                    <small class="tenant-emergency">
                                                        Darurat: {{ $tenant->emergency_contact }}
                                                    </small>
                                                @endif
                                            </td>

                                            <!-- Room -->
                                            <td>
                                                @if ($activeAssignment)

                                                    <strong class="tenant-room">
                                                        {{ $activeAssignment->room->room_number ?? '-' }}
                                                    </strong>

                                                    <small class="tenant-kost">
                                                        {{ $activeAssignment->room->kost->name ?? '-' }}
                                                    </small>

                                                @else

                                                    <span class="tenant-muted">
                                                        Belum ditempatkan
                                                    </span>

                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                @if ($activeAssignment)

                                                    <span class="tenant-status occupied">
                                                        Menempati Kamar
                                                    </span>

                                                @else

                                                    <span class="tenant-status available">
                                                        Belum Ditempatkan
                                                    </span>

                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <div class="tenant-actions">

                                                    <a href="{{ route('owner.tenants.edit', $tenant) }}"
                                                       class="tenant-action edit">
                                                        Edit
                                                    </a>

                                                    @if ($activeAssignment)

                                                        <form
                                                            action="{{ route('owner.assignments.finish', $activeAssignment) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Akhiri penempatan penghuni ini?')"
                                                        >
                                                            @csrf
                                                            @method('PATCH')

                                                            <button type="submit"
                                                                    class="tenant-action finish">
                                                                Akhiri
                                                            </button>
                                                        </form>

                                                    @else

                                                        <a href="{{ route('owner.assignments.create') }}"
                                                           class="tenant-action assign">
                                                            Tempatkan
                                                        </a>

                                                    @endif

                                                    <form
                                                        action="{{ route('owner.tenants.destroy', $tenant) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus penghuni ini?')"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="tenant-action delete">
                                                            Hapus
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>

                                        </tr>

                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    @endif

                </div>

                <p style="text-align:center; color:#99877A; font-size:10px; margin-top:22px;">
                    Smart Kost Management System
                </p>

            </div>
        </div>
    </div>
</x-app-layout>

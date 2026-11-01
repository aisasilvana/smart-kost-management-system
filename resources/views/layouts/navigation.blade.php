
@php
    $user = Auth::user();
    $isOwner = $user && $user->role === 'owner';
    $isTenant = $user && $user->role === 'tenant';
    $dashboardActive = request()->routeIs('dashboard')
        || request()->routeIs('owner.dashboard')
        || request()->routeIs('tenant.dashboard');
@endphp

<nav x-data="{ open: false }" class="sk-navigation">
    {{-- DESKTOP SIDEBAR --}}
    <aside class="sk-sidebar">
        {{-- BRAND --}}
        <a href="{{ route('dashboard') }}" class="sk-brand">
            smart<span>kost.</span>
        </a>

        <div class="sk-sidebar-content">
            {{-- MAIN MENU --}}
            <div class="sk-menu-label">MENU UTAMA</div>
            <a href="{{ route('dashboard') }}"
               class="sk-nav-link {{ $dashboardActive ? 'active' : '' }}">
                <span class="sk-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 10 9-7 9 7"/>
                        <path d="M5 9v11h14V9"/>
                        <path d="M9 20v-6h6v6"/>
                    </svg>
                </span>
                <span>Dashboard</span>
            </a>

            {{-- OWNER MENU --}}
            @if($isOwner)
                <div class="sk-menu-label">MANAJEMEN PROPERTI</div>

                <a href="{{ route('owner.kosts.index') }}"
                   class="sk-nav-link {{ request()->routeIs('owner.kosts.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18"/>
                            <path d="M5 21V7l8-4v18"/>
                            <path d="M19 21V11l-6-4"/>
                            <path d="M8 9v.01M8 13v.01M8 17v.01"/>
                            <path d="M16 13v.01M16 17v.01"/>
                        </svg>
                    </span>
                    <span>Manajemen Kost</span>
                </a>

                <a href="{{ route('owner.tenants.index') }}"
                   class="sk-nav-link {{ request()->routeIs('owner.tenants.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="8" r="4"/>
                            <path d="M2 21a7 7 0 0 1 14 0"/>
                            <path d="M17 11a4 4 0 0 0 0-7"/>
                            <path d="M22 21a7 7 0 0 0-5-6.7"/>
                        </svg>
                    </span>
                    <span>Manajemen Penghuni</span>
                </a>

                <a href="{{ route('owner.assignments.index') }}"
                   class="sk-nav-link {{ request()->routeIs('owner.assignments.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                            <path d="m9 15 2 2 4-4"/>
                        </svg>
                    </span>
                    <span>Penempatan Kamar</span>
                </a>

                {{-- FINANCE --}}
                <div class="sk-menu-label">KEUANGAN</div>

                <a href="{{ route('owner.bills.index') }}"
                   class="sk-nav-link {{ request()->routeIs('owner.bills.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2h9l5 5v15H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"/>
                            <path d="M14 2v6h6"/>
                            <path d="M8 13h8M8 17h8"/>
                        </svg>
                    </span>
                    <span>Manajemen Tagihan</span>
                </a>

                <a href="{{ route('owner.payments.index') }}"
                   class="sk-nav-link {{ request()->routeIs('owner.payments.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20"/>
                            <path d="M6 15h4"/>
                        </svg>
                    </span>
                    <span>Verifikasi Pembayaran</span>
                </a>

                <a href="{{ route('owner.income.index') }}"
                   class="sk-nav-link {{ request()->routeIs('owner.income.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18"/>
                            <path d="m7 14 4-4 4 3 6-7"/>
                            <path d="M15 6h6v6"/>
                        </svg>
                    </span>
                    <span>Rekap Pemasukan</span>
                </a>

            {{-- TENANT MENU --}}
            @elseif($isTenant)
                <div class="sk-menu-label">MENU PENGHUNI</div>

                <a href="{{ route('tenant.dashboard') }}"
                   class="sk-nav-link {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 10 9-7 9 7"/>
                            <path d="M5 9v11h14V9"/>
                            <path d="M9 20v-6h6v6"/>
                        </svg>
                    </span>
                    <span>Dashboard Tenant</span>
                </a>

                <a href="{{ route('tenant.payments.index') }}"
                   class="sk-nav-link {{ request()->routeIs('tenant.payments.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20"/>
                            <path d="M6 15h4"/>
                        </svg>
                    </span>
                    <span>Tagihan & Pembayaran</span>
                </a>
            @endif

            {{-- SETTINGS --}}
            <div class="sk-menu-label">PENGATURAN</div>

            <a href="{{ route('profile.edit') }}"
               class="sk-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="sk-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="m19.4 15 .1.1a2 2 0 0 1-2.8 2.8l-.1-.1a2 2 0 0 0-3.4 1.4v.3a2 2 0 0 1-4 0v-.2a2 2 0 0 0-3.4-1.4l-.1.1a2 2 0 0 1-2.8-2.8l-.1-.1a2 2 0 0 0-1.4-3.4h-.3a2 2 0 0 1 0-4h.2a2 2 0 0 0 1.4-3.4l-.1-.1a2 2 0 0 1 2.8-2.8l.1.1a2 2 0 0 0 3.4-1.4v-.3a2 2 0 0 1 4 0v.2a2 2 0 0 0 3.4 1.4l.1-.1a2 2 0 0 1 2.8 2.8l-.1.1a2 2 0 0 0 1.4 3.4h.3a2 2 0 0 1 0 4h-.2a2 2 0 0 0-1.4 3.4Z"/>
                    </svg>
                </span>
                <span>Profil Saya</span>
            </a>
        </div>

        {{-- SIDEBAR BOTTOM --}}
        <div class="sk-sidebar-bottom">
            <div class="sk-user-card">
                <div class="sk-user-avatar">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
                <div class="sk-user-info">
                    <div class="sk-user-name">{{ $user->name }}</div>
                    <div class="sk-user-role">
                        {{ ucfirst($user->role) }} Smartkost
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sk-nav-link sk-logout-link">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 17l5-5-5-5"/>
                            <path d="M15 12H3"/>
                            <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                        </svg>
                    </span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MOBILE NAVIGATION --}}
    <div class="sk-mobile-nav">
        <div class="sk-mobile-header">
            <a href="{{ route('dashboard') }}" class="sk-brand">
                smart<span>kost.</span>
            </a>

            <button
                type="button"
                class="sk-mobile-toggle"
                @click="open = !open"
                :aria-expanded="open.toString()"
                aria-label="Buka menu navigasi"
            >
                <svg x-show="!open" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round">
                    <path d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
                <svg x-show="open" x-cloak viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round">
                    <path d="m6 6 12 12M18 6 6 18"/>
                </svg>
            </button>
        </div>

        <div
            x-show="open"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="sk-mobile-menu"
        >
            <div class="sk-mobile-user">
                <div class="sk-user-avatar">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
                <div class="sk-user-info">
                    <div class="sk-user-name">{{ $user->name }}</div>
                    <div class="sk-user-role">{{ ucfirst($user->role) }} Smartkost</div>
                </div>
            </div>

            <div class="sk-menu-label">MENU UTAMA</div>
            <a href="{{ route('dashboard') }}"
               @click="open = false"
               class="sk-nav-link {{ $dashboardActive ? 'active' : '' }}">
                <span class="sk-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 10 9-7 9 7"/>
                        <path d="M5 9v11h14V9"/>
                        <path d="M9 20v-6h6v6"/>
                    </svg>
                </span>
                Dashboard
            </a>

            @if($isOwner)
                <div class="sk-menu-label">MANAJEMEN PROPERTI</div>

                <a href="{{ route('owner.kosts.index') }}"
                   @click="open = false"
                   class="sk-nav-link {{ request()->routeIs('owner.kosts.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/>
                        </svg>
                    </span>
                    Manajemen Kost
                </a>

                <a href="{{ route('owner.tenants.index') }}"
                   @click="open = false"
                   class="sk-nav-link {{ request()->routeIs('owner.tenants.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="8" r="4"/>
                            <path d="M2 21a7 7 0 0 1 14 0"/>
                            <path d="M17 11a4 4 0 0 0 0-7M22 21a7 7 0 0 0-5-6.7"/>
                        </svg>
                    </span>
                    Manajemen Penghuni
                </a>

                <a href="{{ route('owner.assignments.index') }}"
                   @click="open = false"
                   class="sk-nav-link {{ request()->routeIs('owner.assignments.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                            <path d="m9 15 2 2 4-4"/>
                        </svg>
                    </span>
                    Penempatan Kamar
                </a>

                <div class="sk-menu-label">KEUANGAN</div>

                <a href="{{ route('owner.bills.index') }}"
                   @click="open = false"
                   class="sk-nav-link {{ request()->routeIs('owner.bills.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2h9l5 5v15H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"/>
                            <path d="M14 2v6h6M8 13h8M8 17h8"/>
                        </svg>
                    </span>
                    Manajemen Tagihan
                </a>

                <a href="{{ route('owner.payments.index') }}"
                   @click="open = false"
                   class="sk-nav-link {{ request()->routeIs('owner.payments.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20M6 15h4"/>
                        </svg>
                    </span>
                    Verifikasi Pembayaran
                </a>

                <a href="{{ route('owner.income.index') }}"
                   @click="open = false"
                   class="sk-nav-link {{ request()->routeIs('owner.income.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18M7 14l4-4 4 3 6-7M15 6h6v6"/>
                        </svg>
                    </span>
                    Rekap Pemasukan
                </a>

            @elseif($isTenant)
                <div class="sk-menu-label">MENU PENGHUNI</div>

                <a href="{{ route('tenant.dashboard') }}"
                   @click="open = false"
                   class="sk-nav-link {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 10 9-7 9 7M5 9v11h14V9M9 20v-6h6v6"/>
                        </svg>
                    </span>
                    Dashboard Tenant
                </a>

                <a href="{{ route('tenant.payments.index') }}"
                   @click="open = false"
                   class="sk-nav-link {{ request()->routeIs('tenant.payments.*') ? 'active' : '' }}">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <path d="M2 10h20M6 15h4"/>
                        </svg>
                    </span>
                    Tagihan & Pembayaran
                </a>
            @endif

            <div class="sk-menu-label">PENGATURAN</div>

            <a href="{{ route('profile.edit') }}"
               @click="open = false"
               class="sk-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="sk-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a2 2 0 0 0 1.4 3.4 2 2 0 0 1-2.8 2.8 2 2 0 0 0-3.4 1.4 2 2 0 0 1-4 0 2 2 0 0 0-3.4-1.4 2 2 0 0 1-2.8-2.8A2 2 0 0 0 3 15a2 2 0 0 1 0-4 2 2 0 0 0 1.4-3.4 2 2 0 0 1 2.8-2.8A2 2 0 0 0 10.6 3a2 2 0 0 1 4 0A2 2 0 0 0 18 4.4a2 2 0 0 1 2.8 2.8A2 2 0 0 0 22 11a2 2 0 0 1-2.6 4Z"/>
                    </svg>
                </span>
                Profil Saya
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sk-nav-link sk-logout-link">
                    <span class="sk-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 17l5-5-5-5M15 12H3"/>
                            <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                        </svg>
                    </span>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</nav>

<style>
    .sk-navigation {
        font-family: 'Manrope', sans-serif;
    }

    /* DESKTOP SIDEBAR */
    .sk-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 40;
        display: flex;
        width: 258px;
        height: 100vh;
        flex-direction: column;
        padding: 27px 19px 20px;
        border-right: 1px solid #E9DED3;
        background: #fff;
    }

    .sk-brand {
        display: inline-block;
        width: fit-content;
        margin: 0 0 37px 10px;
        color: #493126;
        font-family: 'DM Sans', sans-serif;
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -1.8px;
        line-height: 1;
        text-decoration: none;
    }

    .sk-brand span {
        color: #B58B6B;
    }

    .sk-sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 0 0 18px;
        scrollbar-width: thin;
        scrollbar-color: #E9DED3 transparent;
    }

    .sk-menu-label {
        margin: 25px 0 10px 12px;
        color: #B09D8D;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1.5px;
    }

    .sk-menu-label:first-child {
        margin-top: 0;
    }

    .sk-nav-link {
        position: relative;
        display: flex;
        min-height: 43px;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        margin-bottom: 4px;
        border: 0;
        border-radius: 9px;
        background: transparent;
        color: #806F61;
        font-family: 'Manrope', sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        text-decoration: none;
        transition: background .2s ease, color .2s ease;
    }

    .sk-nav-link:hover {
        background: #F7F2EB;
        color: #684936;
    }

    .sk-nav-link.active {
        background: #F3EAE0;
        color: #684936;
        font-weight: 800;
    }

    .sk-nav-link.active::before {
        position: absolute;
        top: 10px;
        bottom: 10px;
        left: 0;
        width: 3px;
        border-radius: 0 4px 4px 0;
        background: #8B654D;
        content: '';
    }

    .sk-nav-icon {
        display: flex;
        width: 19px;
        height: 19px;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
    }

    .sk-nav-icon svg {
        width: 18px;
        height: 18px;
    }

    /* USER AREA */
    .sk-sidebar-bottom {
        padding-top: 15px;
        border-top: 1px solid #F0E8E0;
    }

    .sk-user-card,
    .sk-mobile-user {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 11px;
        background: #FAF7F3;
    }

    .sk-user-avatar {
        display: flex;
        width: 37px;
        height: 37px;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #684936;
        color: #fff;
        font-size: 14px;
        font-weight: 800;
    }

    .sk-user-info {
        min-width: 0;
    }

    .sk-user-name {
        overflow: hidden;
        color: #493126;
        font-size: 11px;
        font-weight: 800;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .sk-user-role {
        margin-top: 3px;
        color: #A18D7C;
        font-size: 9px;
        font-weight: 600;
    }

    .sk-logout-link {
        width: 100%;
        cursor: pointer;
    }

    .sk-logout-link:hover {
        background: #FCF0EC;
        color: #A65D4E;
    }

    /* MOBILE NAVIGATION */
    .sk-mobile-nav {
        display: none;
        position: relative;
        z-index: 50;
        border-bottom: 1px solid #E9DED3;
        background: #fff;
    }

    .sk-mobile-header {
        display: flex;
        min-height: 65px;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
    }

    .sk-mobile-header .sk-brand {
        margin: 0;
        font-size: 25px;
    }

    .sk-mobile-toggle {
        display: flex;
        width: 40px;
        height: 40px;
        align-items: center;
        justify-content: center;
        border: 1px solid #E9DED3;
        border-radius: 10px;
        background: #F7F2EB;
        color: #684936;
        cursor: pointer;
    }

    .sk-mobile-toggle svg {
        width: 20px;
        height: 20px;
    }

    .sk-mobile-menu {
        max-height: calc(100vh - 65px);
        overflow-y: auto;
        padding: 15px 18px 22px;
        border-top: 1px solid #F0E8E0;
        background: #fff;
        box-shadow: 0 12px 22px rgba(73, 49, 38, .07);
    }

    .sk-mobile-user {
        margin-bottom: 20px;
    }

    .sk-mobile-menu .sk-menu-label {
        margin-top: 21px;
    }

    .sk-mobile-menu .sk-nav-link {
        min-height: 45px;
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .sk-sidebar {
            display: none;
        }

        .sk-mobile-nav {
            display: block;
        }
    }
</style>

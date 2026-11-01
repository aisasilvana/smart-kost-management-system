
<x-app-layout>
    <div class="sk-page">
        <div class="sk-container tenant-form-container">

            <style>
                .tenant-create-page {
                    animation: tenantCreateFade .45s ease both;
                }

                @keyframes tenantCreateFade {
                    from {
                        opacity: 0;
                        transform: translateY(12px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .tenant-create-heading {
                    display: flex;
                    align-items: center;
                    gap: 13px;
                    margin-bottom: 25px;
                }

                .tenant-create-icon {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 49px;
                    height: 49px;
                    flex-shrink: 0;
                    border-radius: 14px;
                    background: #EFE5D9;
                    color: #684936;
                }

                .tenant-create-icon svg {
                    width: 23px;
                    height: 23px;
                }

                .tenant-eyebrow {
                    display: block;
                    color: #A67C62;
                    font-size: 10px;
                    font-weight: 800;
                    letter-spacing: 1.8px;
                    margin-bottom: 5px;
                }

                .tenant-heading h1 {
                    color: #493126;
                    font-family: 'Manrope', sans-serif;
                    font-size: 27px;
                    font-weight: 800;
                    margin: 0 0 5px;
                }

                .tenant-heading p {
                    color: #99877A;
                    font-size: 11px;
                    line-height: 1.7;
                    margin: 0;
                }

                .tenant-form-card {
                    background: #FFFFFF;
                    border: 1px solid #E9DED3;
                    border-radius: 17px;
                    padding: 29px;
                    box-shadow: 0 5px 20px rgba(73,49,38,.035);
                }

                .tenant-card-heading {
                    display: flex;
                    align-items: flex-start;
                    gap: 12px;
                    margin-bottom: 25px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #E9DED3;
                }

                .tenant-card-heading-icon {
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

                .tenant-card-heading-icon svg {
                    width: 18px;
                    height: 18px;
                }

                .tenant-card-heading h2 {
                    color: #493126;
                    font-size: 15px;
                    font-weight: 800;
                    margin: 0 0 5px;
                }

                .tenant-card-heading p {
                    color: #99877A;
                    font-size: 11px;
                    line-height: 1.6;
                    margin: 0;
                }

                .tenant-form-section {
                    margin-bottom: 25px;
                }

                .tenant-section-label {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    margin-bottom: 17px;
                    color: #684936;
                    font-size: 11px;
                    font-weight: 800;
                }

                .tenant-section-label svg {
                    width: 16px;
                    height: 16px;
                    color: #A67C62;
                }

                .tenant-form-grid {
                    display: grid;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 19px 17px;
                }

                .tenant-field {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                    min-width: 0;
                }

                .tenant-field-full {
                    grid-column: 1 / -1;
                }

                .tenant-field label {
                    color: #493126;
                    font-size: 11px;
                    font-weight: 800;
                }

                .tenant-field input {
                    width: 100%;
                    height: 45px;
                    box-sizing: border-box;
                    border: 1px solid #E9DED3;
                    border-radius: 9px;
                    padding: 0 13px;
                    color: #493126;
                    background: #FFFFFF;
                    font-family: 'Manrope', sans-serif;
                    font-size: 11px;
                    outline: none;
                    transition: border-color .2s, box-shadow .2s;
                }

                .tenant-field input:focus {
                    border-color: #B58B6B;
                    box-shadow: 0 0 0 3px rgba(181,139,107,.13);
                }

                .tenant-field input::placeholder {
                    color: #B5A69A;
                }

                .tenant-field small {
                    color: #99877A;
                    font-size: 10px;
                    line-height: 1.6;
                }

                .tenant-field-error {
                    color: #B44C45;
                    font-size: 10px;
                }

                .tenant-alert {
                    padding: 14px 16px;
                    margin-bottom: 21px;
                    border-radius: 10px;
                    font-size: 11px;
                    line-height: 1.7;
                }

                .tenant-alert-error {
                    color: #A33B35;
                    background: #FFF1EF;
                    border: 1px solid #F1D0CC;
                }

                .tenant-alert ul {
                    padding-left: 19px;
                    margin: 7px 0 0;
                }

                .tenant-alert li {
                    margin-top: 3px;
                }

                .tenant-form-footer {
                    display: flex;
                    justify-content: flex-end;
                    align-items: center;
                    gap: 10px;
                    border-top: 1px solid #E9DED3;
                    margin-top: 26px;
                    padding-top: 21px;
                }

                .tenant-button {
                    display: inline-flex;
                    justify-content: center;
                    align-items: center;
                    gap: 8px;
                    min-height: 42px;
                    padding: 0 19px;
                    border: none;
                    border-radius: 9px;
                    font-family: 'Manrope', sans-serif;
                    font-size: 11px;
                    font-weight: 800;
                    text-decoration: none;
                    cursor: pointer;
                    transition: all .2s ease;
                }

                .tenant-button-cancel {
                    color: #684936;
                    background: #EFE5D9;
                }

                .tenant-button-cancel:hover {
                    background: #E7D3BE;
                }

                .tenant-button-submit {
                    color: #FFFFFF;
                    background: #684936;
                }

                .tenant-button-submit:hover {
                    background: #493126;
                    transform: translateY(-1px);
                    box-shadow: 0 5px 12px rgba(73,49,38,.13);
                }

                .tenant-button-submit svg {
                    width: 15px;
                    height: 15px;
                }

                .tenant-create-footer {
                    text-align: center;
                    color: #99877A;
                    font-size: 10px;
                    margin-top: 21px;
                }

                @media (max-width: 640px) {
                    .tenant-form-card {
                        padding: 21px 17px;
                    }

                    .tenant-form-grid {
                        grid-template-columns: 1fr;
                    }

                    .tenant-field-full {
                        grid-column: auto;
                    }

                    .tenant-heading h1 {
                        font-size: 23px;
                    }

                    .tenant-form-footer {
                        flex-direction: column-reverse;
                    }

                    .tenant-button {
                        width: 100%;
                    }
                }
            </style>

            <div class="tenant-create-page">

                <!-- Page Heading -->
                <div class="tenant-create-heading">
                    <div class="tenant-create-icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M19 8v6m-3-3h6"/>
                        </svg>
                    </div>

                    <div class="tenant-heading">
                        <span class="tenant-eyebrow">TENANT MANAGEMENT</span>

                        <h1>Tambah Penghuni</h1>

                        <p>
                            Daftarkan akun tenant sekaligus sebagai penghuni kost Anda.
                        </p>
                    </div>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="tenant-alert tenant-alert-error">
                        <strong>Periksa kembali formulir Anda.</strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form
                    action="{{ route('owner.tenants.store') }}"
                    method="POST"
                    class="tenant-form-card"
                >
                    @csrf

                    <div class="tenant-card-heading">
                        <div class="tenant-card-heading-icon">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                            </svg>
                        </div>

                        <div>
                            <h2>Informasi Akun Penghuni</h2>
                            <p>
                                Lengkapi informasi akun dan kontak penghuni
                                yang akan didaftarkan.
                            </p>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="tenant-form-section">

                        <div class="tenant-section-label">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path d="m3 7 9 6 9-6"/>
                            </svg>
                            Informasi Akun
                        </div>

                        <div class="tenant-form-grid">

                            <div class="tenant-field tenant-field-full">
                                <label for="name">Nama Lengkap</label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap penghuni"
                                    required
                                    autocomplete="name"
                                >

                                @error('name')
                                    <span class="tenant-field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="tenant-field tenant-field-full">
                                <label for="email">Alamat Email</label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="contoh@email.com"
                                    required
                                    autocomplete="email"
                                >

                                <small>
                                    Email ini akan digunakan penghuni untuk login.
                                </small>

                                @error('email')
                                    <span class="tenant-field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="tenant-field">
                                <label for="password">Password</label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Minimal 8 karakter"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                >

                                @error('password')
                                    <span class="tenant-field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="tenant-field">
                                <label for="password_confirmation">
                                    Konfirmasi Password
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                >
                            </div>

                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="tenant-form-section">

                        <div class="tenant-section-label">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                                         19.79 19.79 0 0 1-8.63-3.07
                                         19.5 19.5 0 0 1-6-6
                                         19.79 19.79 0 0 1-3.07-8.67
                                         A2 2 0 0 1 4.11 2h3
                                         a2 2 0 0 1 2 1.72
                                         c.12.96.36 1.9.72 2.8
                                         a2 2 0 0 1-.45 2.11L8.11 9.91
                                         a16 16 0 0 0 6 6l1.27-1.27
                                         a2 2 0 0 1 2.11-.45
                                         c.9.36 1.84.6 2.8.72
                                         A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            Informasi Kontak
                        </div>

                        <div class="tenant-form-grid">

                            <div class="tenant-field tenant-field-full">
                                <label for="phone">Nomor Telepon</label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="Contoh: 081234567890"
                                    required
                                    autocomplete="tel"
                                >

                                @error('phone')
                                    <span class="tenant-field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="tenant-field tenant-field-full">
                                <label for="emergency_contact">
                                    Kontak Darurat
                                </label>

                                <input
                                    type="text"
                                    id="emergency_contact"
                                    name="emergency_contact"
                                    value="{{ old('emergency_contact') }}"
                                    placeholder="Nama dan nomor kontak darurat"
                                >

                                <small>
                                    Opsional. Isi dengan informasi orang yang dapat
                                    dihubungi saat keadaan darurat.
                                </small>

                                @error('emergency_contact')
                                    <span class="tenant-field-error">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="tenant-form-footer">

                        <a
                            href="{{ route('owner.tenants.index') }}"
                            class="tenant-button tenant-button-cancel"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="tenant-button tenant-button-submit"
                        >
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14m-7-7 7 7-7 7"/>
                            </svg>
                            Simpan Penghuni
                        </button>

                    </div>
                </form>

                <p class="tenant-create-footer">
                    Smart Kost Management System
                </p>

            </div>
        </div>
    </div>
</x-app-layout>

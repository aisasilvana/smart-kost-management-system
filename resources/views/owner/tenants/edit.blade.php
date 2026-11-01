
<x-app-layout>
    <div class="sk-page">
        <div class="sk-container" style="max-width:850px;">

            <style>
                .tenant-edit-page {
                    animation: tenantEditFade .45s ease both;
                }

                @keyframes tenantEditFade {
                    from {
                        opacity: 0;
                        transform: translateY(12px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .tenant-edit-heading {
                    display: flex;
                    align-items: center;
                    gap: 13px;
                    margin-bottom: 25px;
                }

                .tenant-edit-icon {
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

                .tenant-edit-icon svg {
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

                .tenant-edit-heading h1 {
                    color: #493126;
                    font-family: 'Manrope', sans-serif;
                    font-size: 27px;
                    font-weight: 800;
                    margin: 0 0 5px;
                }

                .tenant-edit-heading p {
                    color: #99877A;
                    font-size: 11px;
                    line-height: 1.7;
                    margin: 0;
                }

                .tenant-edit-card {
                    background: #FFFFFF;
                    border: 1px solid #E9DED3;
                    border-radius: 17px;
                    padding: 29px;
                    box-shadow: 0 5px 20px rgba(73,49,38,.035);
                }

                .tenant-profile {
                    display: flex;
                    align-items: center;
                    gap: 14px;
                    padding: 17px;
                    background: #F7F2EB;
                    border: 1px solid #EFE5D9;
                    border-radius: 12px;
                    margin-bottom: 25px;
                }

                .tenant-profile-avatar {
                    width: 48px;
                    height: 48px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                    background: #E7D3BE;
                    color: #684936;
                    border-radius: 13px;
                    font-size: 18px;
                    font-weight: 800;
                }

                .tenant-profile-name {
                    font-size: 13px;
                    font-weight: 800;
                    color: #493126;
                }

                .tenant-profile-email {
                    font-size: 10px;
                    color: #99877A;
                    margin-top: 4px;
                }

                .tenant-profile-label {
                    display: inline-block;
                    margin-top: 7px;
                    padding: 4px 8px;
                    border-radius: 20px;
                    background: #EFE5D9;
                    color: #684936;
                    font-size: 9px;
                    font-weight: 800;
                }

                .tenant-edit-section-heading {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    margin-bottom: 22px;
                    padding-bottom: 19px;
                    border-bottom: 1px solid #E9DED3;
                }

                .tenant-edit-section-heading svg {
                    width: 19px;
                    height: 19px;
                    color: #8B654D;
                }

                .tenant-edit-section-heading h2 {
                    color: #493126;
                    font-size: 15px;
                    font-weight: 800;
                    margin: 0 0 4px;
                }

                .tenant-edit-section-heading p {
                    color: #99877A;
                    font-size: 10px;
                    margin: 0;
                }

                .tenant-edit-field {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                    margin-bottom: 21px;
                }

                .tenant-edit-field label {
                    color: #493126;
                    font-size: 11px;
                    font-weight: 800;
                }

                .tenant-edit-field input {
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

                .tenant-edit-field input:focus {
                    border-color: #B58B6B;
                    box-shadow: 0 0 0 3px rgba(181,139,107,.13);
                }

                .tenant-edit-field input:disabled {
                    background: #F7F2EB;
                    color: #8B654D;
                    cursor: not-allowed;
                }

                .tenant-edit-field input::placeholder {
                    color: #B5A69A;
                }

                .tenant-edit-hint {
                    color: #99877A;
                    font-size: 10px;
                    line-height: 1.6;
                }

                .tenant-edit-error {
                    color: #B44C45;
                    font-size: 10px;
                }

                .tenant-edit-alert {
                    padding: 14px 16px;
                    margin-bottom: 21px;
                    border-radius: 10px;
                    font-size: 11px;
                    line-height: 1.7;
                    color: #A33B35;
                    background: #FFF1EF;
                    border: 1px solid #F1D0CC;
                }

                .tenant-edit-alert ul {
                    padding-left: 19px;
                    margin: 7px 0 0;
                }

                .tenant-edit-alert li {
                    margin-top: 3px;
                }

                .tenant-edit-actions {
                    display: flex;
                    justify-content: flex-end;
                    align-items: center;
                    gap: 10px;
                    border-top: 1px solid #E9DED3;
                    margin-top: 26px;
                    padding-top: 21px;
                }

                .tenant-edit-button {
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

                .tenant-edit-cancel {
                    color: #684936;
                    background: #EFE5D9;
                }

                .tenant-edit-cancel:hover {
                    background: #E7D3BE;
                }

                .tenant-edit-submit {
                    color: #FFFFFF;
                    background: #684936;
                }

                .tenant-edit-submit:hover {
                    background: #493126;
                    transform: translateY(-1px);
                    box-shadow: 0 5px 12px rgba(73,49,38,.13);
                }

                .tenant-edit-submit svg {
                    width: 15px;
                    height: 15px;
                }

                .tenant-edit-footer {
                    text-align: center;
                    color: #99877A;
                    font-size: 10px;
                    margin-top: 21px;
                }

                @media (max-width: 600px) {
                    .tenant-edit-card {
                        padding: 21px 17px;
                    }

                    .tenant-edit-heading h1 {
                        font-size: 23px;
                    }

                    .tenant-edit-actions {
                        flex-direction: column-reverse;
                    }

                    .tenant-edit-button {
                        width: 100%;
                    }
                }
            </style>

            <div class="tenant-edit-page">

                <!-- Page Heading -->
                <div class="tenant-edit-heading">
                    <div class="tenant-edit-icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"/>
                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                        </svg>
                    </div>

                    <div>
                        <span class="tenant-eyebrow">TENANT MANAGEMENT</span>

                        <h1>Edit Penghuni</h1>

                        <p>
                            Perbarui informasi kontak penghuni kost.
                        </p>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="tenant-edit-card">

                    <!-- Tenant Profile -->
                    <div class="tenant-profile">

                        <div class="tenant-profile-avatar">
                            {{ strtoupper(substr($tenant->user->name ?? 'P', 0, 1)) }}
                        </div>

                        <div>
                            <div class="tenant-profile-name">
                                {{ $tenant->user->name ?? 'Pengguna tidak ditemukan' }}
                            </div>

                            <div class="tenant-profile-email">
                                {{ $tenant->user->email ?? '-' }}
                            </div>

                            <span class="tenant-profile-label">
                                AKUN PENGHUNI
                            </span>
                        </div>

                    </div>

                    <!-- Validation Errors -->
                    @if($errors->any())
                        <div class="tenant-edit-alert">
                            <strong>Periksa kembali data berikut:</strong>

                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Heading -->
                    <div class="tenant-edit-section-heading">
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

                        <div>
                            <h2>Informasi Penghuni</h2>
                            <p>Periksa informasi akun dan perbarui data kontak.</p>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <form action="{{ route('owner.tenants.update', $tenant->id) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <!-- Tenant Name -->
                        <div class="tenant-edit-field">
                            <label for="tenant_name">Nama Penghuni</label>

                            <input
                                type="text"
                                id="tenant_name"
                                value="{{ $tenant->user->name ?? '-' }}"
                                disabled
                            >

                            <span class="tenant-edit-hint">
                                Nama akun tidak dapat diubah melalui halaman ini.
                            </span>
                        </div>

                        <!-- Email -->
                        <div class="tenant-edit-field">
                            <label for="tenant_email">Email</label>

                            <input
                                type="email"
                                id="tenant_email"
                                value="{{ $tenant->user->email ?? '-' }}"
                                disabled
                            >

                            <span class="tenant-edit-hint">
                                Email akun digunakan untuk login penghuni.
                            </span>
                        </div>

                        <!-- Phone -->
                        <div class="tenant-edit-field">
                            <label for="phone">Nomor Telepon</label>

                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $tenant->phone) }}"
                                placeholder="Contoh: 081234567890"
                                required
                                autocomplete="tel"
                            >

                            @error('phone')
                                <span class="tenant-edit-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Emergency Contact -->
                        <div class="tenant-edit-field">
                            <label for="emergency_contact">
                                Kontak Darurat
                            </label>

                            <input
                                type="text"
                                id="emergency_contact"
                                name="emergency_contact"
                                value="{{ old('emergency_contact', $tenant->emergency_contact) }}"
                                placeholder="Nama dan nomor kontak darurat"
                            >

                            <span class="tenant-edit-hint">
                                Opsional. Isi dengan informasi orang yang dapat
                                dihubungi saat keadaan darurat.
                            </span>

                            @error('emergency_contact')
                                <span class="tenant-edit-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="tenant-edit-actions">

                            <a href="{{ route('owner.tenants.index') }}"
                               class="tenant-edit-button tenant-edit-cancel">
                                Batal
                            </a>

                            <button type="submit"
                                    class="tenant-edit-button tenant-edit-submit">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m5 12 4 4L19 6"/>
                                </svg>
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>
                </div>

                <p class="tenant-edit-footer">
                    Smart Kost Management System
                </p>

            </div>
        </div>
    </div>
</x-app-layout>

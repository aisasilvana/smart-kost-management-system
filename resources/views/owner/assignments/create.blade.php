
<x-app-layout>
    <div class="sk-page">
        <div class="sk-container assignment-container">

            <style>
                .assignment-page {
                    animation: assignmentFade .45s ease both;
                }

                @keyframes assignmentFade {
                    from {
                        opacity: 0;
                        transform: translateY(12px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .assignment-heading {
                    display: flex;
                    align-items: center;
                    gap: 13px;
                    margin-bottom: 25px;
                }

                .assignment-heading-icon {
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

                .assignment-heading-icon svg {
                    width: 23px;
                    height: 23px;
                }

                .assignment-eyebrow {
                    display: block;
                    margin-bottom: 5px;
                    color: #A67C62;
                    font-size: 10px;
                    font-weight: 800;
                    letter-spacing: 1.8px;
                }

                .assignment-heading h1 {
                    margin: 0 0 5px;
                    color: #493126;
                    font-size: 27px;
                    font-weight: 800;
                }

                .assignment-heading p {
                    margin: 0;
                    color: #99877A;
                    font-size: 11px;
                    line-height: 1.7;
                }

                .assignment-card {
                    padding: 29px;
                    background: #FFFFFF;
                    border: 1px solid #E9DED3;
                    border-radius: 17px;
                    box-shadow: 0 5px 20px rgba(73,49,38,.035);
                }

                .assignment-card-heading {
                    display: flex;
                    align-items: center;
                    gap: 11px;
                    margin-bottom: 24px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #E9DED3;
                }

                .assignment-card-icon {
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

                .assignment-card-icon svg {
                    width: 19px;
                    height: 19px;
                }

                .assignment-card-heading h2 {
                    margin: 0 0 4px;
                    color: #493126;
                    font-size: 15px;
                    font-weight: 800;
                }

                .assignment-card-heading p {
                    margin: 0;
                    color: #99877A;
                    font-size: 10px;
                }

                .assignment-fields {
                    display: grid;
                    grid-template-columns: 1fr;
                    gap: 21px;
                }

                .assignment-field {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                    min-width: 0;
                }

                .assignment-field label {
                    color: #493126;
                    font-size: 11px;
                    font-weight: 800;
                }

                .assignment-field select,
                .assignment-field input {
                    width: 100%;
                    height: 46px;
                    box-sizing: border-box;
                    padding: 0 13px;
                    border: 1px solid #E9DED3;
                    border-radius: 9px;
                    background: #FFFFFF;
                    color: #493126;
                    font-family: 'Manrope', sans-serif;
                    font-size: 11px;
                    outline: none;
                    transition: border-color .2s, box-shadow .2s;
                }

                .assignment-field select:focus,
                .assignment-field input:focus {
                    border-color: #B58B6B;
                    box-shadow: 0 0 0 3px rgba(181,139,107,.13);
                }

                .assignment-field select:disabled,
                .assignment-field input:disabled {
                    background: #F7F2EB;
                    cursor: not-allowed;
                }

                .assignment-field select option {
                    color: #493126;
                }

                .assignment-field-error {
                    color: #B44C45;
                    font-size: 10px;
                }

                .assignment-warning {
                    display: block;
                    padding: 10px 12px;
                    border-radius: 8px;
                    background: #FFF1EF;
                    color: #A33B35;
                    font-size: 10px;
                    line-height: 1.6;
                }

                .assignment-information {
                    display: flex;
                    align-items: flex-start;
                    gap: 12px;
                    margin-top: 25px;
                    padding: 15px;
                    border: 1px solid #EADBC9;
                    border-radius: 10px;
                    background: #FAF5EF;
                }

                .assignment-info-icon {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                    width: 21px;
                    height: 21px;
                    border-radius: 50%;
                    background: #684936;
                    color: #FFFFFF;
                    font-size: 11px;
                    font-weight: 800;
                }

                .assignment-information p {
                    margin: 0;
                    color: #806B5A;
                    font-size: 10px;
                    line-height: 1.8;
                }

                .assignment-footer {
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                    margin-top: 25px;
                    padding-top: 21px;
                    border-top: 1px solid #E9DED3;
                }

                .assignment-button {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
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

                .assignment-button.cancel {
                    background: #EFE5D9;
                    color: #684936;
                }

                .assignment-button.cancel:hover {
                    background: #E7D3BE;
                }

                .assignment-button.submit {
                    background: #684936;
                    color: #FFFFFF;
                }

                .assignment-button.submit:hover:not(:disabled) {
                    background: #493126;
                    transform: translateY(-1px);
                    box-shadow: 0 5px 12px rgba(73,49,38,.13);
                }

                .assignment-button.submit:disabled {
                    background: #B9AAA0;
                    cursor: not-allowed;
                    opacity: .8;
                }

                .assignment-button.submit svg {
                    width: 15px;
                    height: 15px;
                }

                .assignment-alert {
                    padding: 14px 16px;
                    margin-bottom: 18px;
                    border: 1px solid #F1D0CC;
                    border-radius: 10px;
                    background: #FFF1EF;
                    color: #A33B35;
                    font-size: 11px;
                    line-height: 1.7;
                }

                .assignment-alert ul {
                    padding-left: 19px;
                    margin: 7px 0 0;
                }

                .assignment-alert li {
                    margin-top: 3px;
                }

                .assignment-page-footer {
                    text-align: center;
                    color: #99877A;
                    font-size: 10px;
                    margin-top: 21px;
                }

                @media (max-width: 640px) {
                    .assignment-card {
                        padding: 21px 17px;
                    }

                    .assignment-heading h1 {
                        font-size: 23px;
                    }

                    .assignment-footer {
                        flex-direction: column-reverse;
                    }

                    .assignment-button {
                        width: 100%;
                    }
                }
            </style>

            <div class="assignment-page">

                <!-- Page Heading -->
                <div class="assignment-heading">
                    <div class="assignment-heading-icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21V8l9-5 9 5v13"/>
                            <path d="M9 21v-6h6v6"/>
                            <path d="M3 10h18"/>
                        </svg>
                    </div>

                    <div>
                        <span class="assignment-eyebrow">
                            ROOM ASSIGNMENT
                        </span>

                        <h1>Penempatan Penghuni</h1>

                        <p>
                            Tempatkan penghuni pada kamar kost yang tersedia.
                        </p>
                    </div>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="assignment-alert">
                        <strong>Terjadi kesalahan:</strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="assignment-alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Assignment Form -->
                <form
                    action="{{ route('owner.assignments.store') }}"
                    method="POST"
                    class="assignment-card"
                >
                    @csrf

                    <div class="assignment-card-heading">
                        <div class="assignment-card-icon">
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M19 8v6m-3-3h6"/>
                            </svg>
                        </div>

                        <div>
                            <h2>Informasi Penempatan</h2>
                            <p>
                                Pilih penghuni dan kamar yang akan ditempati.
                            </p>
                        </div>
                    </div>

                    <div class="assignment-fields">

                        <!-- Tenant Selection -->
                        <div class="assignment-field">
                            <label for="tenant_id">Nama Penghuni</label>

                            <select
                                name="tenant_id"
                                id="tenant_id"
                                required
                            >
                                <option value="">Pilih penghuni</option>

                                @foreach ($tenants as $tenant)
                                    <option
                                        value="{{ $tenant->id }}"
                                        {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}
                                    >
                                        {{ $tenant->user->name ?? 'Penghuni tanpa nama' }}
                                        — {{ $tenant->phone }}
                                    </option>
                                @endforeach
                            </select>

                            @error('tenant_id')
                                <span class="assignment-field-error">
                                    {{ $message }}
                                </span>
                            @enderror

                            @if ($tenants->isEmpty())
                                <small class="assignment-warning">
                                    Belum ada penghuni yang dapat ditempatkan.
                                    Tambahkan penghuni terlebih dahulu.
                                </small>
                            @endif
                        </div>

                        <!-- Room Selection -->
                        <div class="assignment-field">
                            <label for="room_id">Kamar Kost</label>

                            <select
                                name="room_id"
                                id="room_id"
                                required
                            >
                                <option value="">Pilih kamar tersedia</option>

                                @foreach ($rooms as $room)
                                    <option
                                        value="{{ $room->id }}"
                                        {{ old('room_id') == $room->id ? 'selected' : '' }}
                                    >
                                        {{ $room->kost->name ?? 'Kost' }}
                                        — Kamar {{ $room->room_number }}
                                        — Rp{{ number_format($room->monthly_price, 0, ',', '.') }}/bulan
                                    </option>
                                @endforeach
                            </select>

                            @error('room_id')
                                <span class="assignment-field-error">
                                    {{ $message }}
                                </span>
                            @enderror

                            @if ($rooms->isEmpty())
                                <small class="assignment-warning">
                                    Belum ada kamar tersedia. Tambahkan kamar
                                    atau periksa status kamar Anda.
                                </small>
                            @endif
                        </div>

                        <!-- Start Date -->
                        <div class="assignment-field">
                            <label for="start_date">
                                Tanggal Mulai Menempati
                            </label>

                            <input
                                type="date"
                                name="start_date"
                                id="start_date"
                                value="{{ old('start_date', date('Y-m-d')) }}"
                                required
                            >

                            @error('start_date')
                                <span class="assignment-field-error">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>

                    <!-- Information -->
                    <div class="assignment-information">
                        <span class="assignment-info-icon">i</span>

                        <p>
                            Setelah penempatan berhasil, status kamar akan
                            berubah menjadi <strong>Occupied</strong> dan
                            penghuni akan tercatat sebagai penghuni aktif.
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="assignment-footer">

                        <a
                            href="{{ route('owner.tenants.index') }}"
                            class="assignment-button cancel"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="assignment-button submit"
                            {{ $tenants->isEmpty() || $rooms->isEmpty() ? 'disabled' : '' }}
                        >
                            <svg viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14m-7-7 7 7-7 7"/>
                            </svg>
                            Simpan Penempatan
                        </button>

                    </div>

                </form>

                <p class="assignment-page-footer">
                    Smart Kost Management System
                </p>

            </div>
        </div>
    </div>
</x-app-layout>

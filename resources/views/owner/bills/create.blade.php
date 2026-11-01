
<x-app-layout>
    <div class="sk-page">
        <div class="sk-container bill-form-container">

            {{-- PAGE HEADER --}}
            <div class="bill-form-heading">
                <div class="bill-heading-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 3h10l3 3v15H4V3z"/>
                        <path d="M8 10h8M8 14h8M8 18h5"/>
                    </svg>
                </div>

                <div>
                    <span class="bill-form-eyebrow">FINANCIAL MANAGEMENT</span>
                    <h1>Buat Tagihan</h1>
                    <p>Buat tagihan sewa bulanan untuk penghuni kost Anda.</p>
                </div>
            </div>

            {{-- VALIDATION ERRORS --}}
            @if ($errors->any())
                <div class="bill-form-alert">
                    <div class="bill-alert-icon">!</div>
                    <div>
                        <strong>Periksa kembali formulir Anda.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- FORM --}}
            <form
                action="{{ route('owner.bills.store') }}"
                method="POST"
                class="bill-form-card"
            >
                @csrf

                {{-- SECTION HEADING --}}
                <div class="bill-form-section">
                    <div>
                        <span class="bill-section-label">BILLING INFORMATION</span>
                        <h2>Informasi Tagihan</h2>
                        <p>Lengkapi informasi tagihan berdasarkan penghuni dan kamar yang dipilih.</p>
                    </div>

                    <span class="bill-required-label">
                        * Wajib diisi
                    </span>
                </div>

                <div class="bill-form-fields">

                    {{-- TENANT AND ROOM --}}
                    <div class="bill-form-field full-width">
                        <label for="room_assignment_id">
                            Penghuni dan Kamar
                            <span>*</span>
                        </label>

                        <div class="bill-input-wrapper">
                            <div class="bill-input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7" stroke-linecap="round">
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M2 21v-2a7 7 0 0 1 14 0v2"/>
                                    <path d="M19 8v6m3-3h-6"/>
                                </svg>
                            </div>

                            <select
                                name="room_assignment_id"
                                id="room_assignment_id"
                                required
                                class="bill-select"
                            >
                                <option value="">Pilih penghuni dan kamar</option>

                                @foreach ($assignments as $assignment)
                                    <option
                                        value="{{ $assignment->id }}"
                                        {{ old('room_assignment_id') == $assignment->id ? 'selected' : '' }}
                                    >
                                        {{ $assignment->tenant->user->name ?? 'Penghuni' }}
                                        — {{ $assignment->room->kost->name ?? 'Kost' }}
                                        — Kamar {{ $assignment->room->room_number ?? '-' }}
                                        — Rp{{ number_format($assignment->room->monthly_price ?? 0, 0, ',', '.') }}/bulan
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if ($assignments->isEmpty())
                            <small class="bill-form-warning">
                                Belum ada penghuni dengan penempatan aktif.
                                Tempatkan penghuni ke kamar terlebih dahulu.
                            </small>
                        @else
                            <small>
                                Pilih penghuni yang memiliki penempatan kamar aktif.
                                Harga tagihan mengikuti harga sewa kamar.
                            </small>
                        @endif
                    </div>

                    {{-- BILLING MONTH --}}
                    <div class="bill-form-field">
                        <label for="billing_month">
                            Periode Tagihan
                            <span>*</span>
                        </label>

                        <div class="bill-input-wrapper">
                            <div class="bill-input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7" stroke-linecap="round">
                                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                                    <path d="M16 3v4M8 3v4M3 10h18"/>
                                </svg>
                            </div>

                            <input
                                type="month"
                                name="billing_month"
                                id="billing_month"
                                value="{{ old('billing_month', now()->format('Y-m')) }}"
                                required
                            >
                        </div>

                        <small>Pilih bulan dan tahun tagihan.</small>
                    </div>

                    {{-- DUE DATE --}}
                    <div class="bill-form-field">
                        <label for="due_date">
                            Tanggal Jatuh Tempo
                            <span>*</span>
                        </label>

                        <div class="bill-input-wrapper">
                            <div class="bill-input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7" stroke-linecap="round">
                                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                                    <path d="M16 3v4M8 3v4M3 10h18"/>
                                    <path d="m9 15 2 2 4-4"/>
                                </svg>
                            </div>

                            <input
                                type="date"
                                name="due_date"
                                id="due_date"
                                value="{{ old('due_date', now()->addDays(7)->format('Y-m-d')) }}"
                                required
                            >
                        </div>

                        <small>Tentukan batas waktu pembayaran penghuni.</small>
                    </div>

                </div>

                {{-- INFORMATION BOX --}}
                <div class="bill-form-info">
                    <div class="bill-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 11v5M12 8h.01"/>
                        </svg>
                    </div>

                    <div>
                        <strong>Informasi Pembuatan Tagihan</strong>
                        <p>
                            Tagihan akan dibuat dengan status
                            <strong class="bill-highlight">Belum Dibayar</strong>.
                            Jumlah tagihan diambil otomatis dari harga sewa bulanan
                            kamar yang dipilih.
                        </p>
                    </div>
                </div>

                {{-- FORM FOOTER --}}
                <div class="bill-form-footer">
                    <a
                        href="{{ route('owner.bills.index') }}"
                        class="bill-form-button cancel"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="bill-form-button submit"
                        {{ $assignments->isEmpty() ? 'disabled' : '' }}
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Simpan Tagihan
                    </button>
                </div>

            </form>

            <div class="bill-form-footer-note">
                <span>Smart Kost Management System</span>
                <span>Billing Management</span>
            </div>

        </div>
    </div>

    <style>
        .bill-form-container {
            max-width: 1000px;
            margin: 0 auto;
            padding-bottom: 35px;
            font-family: 'Manrope', sans-serif;
        }

        .bill-form-heading {
            display: flex;
            align-items: center;
            gap: 17px;
            margin-bottom: 28px;
        }

        .bill-heading-icon {
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

        .bill-heading-icon svg {
            width: 25px;
            height: 25px;
        }

        .bill-form-eyebrow,
        .bill-section-label {
            display: block;
            margin-bottom: 7px;
            color: #A87959;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.7px;
        }

        .bill-form-heading h1 {
            margin: 0 0 7px;
            color: #493126;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .bill-form-heading p {
            margin: 0;
            color: #99877A;
            font-size: 12px;
            line-height: 1.7;
        }

        .bill-form-card {
            padding: 29px;
            border: 1px solid #E9DED3;
            border-radius: 16px;
            background: #FFFFFF;
            box-shadow: 0 10px 30px rgba(73, 49, 38, .04);
        }

        .bill-form-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 27px;
            padding-bottom: 20px;
            border-bottom: 1px solid #F0E9E2;
        }

        .bill-form-section h2 {
            margin: 0 0 7px;
            color: #493126;
            font-size: 17px;
            font-weight: 800;
        }

        .bill-form-section p {
            margin: 0;
            color: #99877A;
            font-size: 11px;
            line-height: 1.7;
        }

        .bill-required-label {
            padding: 7px 10px;
            border-radius: 7px;
            background: #F7F2EB;
            color: #8B654D;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .bill-form-fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 23px 20px;
        }

        .bill-form-field {
            display: flex;
            flex-direction: column;
            gap: 9px;
            min-width: 0;
        }

        .bill-form-field.full-width {
            grid-column: 1 / -1;
        }

        .bill-form-field label {
            color: #493126;
            font-size: 11px;
            font-weight: 800;
        }

        .bill-form-field label span {
            color: #B65B4D;
        }

        .bill-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .bill-input-icon {
            position: absolute;
            left: 14px;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            color: #A1846D;
        }

        .bill-input-icon svg {
            width: 18px;
            height: 18px;
        }

        .bill-input-wrapper input,
        .bill-input-wrapper select {
            width: 100%;
            height: 48px;
            box-sizing: border-box;
            padding: 0 14px 0 43px;
            border: 1px solid #E9DED3;
            border-radius: 9px;
            background: #FFFFFF;
            color: #493126;
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            outline: none;
            transition: .2s ease;
        }

        .bill-input-wrapper select {
            cursor: pointer;
        }

        .bill-input-wrapper input:focus,
        .bill-input-wrapper select:focus {
            border-color: #B58B6B;
            box-shadow: 0 0 0 3px rgba(181, 139, 107, .13);
        }

        .bill-form-field small {
            color: #99877A;
            font-size: 10px;
            line-height: 1.7;
        }

        .bill-form-field .bill-form-warning {
            color: #B44C45;
        }

        .bill-form-info {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            margin-top: 27px;
            padding: 17px;
            border: 1px solid #EADBC9;
            border-radius: 10px;
            background: #FAF5EF;
        }

        .bill-info-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #EFE5D9;
            color: #684936;
        }

        .bill-info-icon svg {
            width: 19px;
            height: 19px;
        }

        .bill-form-info > div:last-child {
            flex: 1;
        }

        .bill-form-info strong {
            display: block;
            margin-bottom: 5px;
            color: #684936;
            font-size: 11px;
            font-weight: 800;
        }

        .bill-form-info p {
            margin: 0;
            color: #806B5A;
            font-size: 10px;
            line-height: 1.8;
        }

        .bill-form-info .bill-highlight {
            display: inline;
            color: #684936;
        }

        .bill-form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 11px;
            margin-top: 27px;
            padding-top: 22px;
            border-top: 1px solid #E9DED3;
        }

        .bill-form-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            padding: 0 20px;
            border: none;
            border-radius: 9px;
            font-family: 'Manrope', sans-serif;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: .2s ease;
        }

        .bill-form-button svg {
            width: 15px;
            height: 15px;
        }

        .bill-form-button.cancel {
            background: #EFE5D9;
            color: #684936;
        }

        .bill-form-button.cancel:hover {
            background: #E7D3BE;
            color: #493126;
        }

        .bill-form-button.submit {
            background: #684936;
            color: #FFFFFF;
        }

        .bill-form-button.submit:hover {
            background: #493126;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(73, 49, 38, .13);
        }

        .bill-form-button.submit:disabled {
            background: #B9AAA0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .bill-form-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 15px 17px;
            margin-bottom: 20px;
            border: 1px solid #F1D0CC;
            border-radius: 10px;
            background: #FFF1EF;
            color: #A33B35;
            font-size: 11px;
        }

        .bill-alert-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #F4D9D5;
            font-weight: 800;
        }

        .bill-form-alert strong {
            display: block;
            margin-bottom: 5px;
        }

        .bill-form-alert ul {
            padding-left: 18px;
            margin: 7px 0 0;
            line-height: 1.8;
        }

        .bill-form-footer-note {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 3px 0;
            color: #A39488;
            font-size: 10px;
        }

        @media (max-width: 640px) {
            .bill-form-container {
                padding-bottom: 25px;
            }

            .bill-form-heading {
                align-items: flex-start;
                gap: 12px;
            }

            .bill-heading-icon {
                width: 45px;
                height: 45px;
            }

            .bill-form-heading h1 {
                font-size: 23px;
            }

            .bill-form-card {
                padding: 21px 17px;
            }

            .bill-form-fields {
                grid-template-columns: 1fr;
            }

            .bill-form-field.full-width {
                grid-column: auto;
            }

            .bill-form-section {
                flex-direction: column;
            }

            .bill-form-footer {
                flex-direction: column-reverse;
            }

            .bill-form-button {
                width: 100%;
                box-sizing: border-box;
            }

            .bill-form-footer-note {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</x-app-layout>

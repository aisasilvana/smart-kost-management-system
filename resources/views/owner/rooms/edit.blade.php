
<x-app-layout>
    <div class="sk-page">
        <div class="sk-container" style="max-width:850px;">

            <style>
                .sk-room-edit {
                    animation: roomEditFade .45s ease both;
                }

                @keyframes roomEditFade {
                    from {
                        opacity: 0;
                        transform: translateY(12px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .sk-room-edit-header {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 25px;
                }

                .sk-room-edit-icon {
                    width: 48px;
                    height: 48px;
                    border-radius: 14px;
                    background: #EFE5D9;
                    color: #684936;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                }

                .sk-room-edit-icon svg {
                    width: 23px;
                    height: 23px;
                }

                .sk-room-edit-card {
                    background: #FFFFFF;
                    border: 1px solid #E9DED3;
                    border-radius: 18px;
                    padding: 30px;
                    box-shadow: 0 5px 20px rgba(73,49,38,.035);
                }

                .sk-room-edit-heading {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    margin-bottom: 24px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #E9DED3;
                }

                .sk-room-edit-heading svg {
                    width: 20px;
                    height: 20px;
                    color: #8B654D;
                }

                .sk-room-edit-field {
                    margin-bottom: 21px;
                }

                .sk-room-edit-field label {
                    display: block;
                    font-size: 12px;
                    font-weight: 700;
                    color: #493126;
                    margin-bottom: 9px;
                }

                .sk-room-edit-field input,
                .sk-room-edit-field select {
                    width: 100%;
                    min-height: 46px;
                    border: 1px solid #E9DED3;
                    border-radius: 10px;
                    padding: 11px 14px;
                    background: #FFFFFF;
                    color: #493A30;
                    font-family: 'Manrope', sans-serif;
                    font-size: 12px;
                    outline: none;
                    transition: border-color .2s, box-shadow .2s;
                }

                .sk-room-edit-field input:focus,
                .sk-room-edit-field select:focus {
                    border-color: #A67C62;
                    box-shadow: 0 0 0 3px rgba(166,124,98,.12);
                }

                .sk-room-edit-field input:disabled {
                    background: #F7F2EB;
                    color: #8B654D;
                    cursor: not-allowed;
                }

                .sk-room-edit-hint {
                    display: block;
                    margin-top: 7px;
                    color: #99877A;
                    font-size: 11px;
                    line-height: 1.6;
                }

                .sk-room-edit-error {
                    color: #A75E52;
                    font-size: 11px;
                    margin-top: 6px;
                }

                .sk-room-edit-error-box {
                    padding: 15px 17px;
                    background: #F8E8E4;
                    border: 1px solid #EFD2CB;
                    border-radius: 11px;
                    color: #A75E52;
                    margin-bottom: 23px;
                    font-size: 12px;
                }

                .sk-room-edit-error-box ul {
                    padding-left: 19px;
                    margin-top: 8px;
                }

                .sk-room-edit-error-box li {
                    margin-top: 4px;
                }

                .sk-room-edit-actions {
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                    flex-wrap: wrap;
                    padding-top: 22px;
                    margin-top: 8px;
                    border-top: 1px solid #E9DED3;
                }

                .sk-room-edit-actions a,
                .sk-room-edit-actions button {
                    min-height: 42px;
                    padding: 11px 19px;
                    border-radius: 9px;
                    font-family: 'Manrope', sans-serif;
                    font-size: 11px;
                    font-weight: 800;
                    text-decoration: none;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    transition: all .2s ease;
                    cursor: pointer;
                    border: none;
                }

                .sk-room-edit-cancel {
                    background: #EFE5D9;
                    color: #684936;
                }

                .sk-room-edit-cancel:hover {
                    background: #E7D3BE;
                }

                .sk-room-edit-submit {
                    background: #684936;
                    color: #FFFFFF;
                }

                .sk-room-edit-submit:hover {
                    background: #493126;
                    transform: translateY(-1px);
                    box-shadow: 0 5px 12px rgba(73,49,38,.15);
                }

                .sk-room-edit-submit svg {
                    width: 15px;
                    height: 15px;
                }

                @media (max-width: 600px) {
                    .sk-room-edit-card {
                        padding: 21px 17px;
                    }

                    .sk-room-edit-actions {
                        flex-direction: column-reverse;
                    }

                    .sk-room-edit-actions a,
                    .sk-room-edit-actions button {
                        width: 100%;
                    }
                }
            </style>

            <div class="sk-room-edit">

                <!-- Page Header -->
                <div class="sk-room-edit-header">
                    <div class="sk-room-edit-icon">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"/>
                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                        </svg>
                    </div>

                    <div>
                        <div class="sk-eyebrow" style="color:#A67C62;">
                            ROOM MANAGEMENT
                        </div>

                        <h1 class="sk-section-heading"
                            style="font-size:27px; margin-top:5px;">
                            Edit Kamar
                        </h1>

                        <p class="sk-section-description">
                            Perbarui informasi kamar {{ $room->room_number }}.
                        </p>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="sk-room-edit-card">

                    <div class="sk-room-edit-heading">
                        <svg viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <path d="M3 10h18M8 4v6m8-6v6"/>
                        </svg>

                        <div>
                            <h2 style="font-size:15px; font-weight:800; color:#493126;">
                                Informasi Kamar
                            </h2>

                            <p style="font-size:11px; color:#99877A; margin-top:3px;">
                                Properti: {{ $kost->name }}
                            </p>
                        </div>
                    </div>

                    <!-- Validation Errors -->
                    @if($errors->any())
                        <div class="sk-room-edit-error-box">
                            <strong>Periksa kembali data berikut:</strong>

                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('owner.kosts.rooms.update', [$kost->id, $room->id]) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <!-- Property -->
                        <div class="sk-room-edit-field">
                            <label for="kost_name">Properti Kost</label>

                            <input type="text"
                                   id="kost_name"
                                   value="{{ $kost->name }}"
                                   disabled>

                            <span class="sk-room-edit-hint">
                                Kamar ini terdaftar pada properti tersebut.
                            </span>
                        </div>

                        <!-- Room Number -->
                        <div class="sk-room-edit-field">
                            <label for="room_number">Nomor Kamar</label>

                            <input type="text"
                                   id="room_number"
                                   name="room_number"
                                   value="{{ old('room_number', $room->room_number) }}"
                                   maxlength="255"
                                   required>

                            @error('room_number')
                                <p class="sk-room-edit-error">{{ $message }}</p>
                            @enderror

                            <span class="sk-room-edit-hint">
                                Perbarui nomor kamar jika diperlukan.
                            </span>
                        </div>

                        <!-- Monthly Price -->
                        <div class="sk-room-edit-field">
                            <label for="monthly_price">
                                Harga Sewa per Bulan (Rp)
                            </label>

                            <input type="number"
                                   id="monthly_price"
                                   name="monthly_price"
                                   value="{{ old('monthly_price', $room->monthly_price) }}"
                                   min="0"
                                   step="1000"
                                   required>

                            @error('monthly_price')
                                <p class="sk-room-edit-error">{{ $message }}</p>
                            @enderror

                            <span class="sk-room-edit-hint">
                                Masukkan harga sewa terbaru dalam rupiah.
                            </span>
                        </div>

                        <!-- Room Status -->
                        <div class="sk-room-edit-field">
                            <label for="status">Status Kamar</label>

                            <select id="status" name="status" required>
                                <option value="available"
                                    {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>
                                    Tersedia
                                </option>

                                <option value="occupied"
                                    {{ old('status', $room->status) === 'occupied' ? 'selected' : '' }}>
                                    Terisi
                                </option>
                            </select>

                            @error('status')
                                <p class="sk-room-edit-error">{{ $message }}</p>
                            @enderror

                            <span class="sk-room-edit-hint">
                                Sesuaikan status dengan kondisi kamar saat ini.
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="sk-room-edit-actions">

                            <a href="{{ route('owner.kosts.rooms.index', $kost->id) }}"
                               class="sk-room-edit-cancel">
                                Batal
                            </a>

                            <button type="submit" class="sk-room-edit-submit">
                                <svg viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>
                </div>

                <p style="text-align:center; color:#99877A; font-size:10px; margin-top:22px;">
                    Smart Kost Management System
                </p>

            </div>
        </div>
    </div>
</x-app-layout>

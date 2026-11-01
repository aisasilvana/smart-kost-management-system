
<x-app-layout>
    <div class="py-8" style="background-color: #FAF7F3; min-height: 85vh;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h2 style="color: #3E2723; font-size: 26px; font-weight: 700;">
                    Tambah Kost
                </h2>

                <p style="color: #8B634B; margin-top: 6px;">
                    Masukkan informasi properti kost Anda.
                </p>
            </div>

            <!-- Form Card -->
            <div style="
                background-color: #FFFFFF;
                padding: 30px;
                border-radius: 14px;
                box-shadow: 0 4px 15px rgba(62,39,35,0.07);
                border: 1px solid #E8DDD3;
            ">

                <form action="{{ route('owner.kosts.store') }}"
                      method="POST">

                    @csrf

                    <!-- Nama Kost -->
                    <div style="margin-bottom: 22px;">
                        <label for="name"
                               style="display: block; color: #5C4033; font-weight: 600; margin-bottom: 9px;">
                            Nama Kost
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Kost Melati"
                            style="
                                width: 100%;
                                padding: 12px 14px;
                                border: 1px solid #D6C3B5;
                                border-radius: 8px;
                                color: #3E3028;
                                background-color: #FFFFFF;
                                outline: none;
                            "
                        >

                        @error('name')
                            <p style="color: #A94442; font-size: 13px; margin-top: 6px;">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Alamat Kost -->
                    <div style="margin-bottom: 22px;">
                        <label for="address"
                               style="display: block; color: #5C4033; font-weight: 600; margin-bottom: 9px;">
                            Alamat Kost
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            placeholder="Masukkan alamat lengkap kost"
                            style="
                                width: 100%;
                                padding: 12px 14px;
                                border: 1px solid #D6C3B5;
                                border-radius: 8px;
                                color: #3E3028;
                                background-color: #FFFFFF;
                                resize: vertical;
                                outline: none;
                            "
                        >{{ old('address') }}</textarea>

                        @error('address')
                            <p style="color: #A94442; font-size: 13px; margin-top: 6px;">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div style="margin-bottom: 28px;">
                        <label for="description"
                               style="display: block; color: #5C4033; font-weight: 600; margin-bottom: 9px;">
                            Deskripsi Kost
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Jelaskan fasilitas dan informasi kost Anda"
                            style="
                                width: 100%;
                                padding: 12px 14px;
                                border: 1px solid #D6C3B5;
                                border-radius: 8px;
                                color: #3E3028;
                                background-color: #FFFFFF;
                                resize: vertical;
                                outline: none;
                            "
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p style="color: #A94442; font-size: 13px; margin-top: 6px;">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div style="
                        display: flex;
                        justify-content: flex-end;
                        gap: 12px;
                        flex-wrap: wrap;
                    ">

                        <a href="{{ route('owner.kosts.index') }}"
                           style="
                               display: inline-block;
                               padding: 11px 20px;
                               border: 1px solid #A67C62;
                               color: #5C4033;
                               border-radius: 8px;
                               text-decoration: none;
                               font-weight: 600;
                           ">
                            Kembali
                        </a>

                        <button type="submit"
                                style="
                                    padding: 11px 22px;
                                    background-color: #5C4033;
                                    color: #FFFFFF;
                                    border: none;
                                    border-radius: 8px;
                                    font-weight: 600;
                                    cursor: pointer;
                                ">
                            Simpan Kost
                        </button>

                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>

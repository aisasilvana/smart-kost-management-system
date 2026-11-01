
<section class="sk-delete-account">

    {{-- DELETE ACCOUNT INFORMATION --}}
    <div class="sk-delete-description">
        <div class="sk-delete-warning-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 9v4"/>
                <path d="M12 17h.01"/>
                <path d="M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
            </svg>
        </div>

        <div>
            <h3>Perhatian Sebelum Menghapus Akun</h3>
            <p>
                Penghapusan akun akan menghapus data dan informasi yang terhubung
                dengan akun Anda secara permanen. Pastikan Anda sudah menyimpan
                informasi penting sebelum melanjutkan.
            </p>
        </div>
    </div>

    {{-- DELETE BUTTON --}}
    <button
        type="button"
        class="sk-delete-trigger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 6h18"/>
            <path d="M8 6V4h8v2"/>
            <path d="m19 6-1 14H6L5 6"/>
            <path d="M10 11v5M14 11v5"/>
        </svg>
        Hapus Akun Saya
    </button>

    {{-- CONFIRMATION MODAL --}}
    <x-modal
        name="confirm-user-deletion"
        :show="$errors->userDeletion->isNotEmpty()"
        focusable
    >
        <form
            method="post"
            action="{{ route('profile.destroy') }}"
            class="sk-delete-modal"
        >
            @csrf
            @method('delete')

            <div class="sk-modal-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>
                    <path d="M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                </svg>
            </div>

            <h2>Konfirmasi Penghapusan Akun</h2>

            <p class="sk-modal-description">
                Apakah Anda yakin ingin menghapus akun ini? Seluruh data yang
                terhubung dengan akun akan dihapus secara permanen dan tindakan
                ini tidak dapat dibatalkan.
            </p>

            <div class="sk-modal-password">
                <label for="password">
                    Masukkan Password untuk Konfirmasi
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Masukkan password Anda"
                    autocomplete="current-password"
                    required
                >

                @if ($errors->userDeletion->has('password'))
                    <p class="sk-modal-error">
                        {{ $errors->userDeletion->first('password') }}
                    </p>
                @endif
            </div>

            <div class="sk-modal-actions">
                <button
                    type="button"
                    class="sk-modal-cancel"
                    x-on:click="$dispatch('close')"
                >
                    Batal
                </button>

                <button type="submit" class="sk-modal-delete">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>

    <style>
        .sk-delete-account {
            width: 100%;
            font-family: 'Manrope', sans-serif;
        }

        .sk-delete-description {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 17px;
            margin-bottom: 20px;
            border: 1px solid #EBDDD5;
            border-radius: 11px;
            background: #FCF6F2;
        }

        .sk-delete-warning-icon {
            display: flex;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #F5E5DE;
            color: #A65D4E;
        }

        .sk-delete-warning-icon svg {
            width: 20px;
            height: 20px;
        }

        .sk-delete-description h3 {
            margin: 0 0 6px;
            color: #874638;
            font-size: 12px;
            font-weight: 800;
        }

        .sk-delete-description p {
            margin: 0;
            color: #99877A;
            font-size: 11px;
            line-height: 1.7;
        }

        .sk-delete-trigger {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 10px 17px;
            border: 1px solid #E4C8BE;
            border-radius: 9px;
            background: #fff;
            color: #A65D4E;
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: background .2s, color .2s;
        }

        .sk-delete-trigger:hover {
            background: #A65D4E;
            color: #fff;
        }

        .sk-delete-trigger svg {
            width: 16px;
            height: 16px;
        }

        .sk-delete-modal {
            padding: 30px;
            font-family: 'Manrope', sans-serif;
        }

        .sk-modal-icon {
            display: flex;
            width: 49px;
            height: 49px;
            align-items: center;
            justify-content: center;
            margin-bottom: 19px;
            border-radius: 14px;
            background: #F9ECE8;
            color: #A65D4E;
        }

        .sk-modal-icon svg {
            width: 24px;
            height: 24px;
        }

        .sk-delete-modal h2 {
            margin: 0;
            color: #493126;
            font-size: 18px;
            font-weight: 800;
        }

        .sk-modal-description {
            margin-top: 10px;
            color: #99877A;
            font-size: 12px;
            line-height: 1.8;
        }

        .sk-modal-password {
            margin-top: 24px;
        }

        .sk-modal-password label {
            display: block;
            margin-bottom: 9px;
            color: #684936;
            font-size: 12px;
            font-weight: 800;
        }

        .sk-modal-password input {
            width: 100%;
            min-height: 45px;
            padding: 11px 13px;
            border: 1px solid #E9DED3;
            border-radius: 9px;
            outline: none;
            background: #FCFAF7;
            color: #493A30;
            font-family: 'Manrope', sans-serif;
            font-size: 13px;
        }

        .sk-modal-password input:focus {
            border-color: #A9876C;
            box-shadow: 0 0 0 3px rgba(181, 139, 107, .12);
        }

        .sk-modal-error {
            margin-top: 8px;
            color: #B4534B;
            font-size: 11px;
        }

        .sk-modal-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 26px;
        }

        .sk-modal-cancel,
        .sk-modal-delete {
            min-height: 40px;
            padding: 10px 17px;
            border: none;
            border-radius: 9px;
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: background .2s;
        }

        .sk-modal-cancel {
            background: #F3EAE0;
            color: #684936;
        }

        .sk-modal-cancel:hover {
            background: #E9DED3;
        }

        .sk-modal-delete {
            background: #A65D4E;
            color: #fff;
        }

        .sk-modal-delete:hover {
            background: #874638;
        }

        @media (max-width: 480px) {
            .sk-delete-modal {
                padding: 22px;
            }

            .sk-modal-actions {
                flex-direction: column-reverse;
            }

            .sk-modal-actions button {
                width: 100%;
            }
        }
    </style>
</section>

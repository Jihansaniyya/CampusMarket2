@extends('layouts.auth')

@section('title', 'Registrasi Penjual (Toko)')

@section('content')
    {{-- FONT & BACKGROUND SAMA DENGAN LOGIN --}}
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Rubik', sans-serif;
        }

        body {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background-color: #e7f0ff;
        }

        html,
        body {
            height: 100%;
            overflow-y: auto !important;
        }

        body {
            display: block !important;
        }

        .background-blur {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('assets/bg2.png') }}") no-repeat center center/cover;
            filter: blur(5px);
            z-index: -1;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(255, 255, 255, 0.35);
            z-index: -1;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.7s ease-out;
        }

        /* === Custom checkbox Terms & Conditions === */
        .cm-terms {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .cm-checkbox-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 0.45rem;
            border: 1px solid #9ca3af;
            /* gray-400 */
            background-color: #ffffff;
            box-sizing: border-box;
            position: relative;
            transition: background-color 0.15s ease-out, border-color 0.15s ease-out;
        }

        .cm-checkbox-box::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 10px;
            border-right: 2px solid #ffffff;
            border-bottom: 2px solid #ffffff;
            transform: rotate(45deg) scale(0);
            transform-origin: center;
            transition: transform 0.15s ease-out;
        }

        .cm-terms:checked+.cm-checkbox-box {
            background-color: #2563eb;
            /* blue-600 */
            border-color: #2563eb;
        }

        .cm-terms:checked+.cm-checkbox-box::after {
            transform: rotate(45deg) scale(1);
        }
    </style>

    {{-- BACKGROUND --}}
    <div class="background-blur"></div>
    <div class="overlay"></div>

    {{-- SEMUA KONTEN --}}
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 fade-in">

        {{-- Header Halaman --}}
        <header class="mb-6">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2">
                    <li><a href="{{ route('login') }}" class="hover:text-gray-700">Login</a></li>
                    <li aria-hidden="true" class="text-gray-500 font-semibold">/</li>
                    <li class="text-gray-700 font-medium">Registrasi</li>
                </ol>
            </nav>

            <div class="flex items-start justify-between gap-3">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">
                        Registrasi Penjual
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Daftarkan toko Anda di CampusMarket. Lengkapi data di bawah ini,
                        setelah dikirim akan dilakukan <span class="font-semibold">verifikasi administrasi</span>.
                    </p>
                </div>
            </div>
        </header>

        {{-- Card --}}
        <div class="relative bg-white/90 backdrop-blur rounded-3xl shadow-xl ring-1 ring-black/5 overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-1 bg-linear-to-r from-blue-600 via-blue-500 to-blue-600"></div>

            {{-- Alerts --}}
            @if (session('success'))
                <div class="mx-6 mt-6 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800">
                    {{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="mx-6 mt-6 rounded-xl border border-rose-200 bg-rose-50">
                    <div class="px-4 py-3 text-rose-800 font-semibold">Periksa kembali input kamu:</div>
                    <ul class="px-6 pb-3 list-disc text-sm text-rose-700 space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="sellerForm">
                @csrf

                {{-- Hidden field for role (this form is specifically for sellers) --}}
                <input type="hidden" name="role" value="seller">

                {{-- ================== AKUN ================== --}}
                <section class="px-6 pt-8">
                    <div class="mb-2">
                        <h2 class="text-lg font-semibold text-gray-900">Data Akun</h2>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">Data ini digunakan untuk login ke aplikasi.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- NAMA LENGKAP — FULL WIDTH --}}
                        <div class="relative md:col-span-2">
                            <input autofocus type="text" name="name" value="{{ old('name') }}" required
                                minlength="3"
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                                peer-focus:top-2 peer-focus:text-xs transition-all">
                                Nama Lengkap <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- EMAIL --}}
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                                peer-focus:top-2 peer-focus:text-xs transition-all">
                                Email <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- NO HP --}}
                        <div class="relative">
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                pattern="^(\+62|62|0)[0-9]{9,12}$"
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" " oninput="maskNumber(this, 13)">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                                peer-focus:top-2 peer-focus:text-xs transition-all">
                                No. Handphone <span class="text-rose-600">*</span>
                            </label>
                            <p class="text-[11px] text-gray-400 mt-1">Format: 08xxxxxxxxxx</p>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="relative">
                            <input type="password" id="password" name="password" required minlength="8"
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 pr-11 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                                peer-focus:top-2 peer-focus:text-xs transition-all">
                                Password <span class="text-rose-600">*</span>
                            </label>
                            <button type="button" onclick="togglePwd('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i id="password-icon" class="fas fa-eye"></i>
                            </button>
                        </div>

                        {{-- KONFIRMASI PASSWORD --}}
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 pr-11 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                                peer-focus:top-2 peer-focus:text-xs transition-all">
                                Konfirmasi Password <span class="text-rose-600">*</span>
                            </label>
                            <button type="button" onclick="togglePwd('password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i id="password_confirmation-icon" class="fas fa-eye"></i>
                            </button>
                        </div>

                    </div>
                </section>

                {{-- Divider --}}
                <div class="px-6 py-6">
                    <div class="h-px bg-linear-to-r from-transparent via-gray-200 to-transparent"></div>
                </div>

                {{-- ================== DATA TOKO ================== --}}
                <section class="px-6">
                    <div class="mb-2">
                        <h2 class="text-lg font-semibold text-gray-900">Data Toko</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- 1 Nama Toko --}}
                        <div class="relative">
                            <input type="text" name="store_name" value="{{ old('store_name') }}" required
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                                Nama Toko <span class="text-rose-600">*</span>
                            </label>
                            @error('store_name')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 2 Deskripsi singkat --}}
                        <div class="relative">
                            <input type="text" name="store_description" id="store_description"
                                value="{{ old('store_description') }}" required maxlength="120"
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" " oninput="countChars('store_description','descCounter',120)">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                                Deskripsi Singkat <span class="text-rose-600">*</span>
                            </label>
                            <div class="flex justify-end"><span id="descCounter"
                                    class="text-[11px] text-gray-400 mt-1">0/120</span></div>
                            @error('store_description')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                <div class="px-6 py-6">
                    <div class="h-px bg-linear-to-r from-transparent via-gray-200 to-transparent"></div>
                </div>

                {{-- ================== PIC ================== --}}
                <section class="px-6">
                    <div class="mb-2">
                        <h2 class="text-lg font-semibold text-gray-900">Data Penanggung Jawab</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- 3 Nama PIC --}}
                        <div class="relative">
                            <input type="text" name="pic_name" value="{{ old('pic_name') }}" required
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                                Nama PIC <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- 4 No HP PIC --}}
                        <div class="relative">
                            <input type="tel" name="pic_phone" value="{{ old('pic_phone') }}" required
                                pattern="^(\+62|62|0)[0-9]{9,12}$" inputmode="numeric"
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" " oninput="maskNumber(this, 13)">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                                No Handphone PIC <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- 5 Email PIC --}}
                        <div class="relative md:col-span-2">
                            <input type="email" name="pic_email" value="{{ old('pic_email') }}" required
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                                Email PIC <span class="text-rose-600">*</span>
                            </label>
                        </div>
                    </div>
                </section>

                <div class="px-6 py-6">
                    <div class="h-px bg-linear-to-r from-transparent via-gray-200 to-transparent"></div>
                </div>

                {{-- ================== ALAMAT ================== --}}
                <section class="px-6">
                    <div class="mb-2">
                        <h2 class="text-lg font-semibold text-gray-900">Alamat PIC</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Alamat PIC --}}
                        <div class="relative md:col-span-2">
                            <input type="text" name="pic_address" value="{{ old('pic_address') }}" required
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                              peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                              peer-focus:top-2 peer-focus:text-xs transition-all">
                                Alamat PIC <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- RT --}}
                        <div class="relative">
                            <input type="text" name="rt" value="{{ old('rt') }}" required maxlength="3"
                                inputmode="numeric"
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" " oninput="digitsOnly(this,3)">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                              peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                              peer-focus:top-2 peer-focus:text-xs transition-all">
                                RT <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- RW --}}
                        <div class="relative">
                            <input type="text" name="rw" value="{{ old('rw') }}" required maxlength="3"
                                inputmode="numeric"
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" " oninput="digitsOnly(this,3)">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                              peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                              peer-focus:top-2 peer-focus:text-xs transition-all">
                                RW <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- Nama Kelurahan --}}
                        <div class="relative">
                            <input type="text" name="kelurahan" value="{{ old('kelurahan') }}" required
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                              peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                              peer-focus:top-2 peer-focus:text-xs transition-all">
                                Nama Kelurahan <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- Kabupaten / Kota --}}
                        <div class="relative">
                            <input type="text" name="kota_kab" value="{{ old('kota_kab') }}" required
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                              peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                              peer-focus:top-2 peer-focus:text-xs transition-all">
                                Kabupaten/Kota <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- Provinsi --}}
                        <div class="relative md:col-span-2">
                            <input type="text" name="provinsi" value="{{ old('provinsi') }}" required
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" ">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                              peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                              peer-focus:top-2 peer-focus:text-xs transition-all">
                                Provinsi <span class="text-rose-600">*</span>
                            </label>
                        </div>

                    </div>
                </section>


                <div class="px-6 py-6">
                    <div class="h-px bg-linear-to-r from-transparent via-gray-200 to-transparent"></div>
                </div>

                {{-- ================== IDENTITAS & UPLOAD ================== --}}
                <section class="px-6 pb-20 md:pb-10">
                    <div class="mb-2">
                        <h2 class="text-lg font-semibold text-gray-900">Identitas</h2>
                    </div>

                    <div class="grid grid-cols-1 gap-5">

                        {{-- BARIS 1 — No KTP --}}
                        <div class="relative">
                            <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" required
                                inputmode="numeric" pattern="^[0-9]{16}$" maxlength="16"
                                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 pt-5 pb-2 bg-white"
                                placeholder=" " oninput="digitsOnly(this,16)">
                            <label
                                class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600
                                peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5
                                peer-focus:top-2 peer-focus:text-xs transition-all">
                                No. KTP PIC (16 digit) <span class="text-rose-600">*</span>
                            </label>
                        </div>

                        {{-- BARIS 2 — Foto PIC --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto PIC (jpg/png, max 2MB) <span
                                    class="text-rose-600">*</span></label>
                            <div class="flex items-center gap-4">
                                <div id="foto-pic-preview"
                                    class="h-20 w-20 rounded-2xl ring-1 ring-gray-200 bg-gray-100 grid place-items-center text-gray-400">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="file" name="foto_pic" id="foto_pic" required accept=".jpg,.jpeg,.png"
                                    class="w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 py-2 bg-white"
                                    onchange="previewImage('foto_pic','foto-pic-preview')">
                            </div>
                        </div>

                        {{-- BARIS 3 — File KTP --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                File upload KTP PIC (jpg/png/pdf, max 2MB) <span class="text-rose-600">*</span>
                            </label>
                            <input type="file" name="file_ktp" id="file_ktp" required accept=".jpg,.jpeg,.png,.pdf"
                                class="w-full rounded-xl border-2 border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-200 px-4 py-2 bg-white"
                                onchange="previewKTP(this)">
                            <div id="ktp-preview" class="mt-2 text-sm text-gray-600"></div>
                        </div>

                    </div>
                </section>


                {{-- ================== TERMS & CONDITIONS ================== --}}
                <section class="px-6 pb-4">
                    <div class="px-6 pb-6">
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }}
                                required class="cm-terms">
                            <span class="cm-checkbox-box"></span>
                            <span class="text-sm text-gray-700">
                                Saya setuju dengan
                                <a href="{{ route('terms.seller') }}" class="text-blue-600 hover:underline">Syarat &amp;
                                    Ketentuan</a>
                                dan
                                <a href="{{ route('privacy.policy') }}" class="text-blue-600 hover:underline">Kebijakan
                                    Privasi</a>.
                            </span>
                        </label>
                    </div>
                </section>


                {{-- Sticky Action (mobile-friendly) --}}
                <div
                    class="fixed md:static inset-x-0 bottom-0 bg-white/95 backdrop-blur border-t md:border-t-0 border-gray-200 p-4 flex items-center justify-between gap-3">
                    <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-shield-alt text-blue-600"></i>
                        <span>Data terenkripsi & tidak dibagikan tanpa izin.</span>
                    </div>
                    <button type="submit"
                        class="w-full md:w-auto inline-flex justify-center items-center gap-2 px-5 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                        <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
                    </button>
                </div>
            </form>
        </div>

        {{-- Custom Confirmation Modal --}}
        <div id="confirmModal"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            style="display: none;">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
                <div class="text-center mb-6">
                    <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-question-circle text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Konfirmasi Pendaftaran</h3>
                    <p class="text-gray-600">
                        Apakah semua data yang Anda isi sudah benar?
                    </p>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="hideConfirmModal()"
                        class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="button" onclick="confirmSubmit()"
                        class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors shadow-md hover:shadow-lg">
                        <i class="fas fa-check mr-2"></i>Ya, Kirim
                    </button>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        @include('components.footer')

    @endsection

    @push('scripts')
        <script>
            /* ---------- UX Helpers ---------- */
            function togglePwd(id) {
                const f = document.getElementById(id),
                    ic = document.getElementById(id + '-icon');
                if (!f) return;
                f.type = f.type === 'password' ? 'text' : 'password';
                if (ic) ic.className = 'fas ' + (f.type === 'text' ? 'fa-eye-slash' : 'fa-eye');
            }

            function maskNumber(el, maxLen) {
                el.value = el.value.replace(/[^0-9+]/g, '').slice(0, maxLen || 15);
            }

            function digitsOnly(el, maxLen) {
                el.value = el.value.replace(/\D/g, '').slice(0, maxLen);
            }

            function countChars(inputId, counterId, max) {
                const v = document.getElementById(inputId)?.value ?? '';
                const c = document.getElementById(counterId);
                if (c) c.textContent = `${v.length}/${max}`;
            }

            function checkStrength() {
                const v = document.getElementById('password')?.value ?? '';
                const bars = ['p1', 'p2', 'p3', 'p4'].map(i => document.getElementById(i));
                const txt = document.getElementById('ptext');
                bars.forEach(b => b && (b.className = 'h-1 flex-1 bg-gray-200 rounded'));
                let s = 0;
                if (v.length >= 8) s++;
                if (/[a-z]/.test(v)) s++;
                if (/[A-Z]/.test(v)) s++;
                if (/[0-9]/.test(v)) s++;
                for (let i = 0; i < s && i < bars.length; i++) {
                    if (bars[i]) bars[i].className = 'h-1 flex-1 ' + ['bg-gray-200', 'bg-rose-500', 'bg-amber-500',
                        'bg-blue-500', 'bg-emerald-500'
                    ][Math.min(s, 4)] + ' rounded';
                }
                if (txt) {
                    txt.className = 'text-[11px] ' + (['text-gray-500', 'text-rose-600', 'text-amber-600', 'text-blue-600',
                        'text-emerald-600'
                    ][s] || 'text-gray-500');
                    txt.textContent = (['', 'Lemah', 'Cukup', 'Baik', 'Kuat'][s] || '');
                }
            }
            /* ---------- File Previews ---------- */
            function within2MB(f) {
                return f.size <= 2 * 1024 * 1024;
            }

            function previewImage(inputId, previewId) {
                const input = document.getElementById(inputId),
                    prev = document.getElementById(previewId);
                if (!input || !prev) return;
                prev.innerHTML = '';
                const f = input.files?.[0];
                if (!f) return;
                if (!within2MB(f)) {
                    prev.innerHTML = '<span class="text-rose-600 text-sm">Ukuran file > 2MB</span>';
                    input.value = '';
                    return;
                }
                if (!['image/jpeg', 'image/png', 'image/jpg'].includes(f.type)) {
                    prev.textContent = 'Format harus JPG/PNG';
                    input.value = '';
                    return;
                }
                const img = document.createElement('img');
                img.src = URL.createObjectURL(f);
                img.alt = 'Foto PIC';
                img.className = 'h-20 w-20 rounded-2xl object-cover ring-1 ring-gray-200';
                prev.appendChild(img);
            }

            function previewKTP(input) {
                const prev = document.getElementById('ktp-preview');
                prev.innerHTML = '';
                const f = input.files?.[0];
                if (!f) return;
                if (!within2MB(f)) {
                    prev.innerHTML = '<span class="text-rose-600 text-sm">Ukuran file > 2MB</span>';
                    input.value = '';
                    return;
                }
                if (['image/jpeg', 'image/png', 'image/jpg'].includes(f.type)) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(f);
                    img.className = 'max-h-40 rounded-xl ring-1 ring-gray-200';
                    img.alt = 'KTP preview';
                    prev.appendChild(img);
                } else if (f.type === 'application/pdf') {
                    const a = document.createElement('a');
                    a.href = URL.createObjectURL(f);
                    a.target = '_blank';
                    a.className = 'text-indigo-600 hover:underline text-sm';
                    a.textContent = 'Buka PDF terunggah';
                    prev.appendChild(a);
                } else {
                    prev.textContent = 'File terpilih: ' + f.name;
                }
            }

            /* ---------- Form Submission Confirmation ---------- */
            let formToSubmit = null;

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('sellerForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Cek validasi HTML5 dulu
                        if (!form.checkValidity()) {
                            // Jika ada field yang belum valid, biarkan browser show error message
                            return true;
                        }

                        // Jika semua field valid, prevent submit dan tampilkan modal konfirmasi
                        e.preventDefault();
                        formToSubmit = form;
                        showConfirmModal();
                    });
                }
            });

            function showConfirmModal() {
                document.getElementById('confirmModal').style.display = 'flex';
            }

            function hideConfirmModal() {
                document.getElementById('confirmModal').style.display = 'none';
                formToSubmit = null;
            }

            function confirmSubmit() {
                if (formToSubmit) {
                    // Remove event listener to prevent loop
                    const form = formToSubmit;
                    formToSubmit = null;
                    hideConfirmModal();

                    // Submit form manually
                    form.removeEventListener('submit', arguments.callee);
                    form.submit();
                }
            }
        </script>
    @endpush

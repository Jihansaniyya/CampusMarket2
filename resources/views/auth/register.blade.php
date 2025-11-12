@extends('layouts.auth')

@section('title','Registrasi Penjual (Toko)')
@section('body-class','min-h-screen bg-gradient-to-b from-gray-50 to-white')

@section('content')
<div class="min-h-screen">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header Halaman --}}
    <header class="mb-6">
      <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
        <ol class="flex items-center gap-2">
          <li><a href="/" class="hover:text-gray-700">Home</a></li>
          <li aria-hidden="true" class="text-gray-300">/</li>
          <li class="text-gray-700 font-medium">Pendaftaran Toko</li>
        </ol>
      </nav>

      <div class="flex items-start justify-between gap-3">
        <div>
          <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">
            Pendaftaran Toko
          </h1>
          <p class="mt-2 text-gray-600">
            Lengkapi data di bawah ini. Setelah dikirim akan dilakukan
            <span class="font-semibold">verifikasi administrasi</span>.
          </p>
        </div>
      </div>
    </header>

    {{-- Card --}}
    <div class="relative bg-white/90 backdrop-blur rounded-3xl shadow-xl ring-1 ring-black/5 overflow-hidden">
      <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-rose-500"></div>

      {{-- Alerts --}}
      @if(session('success'))
        <div class="mx-6 mt-6 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="mx-6 mt-6 rounded-xl border border-rose-200 bg-rose-50">
          <div class="px-4 py-3 text-rose-800 font-semibold">Periksa kembali input kamu:</div>
          <ul class="px-6 pb-3 list-disc text-sm text-rose-700 space-y-1">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" novalidate id="sellerForm">
        @csrf

        {{-- ================== AKUN ================== --}}
        <section class="px-6 pt-8">
          <div class="mb-2">
            <h2 class="text-lg font-semibold text-gray-900">Data Akun</h2>
          </div>
          <p class="text-sm text-gray-500 mb-4">Data ini digunakan untuk login ke aplikasi.</p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Nama --}}
            <div class="relative">
              <input autofocus type="text" name="name" value="{{ old('name') }}" required minlength="3" autocomplete="name"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                placeholder=" ">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                Nama Lengkap <span class="text-rose-600">*</span>
              </label>
              @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- HP --}}
            <div class="relative">
              <input type="tel" name="phone" value="{{ old('phone') }}" required
                pattern="^(\+62|62|0)[0-9]{9,12}$" inputmode="numeric" autocomplete="tel"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                placeholder=" " oninput="maskNumber(this, 13)">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                No. Handphone <span class="text-rose-600">*</span>
              </label>
              <p class="text-[11px] text-gray-400 mt-1">Format: 08xxxxxxxxxx</p>
              @error('phone') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="relative">
              <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                placeholder=" ">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                Email <span class="text-rose-600">*</span>
              </label>
              @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div class="relative">
              <input type="password" id="password" name="password" required minlength="8" onkeyup="checkStrength()"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 pr-11 bg-white"
                placeholder=" ">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                Password <span class="text-rose-600">*</span>
              </label>
              <button type="button" onclick="togglePwd('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" aria-label="toggle password"><i id="password-icon" class="fas fa-eye"></i></button>
              <div class="mt-2 flex gap-1" aria-hidden="true">
                <div id="p1" class="h-1 flex-1 bg-gray-200 rounded"></div>
                <div id="p2" class="h-1 flex-1 bg-gray-200 rounded"></div>
                <div id="p3" class="h-1 flex-1 bg-gray-200 rounded"></div>
                <div id="p4" class="h-1 flex-1 bg-gray-200 rounded"></div>
              </div>
              <p id="ptext" class="text-[11px] text-gray-500">Gunakan huruf besar, kecil, dan angka.</p>
              @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirm --}}
            <div class="relative md:col-span-2">
              <input type="password" id="password_confirmation" name="password_confirmation" required
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 pr-11 bg-white"
                placeholder=" ">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                Konfirmasi Password <span class="text-rose-600">*</span>
              </label>
              <button type="button" onclick="togglePwd('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" aria-label="toggle confirm"><i id="password_confirmation-icon" class="fas fa-eye"></i></button>
            </div>
          </div>
        </section>

        {{-- Divider --}}
        <div class="px-6 py-6"><div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div></div>

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
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                Nama Toko <span class="text-rose-600">*</span>
              </label>
              @error('store_name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 2 Deskripsi singkat --}}
            <div class="relative">
              <input type="text" name="store_description" id="store_description" value="{{ old('store_description') }}" required maxlength="120"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                placeholder=" " oninput="countChars('store_description','descCounter',120)">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                Deskripsi Singkat <span class="text-rose-600">*</span>
              </label>
              <div class="flex justify-end"><span id="descCounter" class="text-[11px] text-gray-400 mt-1">0/120</span></div>
              @error('store_description') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>
        </section>

        <div class="px-6 py-6"><div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div></div>

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
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                Nama PIC <span class="text-rose-600">*</span>
              </label>
            </div>

            {{-- 4 No HP PIC --}}
            <div class="relative">
              <input type="tel" name="pic_phone" value="{{ old('pic_phone') }}" required
                pattern="^(\+62|62|0)[0-9]{9,12}$" inputmode="numeric"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                placeholder=" " oninput="maskNumber(this, 13)">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                No Handphone PIC <span class="text-rose-600">*</span>
              </label>
            </div>

            {{-- 5 Email PIC --}}
            <div class="relative md:col-span-2">
              <input type="email" name="pic_email" value="{{ old('pic_email') }}" required
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                placeholder=" ">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                email PIC <span class="text-rose-600">*</span>
              </label>
            </div>
          </div>
        </section>

        <div class="px-6 py-6"><div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div></div>

        {{-- ================== ALAMAT ================== --}}
        <section class="px-6">
          <div class="mb-2">
            <h2 class="text-lg font-semibold text-gray-900">Alamat PIC</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- 6 Alamat --}}
            <div class="relative md:col-span-2">
              <input type="text" name="pic_address" value="{{ old('pic_address') }}"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                placeholder=" ">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">
                Alamat PIC
              </label>
            </div>
            {{-- 7–11 --}}
            <div class="relative">
              <input type="text" name="rt" value="{{ old('rt') }}" maxlength="3" inputmode="numeric"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                placeholder=" " oninput="digitsOnly(this,3)">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">RT</label>
            </div>
            <div class="relative">
              <input type="text" name="rw" value="{{ old('rw') }}" maxlength="3" inputmode="numeric"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white"
                placeholder=" " oninput="digitsOnly(this,3)">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">RW</label>
            </div>
            <div class="relative">
              <input type="text" name="kelurahan" value="{{ old('kelurahan') }}"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white" placeholder=" ">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">Nama kelurahan</label>
            </div>
            <div class="relative">
              <input type="text" name="kota_kab" value="{{ old('kota_kab') }}"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white" placeholder=" ">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">Kabupaten/Kota</label>
            </div>
            <div class="relative">
              <input type="text" name="provinsi" value="{{ old('provinsi') }}"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white" placeholder=" ">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">Propinsi</label>
            </div>
          </div>
        </section>

        <div class="px-6 py-6"><div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div></div>

        {{-- ================== IDENTITAS & UPLOAD ================== --}}
        <section class="px-6 pb-24 md:pb-10">
          <div class="mb-2">
            <h2 class="text-lg font-semibold text-gray-900">Identitas & Dokumen</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- 12 No KTP --}}
            <div class="relative">
              <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" inputmode="numeric" pattern="^[0-9]{16}$" maxlength="16"
                class="peer w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 pt-5 pb-2 bg-white" placeholder=" "
                oninput="digitsOnly(this,16)">
              <label class="pointer-events-none absolute left-4 top-2 text-xs text-gray-600 peer-placeholder-shown:text-sm peer-placeholder-shown:top-3.5 peer-focus:top-2 peer-focus:text-xs transition-all">No. KTP PIC (16 digit)</label>
            </div>

            {{-- 13 Foto PIC --}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Foto PIC (jpg/png, max 2MB)</label>
              <div class="flex items-center gap-4">
                <div id="foto-pic-preview" class="h-20 w-20 rounded-2xl ring-1 ring-gray-200 bg-gray-100 grid place-items-center text-gray-400">
                  <i class="fas fa-user"></i>
                </div>
                <input type="file" name="foto_pic" id="foto_pic" accept=".jpg,.jpeg,.png"
                       class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 py-2 bg-white"
                       onchange="previewImage('foto_pic','foto-pic-preview')">
              </div>
              @error('foto_pic') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 14 File KTP --}}
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">File upload KTP PIC (jpg/png/pdf, max 2MB) <span class="text-rose-600">*</span></label>
              <input type="file" name="file_ktp" id="file_ktp" accept=".jpg,.jpeg,.png,.pdf" required
                     class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 py-2 bg-white"
                     onchange="previewKTP(this)">
              <div id="ktp-preview" class="mt-2 text-sm text-gray-600"></div>
              @error('file_ktp') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Terms --}}
            <div class="md:col-span-2 mt-2">
              <label class="flex items-start gap-3">
                <input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required
                       class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <span class="text-sm text-gray-600">Saya setuju dengan <a href="#" class="text-indigo-600 hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="text-indigo-600 hover:underline">Kebijakan Privasi</a>.</span>
              </label>
            </div>
          </div>
        </section>

        {{-- Sticky Action (mobile-friendly) --}}
        <div class="fixed md:static inset-x-0 bottom-0 bg-white/95 backdrop-blur border-t md:border-t-0 border-gray-200 p-4 flex items-center justify-between gap-3">
          <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
            <i class="fas fa-shield-alt text-indigo-600"></i>
            <span>Data terenkripsi & tidak dibagikan tanpa izin.</span>
          </div>
          <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-indigo-600 to-fuchsia-600 text-white font-semibold shadow hover:shadow-lg hover:scale-[1.01] transition">
            <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
          </button>
        </div>
      </form>
    </div>

    {{-- Footer help --}}
    <p class="mt-4 text-center text-sm text-gray-500">Butuh bantuan? <a href="#" class="text-indigo-600 hover:underline">Hubungi admin</a>.</p>
  </div>
</div>
@endsection

@push('scripts')
<script>
/* ---------- UX Helpers ---------- */
function togglePwd(id){
  const f = document.getElementById(id), ic = document.getElementById(id+'-icon');
  if(!f) return; f.type = f.type === 'password' ? 'text' : 'password';
  if(ic) ic.className = 'fas ' + (f.type === 'text' ? 'fa-eye-slash' : 'fa-eye');
}
function maskNumber(el, maxLen){ el.value = el.value.replace(/[^0-9+]/g,'').slice(0, maxLen || 15); }
function digitsOnly(el, maxLen){ el.value = el.value.replace(/\D/g,'').slice(0, maxLen); }
function countChars(inputId, counterId, max){ const v = document.getElementById(inputId)?.value ?? ''; const c = document.getElementById(counterId); if(c) c.textContent = `${v.length}/${max}`; }
function checkStrength(){
  const v = document.getElementById('password')?.value ?? '';
  const bars = ['p1','p2','p3','p4'].map(i=>document.getElementById(i));
  const txt = document.getElementById('ptext');
  bars.forEach(b=>b&&(b.className='h-1 flex-1 bg-gray-200 rounded'));
  let s = 0; if(v.length>=8) s++; if(/[a-z]/.test(v)) s++; if(/[A-Z]/.test(v)) s++; if(/[0-9]/.test(v)) s++;
  for(let i=0;i<s&&i<bars.length;i++){ if(bars[i]) bars[i].className = 'h-1 flex-1 ' + ['bg-gray-200','bg-rose-500','bg-amber-500','bg-blue-500','bg-emerald-500'][Math.min(s,4)] + ' rounded'; }
  if(txt){ txt.className='text-[11px] '+(['text-gray-500','text-rose-600','text-amber-600','text-blue-600','text-emerald-600'][s]||'text-gray-500'); txt.textContent=(['','Lemah','Cukup','Baik','Kuat'][s]||'');}
}
/* ---------- File Previews ---------- */
function within2MB(f){return f.size <= 2*1024*1024;}
function previewImage(inputId, previewId){
  const input=document.getElementById(inputId), prev=document.getElementById(previewId); if(!input||!prev) return;
  prev.innerHTML=''; const f=input.files?.[0]; if(!f) return;
  if(!within2MB(f)){ prev.innerHTML='<span class="text-rose-600 text-sm">Ukuran file > 2MB</span>'; input.value=''; return; }
  if(!['image/jpeg','image/png','image/jpg'].includes(f.type)){ prev.textContent='Format harus JPG/PNG'; input.value=''; return; }
  const img=document.createElement('img'); img.src=URL.createObjectURL(f); img.alt='Foto PIC'; img.className='h-20 w-20 rounded-2xl object-cover ring-1 ring-gray-200';
  prev.appendChild(img);
}
function previewKTP(input){
  const prev=document.getElementById('ktp-preview'); prev.innerHTML=''; const f=input.files?.[0]; if(!f) return;
  if(!within2MB(f)){ prev.innerHTML='<span class="text-rose-600 text-sm">Ukuran file > 2MB</span>'; input.value=''; return; }
  if(['image/jpeg','image/png','image/jpg'].includes(f.type)){
    const img=document.createElement('img'); img.src=URL.createObjectURL(f); img.className='max-h-40 rounded-xl ring-1 ring-gray-200'; img.alt='KTP preview';
    prev.appendChild(img);
  } else if(f.type==='application/pdf'){
    const a=document.createElement('a'); a.href=URL.createObjectURL(f); a.target='_blank'; a.className='text-indigo-600 hover:underline text-sm'; a.textContent='Buka PDF terunggah'; prev.appendChild(a);
  } else { prev.textContent='File terpilih: '+f.name; }
}
</script>
@endpush

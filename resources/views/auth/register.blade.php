@extends('layouts.auth')

@section('title', 'Register')
@section('body-class', 'min-h-screen bg-gradient-to-br from-blue-50 to-purple-50')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4" x-data="{ role: '{{ old('role','buyer') }}' }">
    <div class="max-w-5xl w-full bg-white/90 backdrop-blur-lg shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row">

        {{-- Left Side --}}
        <div class="md:w-1/2 bg-gradient-to-br from-blue-600 to-purple-600 p-8 flex flex-col justify-center text-white">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-4">🛒 CampusMarket</h1>
                <p class="text-xl mb-6">Your Campus Marketplace</p>
                <div class="space-y-4 text-left">
                    <div class="flex items-center gap-3"><i class="fas fa-check-circle text-2xl"></i><span>Buy and Sell Campus Products</span></div>
                    <div class="flex items-center gap-3"><i class="fas fa-check-circle text-2xl"></i><span>Connect with Students</span></div>
                    <div class="flex items-center gap-3"><i class="fas fa-check-circle text-2xl"></i><span>Safe and Trusted Platform</span></div>
                </div>
            </div>
        </div>

        {{-- Right Side (Form) --}}
        <div class="md:w-1/2 p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h2>
            <p class="text-gray-600 mb-6">Join CampusMarket today!</p>

        

            <form action="{{ route('register') }}" method="POST" id="registerForm" enctype="multipart/form-data">
                @csrf

                {{-- Full Name --}}
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2 text-sm">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Enter your full name" required minlength="3">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2 text-sm">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="your@email.com" required>
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2 text-sm">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="081234567890" required pattern="^(\+62|62|0)[0-9]{9,12}$">
                    <p class="text-xs text-gray-500 mt-1">Format: 081234567890</p>
                    @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2 text-sm">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               placeholder="Create a strong password" required minlength="8" onkeyup="checkPasswordStrength()">
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="mt-2">
                        <div class="flex gap-1 mb-1">
                            <div id="strength-1" class="h-1 flex-1 bg-gray-200 rounded"></div>
                            <div id="strength-2" class="h-1 flex-1 bg-gray-200 rounded"></div>
                            <div id="strength-3" class="h-1 flex-1 bg-gray-200 rounded"></div>
                            <div id="strength-4" class="h-1 flex-1 bg-gray-200 rounded"></div>
                        </div>
                        <p id="strength-text" class="text-xs text-gray-500">Minimum 8 characters, include uppercase, lowercase, and number</p>
                    </div>
                    @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2 text-sm">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               placeholder="Re-enter your password" required>
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                            <i id="password_confirmation-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Register as</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="border-2 border-gray-300 rounded-lg p-4 hover:border-blue-500 hover:bg-blue-50 cursor-pointer transition-all">
                            <input type="radio" name="role" value="buyer" class="sr-only peer" x-model="role" {{ old('role','buyer') === 'buyer' ? 'checked' : '' }}>
                            <div class="text-center peer-checked:text-blue-600">
                                <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                                <p class="font-semibold">Buyer</p>
                                <p class="text-xs text-gray-500">I want to buy</p>
                            </div>
                        </label>
                        <label class="border-2 border-gray-300 rounded-lg p-4 hover:border-blue-500 hover:bg-blue-50 cursor-pointer transition-all">
                            <input type="radio" name="role" value="seller" class="sr-only peer" x-model="role" {{ old('role') === 'seller' ? 'checked' : '' }}>
                            <div class="text-center peer-checked:text-blue-600">
                                <i class="fas fa-store text-3xl mb-2"></i>
                                <p class="font-semibold">Seller</p>
                                <p class="text-xs text-gray-500">I want to sell</p>
                            </div>
                        </label>
                    </div>
                    @error('role') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Seller-Only Fields (sesuai elemen data di SRS) --}}
                <div x-show="role === 'seller'" x-cloak class="mt-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- 1 Nama Toko --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Nama Toko</label>
                            <input type="text" name="store_name" value="{{ old('store_name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" {{ old('role')==='seller' ? 'required' : '' }}>
                            @error('store_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- 2 Deskripsi singkat --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Deskripsi Singkat</label>
                            <input type="text" name="store_description" value="{{ old('store_description') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            @error('store_description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- 3 Nama PIC --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Nama PIC</label>
                            <input type="text" name="pic_name" value="{{ old('pic_name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            @error('pic_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- 4 No HP PIC --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">No HP PIC</label>
                            <input type="tel" name="pic_phone" value="{{ old('pic_phone') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" pattern="^(\+62|62|0)[0-9]{9,12}$">
                            @error('pic_phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- 5 Alamat (nama jalan) PIC --}}
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Alamat (Nama Jalan) PIC</label>
                            <input type="text" name="pic_address" value="{{ old('pic_address') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            @error('pic_address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- 6-12 RT/RW/Kel/Keck/Kab/Prov/Kode Pos --}}
                        <div><label class="block text-gray-700 font-semibold mb-2 text-sm">RT</label><input type="text" name="rt" value="{{ old('rt') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg"></div>
                        <div><label class="block text-gray-700 font-semibold mb-2 text-sm">RW</label><input type="text" name="rw" value="{{ old('rw') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg"></div>
                        <div><label class="block text-gray-700 font-semibold mb-2 text-sm">Kelurahan</label><input type="text" name="kelurahan" value="{{ old('kelurahan') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg"></div>
                        <div><label class="block text-gray-700 font-semibold mb-2 text-sm">Kecamatan</label><input type="text" name="kecamatan" value="{{ old('kecamatan') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg"></div>
                        <div><label class="block text-gray-700 font-semibold mb-2 text-sm">Kabupaten/Kota</label><input type="text" name="kota_kab" value="{{ old('kota_kab') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg"></div>
                        <div><label class="block text-gray-700 font-semibold mb-2 text-sm">Provinsi</label><input type="text" name="provinsi" value="{{ old('provinsi') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg"></div>
                        <div><label class="block text-gray-700 font-semibold mb-2 text-sm">Kode Pos</label><input type="text" name="kode_pos" value="{{ old('kode_pos') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg"></div>
                        {{-- 13 No KTP --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">No KTP (16 digit)</label>
                            <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            @error('no_ktp') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- 14 File KTP --}}
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2 text-sm">Upload KTP (jpg/png/pdf, max 2MB)</label>
                            <input type="file" name="file_ktp" accept=".jpg,.jpeg,.png,.pdf" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white">
                            @error('file_ktp') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Terms & Conditions --}}
                <div class="mb-6 mt-4">
                    <label class="flex items-start">
                        <input type="checkbox" name="terms" value="1" {{ old('terms') ? 'checked' : '' }}
                               class="w-4 h-4 mt-1 text-blue-600 border-gray-300 rounded focus:ring-blue-500" required>
                        <span class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-blue-600 hover:underline">Terms & Conditions</a> and
                            <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                        </span>
                    </label>
                    @error('terms') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Submit (fix duplikasi tombol) --}}
                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg hover:scale-105 transform transition-all shadow-lg font-semibold">
                    Create Account
                </button>
            </form>

            {{-- Login link --}}
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    if (field.type === 'password') { field.type = 'text'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
    else { field.type = 'password'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
}
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const bars = [ 'strength-1','strength-2','strength-3','strength-4' ].map(id => document.getElementById(id));
    const text = document.getElementById('strength-text');
    bars.forEach(el => el.className = 'h-1 flex-1 bg-gray-200 rounded');
    let s = 0;
    if (password.length >= 8) s++;
    if (/[a-z]/.test(password)) s++;
    if (/[A-Z]/.test(password)) s++;
    if (/[0-9]/.test(password)) s++;
    const colors = ['bg-gray-200','bg-red-500','bg-yellow-500','bg-blue-500','bg-green-500'];
    const texts  = ['','Weak','Fair','Good','Strong'];
    for (let i=0;i<s;i++) bars[i].className = 'h-1 flex-1 '+colors[s]+' rounded';
    text.className = 'text-xs '+(['text-gray-500','text-red-500','text-yellow-500','text-blue-500','text-green-500'][s]);
    text.textContent = texts[s] || 'Enter password';
}
</script>
@endpush
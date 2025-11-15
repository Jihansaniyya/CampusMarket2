@extends('layouts.admin')

@section('title', 'Detail Penjual - ' . $seller->store_name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('admin.sellers.approval.index') }}"
                class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Penjual
            </a>
        </div>

        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $seller->store_name }}</h1>
                    <div class="flex items-center gap-3">
                        @if ($seller->approval_status === 'pending')
                            <span class="px-4 py-2 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">
                                <i class="fas fa-clock mr-1"></i>Menunggu Persetujuan
                            </span>
                        @elseif($seller->approval_status === 'approved')
                            <span class="px-4 py-2 bg-emerald-100 text-emerald-800 text-sm font-medium rounded-full">
                                <i class="fas fa-check mr-1"></i>Disetujui
                            </span>
                        @else
                            <span class="px-4 py-2 bg-rose-100 text-rose-800 text-sm font-medium rounded-full">
                                <i class="fas fa-times mr-1"></i>Ditolak
                            </span>
                        @endif

                        @if ($seller->hasVerifiedEmail())
                            <span class="px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                <i class="fas fa-check-circle mr-1"></i>Email Terverifikasi
                            </span>
                        @endif
                    </div>
                </div>

                @if ($seller->approval_status === 'pending')
                    <div class="flex gap-2">
                        <form action="{{ route('admin.sellers.approval.approve', $seller->id) }}" method="POST"
                            class="inline">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran {{ $seller->store_name }}?')"
                                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors inline-flex items-center">
                                <i class="fas fa-check mr-2"></i>Setujui
                            </button>
                        </form>

                        <button onclick="showRejectModal()"
                            class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-lg transition-colors inline-flex items-center">
                            <i class="fas fa-times mr-2"></i>Tolak
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Information Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Informasi Toko --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-store text-blue-600 mr-3"></i>
                    Informasi Toko
                </h2>

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Toko</label>
                        <p class="text-gray-900 font-medium">{{ $seller->store_name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Deskripsi Toko</label>
                        <p class="text-gray-900">{{ $seller->store_description ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal Pendaftaran</label>
                        <p class="text-gray-900">{{ $seller->created_at->format('d M Y, H:i') }}
                            ({{ $seller->created_at->diffForHumans() }})</p>
                    </div>

                    @if ($seller->approved_at)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal Disetujui</label>
                            <p class="text-gray-900">{{ $seller->approved_at->format('d M Y, H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Informasi Akun --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-blue-600 mr-3"></i>
                    Informasi Akun
                </h2>

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                        <p class="text-gray-900 font-medium">{{ $seller->name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-gray-900">{{ $seller->email }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">No. Telepon</label>
                        <p class="text-gray-900">{{ $seller->phone ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Status Email</label>
                        <p class="text-gray-900">
                            @if ($seller->hasVerifiedEmail())
                                <span class="text-emerald-600"><i class="fas fa-check-circle mr-1"></i>Terverifikasi</span>
                            @else
                                <span class="text-amber-600"><i class="fas fa-clock mr-1"></i>Belum Diverifikasi</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Informasi PIC --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-tie text-blue-600 mr-3"></i>
                    Penanggung Jawab (PIC)
                </h2>

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama PIC</label>
                        <p class="text-gray-900 font-medium">{{ $seller->pic_name ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Email PIC</label>
                        <p class="text-gray-900">{{ $seller->pic_email ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">No. Telepon PIC</label>
                        <p class="text-gray-900">{{ $seller->pic_phone ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Alamat PIC</label>
                        <p class="text-gray-900">{{ $seller->pic_address ?: '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>
                    Alamat Lengkap
                </h2>

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">RT / RW</label>
                        <p class="text-gray-900">{{ $seller->rt ?: '-' }} / {{ $seller->rw ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Kelurahan</label>
                        <p class="text-gray-900">{{ $seller->kelurahan ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Kota/Kabupaten</label>
                        <p class="text-gray-900">{{ $seller->kota_kab ?: '-' }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Provinsi</label>
                        <p class="text-gray-900">{{ $seller->provinsi ?: '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Identitas --}}
            <div class="bg-white rounded-xl shadow-md p-6 lg:col-span-2">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-id-card text-blue-600 mr-3"></i>
                    Identitas & Dokumen
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">No. KTP</label>
                        <p class="text-gray-900 font-medium mb-3">{{ $seller->no_ktp ?: '-' }}</p>

                        @if ($seller->file_ktp)
                            <label class="text-sm font-medium text-gray-500 block mb-2">Foto KTP</label>
                            @if (Str::endsWith($seller->file_ktp, ['.jpg', '.jpeg', '.png']))
                                <img src="{{ Storage::url($seller->file_ktp) }}" alt="KTP {{ $seller->store_name }}"
                                    class="max-w-full h-auto rounded-lg border border-gray-200 shadow-sm">
                            @else
                                <a href="{{ Storage::url($seller->file_ktp) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-file-pdf mr-2"></i>Lihat Dokumen KTP
                                </a>
                            @endif
                        @else
                            <p class="text-gray-400 italic">Tidak ada file KTP</p>
                        @endif
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500 block mb-2">Foto PIC</label>
                        @if ($seller->avatar)
                            <img src="{{ Storage::url($seller->avatar) }}" alt="Foto {{ $seller->pic_name }}"
                                class="w-48 h-48 object-cover rounded-xl border border-gray-200 shadow-sm">
                        @else
                            <div class="w-48 h-48 bg-gray-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user text-gray-300 text-6xl"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Rejection Reason (if rejected) --}}
            @if ($seller->approval_status === 'rejected' && $seller->rejection_reason)
                <div class="bg-rose-50 border border-rose-200 rounded-xl p-6 lg:col-span-2">
                    <h2 class="text-xl font-bold text-rose-900 mb-3 flex items-center">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        Alasan Penolakan
                    </h2>
                    <p class="text-rose-800">{{ $seller->rejection_reason }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Reject Modal --}}
    @if ($seller->approval_status === 'pending')
        <div id="rejectModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 p-4" style="display: none;">
            <div class="flex items-center justify-center min-h-full">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Tolak Pendaftaran</h3>
                        <button onclick="hideRejectModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.sellers.approval.reject', $seller->id) }}" method="POST">
                        @csrf
                        <p class="text-gray-600 mb-4">
                            Anda akan menolak pendaftaran toko <strong>{{ $seller->store_name }}</strong>.
                            Silakan berikan alasan penolakan:
                        </p>

                        <textarea name="rejection_reason" rows="4" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 resize-none"
                            placeholder="Contoh: Dokumen KTP tidak jelas, informasi toko tidak lengkap, dll."></textarea>

                        <div class="flex gap-3 mt-6">
                            <button type="button" onclick="hideRejectModal()"
                                class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-xl transition-colors">
                                <i class="fas fa-times mr-2"></i>Tolak Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                function showRejectModal() {
                    document.getElementById('rejectModal').style.display = 'block';
                }

                function hideRejectModal() {
                    document.getElementById('rejectModal').style.display = 'none';
                }
            </script>
        @endpush
    @endif
@endsection

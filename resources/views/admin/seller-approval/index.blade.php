@extends('layouts.admin')

@section('title', 'Persetujuan Penjual')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Persetujuan Pendaftaran Penjual</h1>
            <p class="text-gray-600 mt-2">Kelola pendaftaran toko yang masuk ke sistem CampusMarket</p>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl mb-6 flex items-start gap-3">
                <i class="fas fa-check-circle text-emerald-600 text-xl mt-0.5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Tabs --}}
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex gap-4" aria-label="Tabs">
                    <button onclick="switchTab('pending')" id="tab-pending"
                        class="tab-btn active whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm transition-colors">
                        <i class="fas fa-clock mr-2"></i>
                        Menunggu ({{ $pendingSellers->count() }})
                    </button>
                    <button onclick="switchTab('approved')" id="tab-approved"
                        class="tab-btn whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm transition-colors">
                        <i class="fas fa-check mr-2"></i>
                        Disetujui ({{ $approvedSellers->count() }})
                    </button>
                    <button onclick="switchTab('rejected')" id="tab-rejected"
                        class="tab-btn whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Ditolak ({{ $rejectedSellers->count() }})
                    </button>
                </nav>
            </div>
        </div>

        {{-- Pending Sellers --}}
        <div id="content-pending" class="tab-content">
            @if ($pendingSellers->isEmpty())
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Tidak ada pendaftaran yang menunggu persetujuan</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach ($pendingSellers as $seller)
                        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-bold text-gray-900">{{ $seller->store_name }}</h3>
                                        <span
                                            class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-medium rounded-full">
                                            Menunggu
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mb-3">{{ Str::limit($seller->store_description, 150) }}</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-user text-gray-400"></i>
                                            <span><strong>PIC:</strong> {{ $seller->pic_name }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                            <span>{{ $seller->email }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-phone text-gray-400"></i>
                                            <span>{{ $seller->pic_phone }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                            <span>{{ $seller->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('admin.sellers.approval.show', $seller->id) }}"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors inline-flex items-center justify-center">
                                        <i class="fas fa-eye mr-2"></i>Detail
                                    </a>

                                    <form action="{{ route('admin.sellers.approval.approve', $seller->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran {{ $seller->store_name }}?')"
                                            class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors inline-flex items-center justify-center">
                                            <i class="fas fa-check mr-2"></i>Setujui
                                        </button>
                                    </form>

                                    <button onclick="showRejectModal({{ $seller->id }}, '{{ $seller->store_name }}')"
                                        class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-lg transition-colors inline-flex items-center justify-center">
                                        <i class="fas fa-times mr-2"></i>Tolak
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Approved Sellers --}}
        <div id="content-approved" class="tab-content hidden">
            @if ($approvedSellers->isEmpty())
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada penjual yang disetujui</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach ($approvedSellers as $seller)
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-bold text-gray-900">{{ $seller->store_name }}</h3>
                                        <span
                                            class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded-full">
                                            <i class="fas fa-check mr-1"></i>Disetujui
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mb-3">{{ Str::limit($seller->store_description, 150) }}</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-600">
                                        <div><strong>Email:</strong> {{ $seller->email }}</div>
                                        <div><strong>Disetujui:</strong>
                                            {{ $seller->approved_at ? $seller->approved_at->diffForHumans() : '-' }}</div>
                                    </div>
                                </div>

                                <a href="{{ route('admin.sellers.approval.show', $seller->id) }}"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors inline-flex items-center">
                                    <i class="fas fa-eye mr-2"></i>Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Rejected Sellers --}}
        <div id="content-rejected" class="tab-content hidden">
            @if ($rejectedSellers->isEmpty())
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada penjual yang ditolak</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach ($rejectedSellers as $seller)
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-xl font-bold text-gray-900">{{ $seller->store_name }}</h3>
                                        <span class="px-3 py-1 bg-rose-100 text-rose-800 text-xs font-medium rounded-full">
                                            <i class="fas fa-times mr-1"></i>Ditolak
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mb-3">{{ Str::limit($seller->store_description, 150) }}</p>

                                    <div class="bg-rose-50 border border-rose-200 rounded-lg p-3 mb-3">
                                        <p class="text-sm text-rose-900">
                                            <strong>Alasan Penolakan:</strong> {{ $seller->rejection_reason }}
                                        </p>
                                    </div>

                                    <div class="text-sm text-gray-600">
                                        <strong>Email:</strong> {{ $seller->email }}
                                    </div>
                                </div>

                                <a href="{{ route('admin.sellers.approval.show', $seller->id) }}"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors inline-flex items-center">
                                    <i class="fas fa-eye mr-2"></i>Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Tolak Pendaftaran</h3>
                <button onclick="hideRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="rejectForm" method="POST">
                @csrf
                <p class="text-gray-600 mb-4">
                    Anda akan menolak pendaftaran toko <strong id="rejectStoreName"></strong>.
                    Silakan berikan alasan penolakan:
                </p>

                <textarea name="rejection_reason" id="rejection_reason" rows="4" required
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

    @push('scripts')
        <script>
            function switchTab(tab) {
                // Hide all content
                document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));

                // Remove active class from all tabs
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('active', 'border-blue-600', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                        'hover:border-gray-300');
                });

                // Show selected content
                document.getElementById('content-' + tab).classList.remove('hidden');

                // Add active class to selected tab
                const activeTab = document.getElementById('tab-' + tab);
                activeTab.classList.add('active', 'border-blue-600', 'text-blue-600');
                activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700',
                    'hover:border-gray-300');
            }

            function showRejectModal(sellerId, storeName) {
                document.getElementById('rejectStoreName').textContent = storeName;
                document.getElementById('rejectForm').action = `/admin/sellers/approval/${sellerId}/reject`;
                document.getElementById('rejectModal').classList.remove('hidden');
            }

            function hideRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
                document.getElementById('rejection_reason').value = '';
            }

            // Initialize first tab as active
            document.addEventListener('DOMContentLoaded', function() {
                switchTab('pending');
            });
        </script>
    @endpush
@endsection

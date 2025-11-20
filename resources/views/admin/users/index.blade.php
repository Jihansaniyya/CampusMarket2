@extends('layouts.admin')

@section('title', 'Kelola User')

@section('page-title', 'Kelola User')
@section('page-description')
    Lihat dan kelola seluruh user yang terdaftar di platform.
@endsection

@section('content')
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <div>
                <p class="text-sm text-gray-500">Total user terdaftar</p>
                <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Seller</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bergabung</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4 capitalize">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->role === 'seller')
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{
                                        $user->approval_status === 'approved' ? 'bg-emerald-100 text-emerald-700' :
                                        ($user->approval_status === 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700')
                                    }}">
                                        {{ ucfirst($user->approval_status) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $user->created_at?->translatedFormat('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada user terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
@endsection

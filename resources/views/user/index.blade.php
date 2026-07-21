@extends('layouts.app')

@section('title', 'Manajemen User')
@section('header', '👥 Manajemen Pengguna')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Deskripsi -->
    <div class="mb-6">
        <p class="text-gray-600">Kelola akses dan akun petugas kesehatan dalam ekosistem Sipantau.</p>
    </div>

    <!-- ===== TOMBOL TAMBAH ===== -->
    <div class="flex justify-end mb-4">
        <a href="{{ route('user.create') }}"
           class="bg-pink-500 hover:bg-pink-600 text-white font-bold px-4 py-2.5 rounded-xl shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
            <i class="fas fa-user-plus"></i> Tambah Data
        </a>
    </div>

    <!-- ===== NOTIFIKASI ===== -->
    @if(session('success'))
        <div class="mb-4 bg-pink-100/80 backdrop-blur-sm border-l-4 border-pink-500 text-pink-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
            <i class="fas fa-check-circle text-pink-500 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100/80 backdrop-blur-sm border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- ===== TABEL USER ===== -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-white/20">
                <thead class="bg-pink-100/30 backdrop-blur-sm">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Username</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white/10 backdrop-blur-sm divide-y divide-white/10">
                    @forelse($users as $user)
                    <tr class="hover:bg-white/20 transition duration-200 {{ $loop->even ? 'bg-white/5' : '' }}">
                        <td class="px-4 py-3 whitespace-nowrap text-gray-800 font-medium">{{ $user->nama }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ $user->username }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                @if($user->role == 'Admin') text-purple-800 bg-purple-100
                                @elseif($user->role == 'Kader') text-green-800 bg-green-100
                                @elseif($user->role == 'Ibu') text-blue-800 bg-blue-100
                                @elseif($user->role == 'Puskesmas') text-orange-800 bg-orange-100
                                @elseif($user->role == 'Dinas') text-teal-800 bg-teal-100
                                @elseif($user->role == 'Petugas') text-yellow-800 bg-yellow-100
                                @else bg-gray-200 text-gray-800 @endif
                            ">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ $user->email }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $user->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                            ">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('user.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700 transition" title="Edit">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus" @if($user->id == auth()->id()) disabled @endif>
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500 italic">Belum ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-white/20 bg-white/10 backdrop-blur-sm flex justify-between items-center text-sm text-gray-600">
            <span>Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pengguna</span>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- ===== AUDIT LOG ===== -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 mb-6 transition hover:shadow-xl">
        <div class="flex flex-wrap justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-pink-600">🛡️ Audit Log Keamanan</h3>
                <p class="text-sm text-gray-600">Pantau aktivitas login dan perubahan data sensitif oleh admin dan petugas.</p>
            </div>
            <a href="#" class="text-pink-500 hover:text-pink-700 text-sm font-medium transition flex items-center gap-1">
                Lihat Log Aktivitas →
            </a>
        </div>
    </div>

    <!-- ===== BANTUAN TEKNIS ===== -->
    <div class="bg-white/20 backdrop-blur-md border border-white/30 shadow-lg rounded-2xl p-5 transition hover:shadow-xl">
        <div class="flex flex-wrap justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-pink-600">📌 Butuh Bantuan Akun?</h3>
                <p class="text-sm text-gray-600">Jika petugas lupa password atau mengalami kendala login, gunakan fitur reset password di tabel.</p>
            </div>
            <a href="#" class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2.5 rounded-xl shadow transition flex items-center gap-2">
                <i class="fas fa-life-ring"></i> Bantuan Teknis
            </a>
        </div>
    </div>

</div>
@endsection
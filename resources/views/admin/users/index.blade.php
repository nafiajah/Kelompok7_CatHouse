@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Admin Capyca')
@section('page_title', 'Manajemen Pengguna & Pelanggan')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action / Filter Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <div class="relative min-w-[240px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama, email, username, no telp..." 
                    class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white"
                >
            </div>

            <select 
                name="role" 
                class="px-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white"
            >
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Pelanggan (User)</option>
            </select>

            <button type="submit" class="px-3 py-1.5 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition">
                Filter
            </button>
            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition">
                    Reset
                </a>
            @endif
        </form>

        <span class="text-xs text-slate-500 font-semibold">
            Total: {{ $users->total() }} Pengguna
        </span>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase text-slate-500">
                    <tr>
                        <th class="py-3.5 px-6">Pengguna</th>
                        <th class="py-3.5 px-6">Username</th>
                        <th class="py-3.5 px-6">Role</th>
                        <th class="py-3.5 px-6">Kontak</th>
                        <th class="py-3.5 px-6">Aktivitas Booking</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-amber-100 text-amber-800' }} font-bold flex items-center justify-center text-sm">
                                    {{ strtoupper(substr($user->nama_pelanggan, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ $user->nama_pelanggan }}</p>
                                    <p class="text-slate-400 text-[11px]">{{ $user->email }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-mono font-medium text-slate-600">
                                {{ $user->username }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 border border-purple-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                <p class="font-semibold">{{ $user->no_telp }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-700">{{ $user->reservations_count }}x Reservasi</span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        type="button" 
                                        onclick="openEditUser({{ $user->id }}, '{{ $user->nama_pelanggan }}', '{{ $user->email }}', '{{ $user->no_telp }}', '{{ $user->role }}')"
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition"
                                        title="Edit Pengguna"
                                    >
                                        <i class="fa-solid fa-user-pen text-sm"></i>
                                    </button>

                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun {{ $user->nama_pelanggan }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Tidak ada data pengguna yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

</div>

<!-- Modal Edit User -->
<div id="editUserModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200">
        <h3 class="text-sm font-bold uppercase text-slate-800 mb-4">Edit Data Pengguna</h3>
        
        <form id="editUserForm" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_nama" class="block font-bold text-slate-700 mb-1">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="nama_pelanggan" 
                    id="edit_nama" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
            </div>

            <div>
                <label for="edit_email" class="block font-bold text-slate-700 mb-1">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="edit_email" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
            </div>

            <div>
                <label for="edit_telp" class="block font-bold text-slate-700 mb-1">No. Telepon</label>
                <input 
                    type="text" 
                    name="no_telp" 
                    id="edit_telp" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
            </div>

            <div>
                <label for="edit_role" class="block font-bold text-slate-700 mb-1">Role Akun</label>
                <select 
                    name="role" 
                    id="edit_role" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
                    <option value="user">User / Pelanggan</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div>
                <label for="edit_password" class="block font-bold text-slate-700 mb-1">Password Baru (Opsional)</label>
                <input 
                    type="password" 
                    name="password" 
                    id="edit_password" 
                    placeholder="Kosongkan jika tidak ingin mengubah password" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditUser()" class="px-4 py-2 rounded-xl text-slate-500 font-bold hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function openEditUser(id, nama, email, telp, role) {
        document.getElementById('editUserForm').action = '/admin/users/' + id;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_telp').value = telp;
        document.getElementById('edit_role').value = role;
        document.getElementById('editUserModal').classList.remove('hidden');
    }

    function closeEditUser() {
        document.getElementById('editUserModal').classList.add('hidden');
    }
</script>
@endsection
@endsection

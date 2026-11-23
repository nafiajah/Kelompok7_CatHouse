@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Cat House Admin')
@section('page_title', 'Manajemen Pengguna & Pelanggan')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-stone-300 shadow-md">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <div class="relative min-w-[240px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-stone-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, email, username, no telp..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent bg-white shadow-2xs"
                >
            </div>

            <select
                name="role"
                class="px-3 py-2 text-xs rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent bg-white shadow-2xs font-medium"
            >
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Pelanggan (User)</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-[#2E2421] text-white rounded-xl text-xs font-bold hover:bg-stone-900 transition shadow-2xs cursor-pointer">
                Filter
            </button>
            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 bg-stone-100 text-stone-600 rounded-xl text-xs font-bold hover:bg-stone-200 transition">
                    Reset
                </a>
            @endif
        </form>

        <span class="text-xs text-stone-500 font-semibold">
            Total: {{ $users->total() }} Pengguna
        </span>
    </div>

    <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-[#EAE5E0] border-b border-stone-200 text-xs font-bold uppercase text-stone-600 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Pengguna</th>
                        <th class="py-3.5 px-6">Username</th>
                        <th class="py-3.5 px-6">Role</th>
                        <th class="py-3.5 px-6">Kontak</th>
                        <th class="py-3.5 px-6">Aktivitas Booking</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $user->role === 'admin' ? 'bg-[#F5BFC9] text-[#96384C]' : 'bg-[#94BCC1] text-white' }} font-bold flex items-center justify-center text-sm shadow-2xs flex-shrink-0">
                                    {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-stone-800 text-sm truncate">{{ $user->nama_lengkap }}</p>
                                    <p class="text-stone-400 text-[11px] truncate">{{ $user->email }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-mono font-medium text-stone-600">
                                {{ $user->username }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 rounded-xl text-xs font-bold uppercase inline-block shadow-2xs {{ $user->role === 'admin' ? 'bg-[#F5BFC9] text-[#96384C]' : 'bg-[#94BCC1] text-white' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-stone-600">
                                <p class="font-semibold">{{ $user->no_telp }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-stone-700">{{ $user->reservations_count }}x Reservasi</span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <button
                                        type="button"
                                        onclick="openEditUserModal(this)"
                                        data-action="{{ route('admin.users.update', $user->id) }}"
                                        data-nama="{{ $user->nama_lengkap }}"
                                        data-email="{{ $user->email }}"
                                        data-telp="{{ $user->no_telp }}"
                                        data-role="{{ $user->role }}"
                                        class="text-stone-700 hover:text-stone-900 transition cursor-pointer"
                                        title="Edit Pengguna"
                                    >
                                        <i class="fa-regular fa-pen-to-square text-lg"></i>
                                    </button>

                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" data-delete-confirm="Apakah Anda yakin ingin menghapus akun &quot;{{ $user->nama_lengkap }}&quot;?">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="text-stone-700 hover:text-red-600 transition cursor-pointer"
                                                title="Hapus"
                                            >
                                                <i class="fa-regular fa-trash-can text-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-stone-400">
                                Tidak ada data pengguna yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-stone-200 bg-stone-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<div id="editUserModal" class="fixed inset-0 z-50 bg-black/45 backdrop-blur-[2px] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[20px] border border-stone-300 shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="px-6 sm:px-7 py-5 border-b border-stone-300 flex items-center justify-between">
            <h3 class="text-lg sm:text-xl font-bold text-[#3F322A]">Edit Data Pengguna</h3>
            <button type="button" onclick="closeEditUserModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form id="editUserForm" action="{{ old('_edit_action', '') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="_modal" value="edit_user">
            <input type="hidden" name="_edit_action" id="edit_user_action_hidden" value="{{ old('_edit_action', '') }}">

            <div class="px-6 sm:px-7 py-5 space-y-4 max-h-[70vh] overflow-y-auto">
                @if($errors->any() && old('_modal') === 'edit_user')
                    <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label for="edit_nama" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        name="nama_lengkap"
                        id="edit_nama"
                        value="{{ old('_modal') === 'edit_user' ? old('nama_lengkap') : '' }}"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>

                <div>
                    <label for="edit_email" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="edit_email"
                        value="{{ old('_modal') === 'edit_user' ? old('email') : '' }}"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>

                <div>
                    <label for="edit_telp" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        No. Telepon
                    </label>
                    <input
                        type="text"
                        name="no_telp"
                        id="edit_telp"
                        value="{{ old('_modal') === 'edit_user' ? old('no_telp') : '' }}"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>

                <div>
                    <label for="edit_role" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Role Akun
                    </label>
                    <div class="relative">
                        <select
                            name="role"
                            id="edit_role"
                            required
                            class="w-full appearance-none px-3.5 py-2.5 pr-9 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white cursor-pointer"
                        >
                            <option value="user" {{ old('_modal') === 'edit_user' && old('role') === 'user' ? 'selected' : '' }}>User / Pelanggan</option>
                            <option value="admin" {{ old('_modal') === 'edit_user' && old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-3.5 flex items-center text-stone-600 text-xs">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                </div>

                <div>
                    <label for="edit_password" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Password Baru (Opsional)
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="edit_password"
                        placeholder="Kosongkan jika tidak ingin mengubah password"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] placeholder:text-stone-400 focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>
            </div>

            <div class="px-6 sm:px-7 py-4 border-t border-stone-300 flex items-center justify-end gap-3 bg-white">
                <button
                    type="button"
                    onclick="closeEditUserModal()"
                    class="px-5 py-2 rounded-lg border border-stone-400 bg-white text-[#3F322A] text-xs sm:text-sm font-medium hover:bg-stone-100 transition cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-5 py-2 rounded-lg bg-[#E58B9C] hover:bg-[#D77487] text-white text-xs sm:text-sm font-medium transition cursor-pointer"
                >
                    Edit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openEditUserModal(btn) {
        const action = btn.getAttribute('data-action');
        document.getElementById('editUserForm').action = action;
        document.getElementById('edit_user_action_hidden').value = action;
        document.getElementById('edit_nama').value = btn.getAttribute('data-nama');
        document.getElementById('edit_email').value = btn.getAttribute('data-email');
        document.getElementById('edit_telp').value = btn.getAttribute('data-telp');
        document.getElementById('edit_role').value = btn.getAttribute('data-role');
        document.getElementById('edit_password').value = '';
        document.getElementById('editUserModal').classList.remove('hidden');
    }

    function closeEditUserModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }

    const editUserModalEl = document.getElementById('editUserModal');
    if (editUserModalEl) {
        editUserModalEl.addEventListener('click', function (e) {
            if (e.target === editUserModalEl) closeEditUserModal();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeEditUserModal();
    });

    @if($errors->any() && old('_modal') === 'edit_user')
        document.getElementById('editUserModal').classList.remove('hidden');
    @endif
</script>
@endsection

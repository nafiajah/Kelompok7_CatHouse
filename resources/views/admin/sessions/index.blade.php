@extends('layouts.admin')

@section('title', 'Sesi & Kuota Kunjungan - Cat House Admin')
@section('page_title', 'Manajemen Sesi & Kuota')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form action="{{ route('admin.sessions.index') }}" method="GET" class="flex items-center gap-2 max-w-lg w-full">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari jam sesi (contoh: 08:00)..."
                    class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent bg-white shadow-xs"
                >
            </div>
            <button type="submit" class="px-5 py-2.5 bg-[#2E2421] text-white rounded-xl text-xs sm:text-sm font-bold hover:bg-stone-900 transition shadow-xs flex-shrink-0 cursor-pointer">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.sessions.index') }}" class="px-4 py-2.5 bg-stone-100 text-stone-600 rounded-xl text-xs sm:text-sm font-bold hover:bg-stone-200 transition flex-shrink-0">
                    Reset
                </a>
            @endif
        </form>

        <button
            type="button"
            onclick="openCreateSessionModal()"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#E58B9C] hover:bg-[#D77487] text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition flex-shrink-0 whitespace-nowrap cursor-pointer"
        >
            <i class="fa-solid fa-plus text-xs"></i> Tambah Sesi Baru
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-200">
            <h3 class="text-base sm:text-lg font-bold text-stone-800">
                Daftar Sesi Kunjungan ({{ count($sessions) }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-[#EAE5E0] border-b border-stone-200 text-xs font-bold uppercase text-stone-600 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">JAM SESI</th>
                        <th class="py-3.5 px-6 text-center">TOKEN KUOTA (MAKS. ORANG)</th>
                        <th class="py-3.5 px-6 text-center">TOTAL BOOKING</th>
                        <th class="py-3.5 px-6 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6 font-semibold text-stone-800 text-sm sm:text-base">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-rose-500"></i>
                                    <span>{{ $session->jam_sesi }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-4 py-1.5 rounded-xl bg-[#94BCC1] text-white font-bold text-xs inline-block shadow-2xs">
                                    {{ $session->token_sesi }} Orang
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center font-medium text-stone-600 text-xs sm:text-sm">
                                {{ $session->reservations_count }} Reservasi
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <button
                                        type="button"
                                        onclick="openEditSessionModal(this)"
                                        data-action="{{ route('admin.sessions.update', $session->id) }}"
                                        data-jam="{{ $session->jam_sesi }}"
                                        data-token="{{ $session->token_sesi }}"
                                        class="text-stone-700 hover:text-stone-900 transition cursor-pointer"
                                        title="Edit Sesi"
                                    >
                                        <i class="fa-regular fa-pen-to-square text-lg"></i>
                                    </button>

                                    <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" data-delete-confirm="Apakah Anda yakin ingin menghapus sesi &quot;{{ $session->jam_sesi }}&quot;?">
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
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-stone-400">
                                @if(request('search'))
                                    Tidak ada sesi kunjungan yang cocok dengan pencarian "{{ request('search') }}".
                                @else
                                    Belum ada sesi kunjungan yang diatur.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<div id="createSessionModal" class="fixed inset-0 z-50 bg-black/45 backdrop-blur-[2px] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[20px] border border-stone-300 shadow-2xl w-full max-w-md overflow-hidden">
        <div class="px-6 sm:px-7 py-5 border-b border-stone-300 flex items-center justify-between">
            <h3 class="text-lg sm:text-xl font-bold text-[#3F322A]">Tambah Sesi Kunjungan</h3>
            <button type="button" onclick="closeCreateSessionModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form action="{{ route('admin.sessions.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_modal" value="create_session">

            <div class="px-6 sm:px-7 py-5 space-y-4">
                @if($errors->any() && old('_modal') === 'create_session')
                    <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label for="create_jam_sesi" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Rentang Jam Sesi
                    </label>
                    <input
                        type="text"
                        name="jam_sesi"
                        id="create_jam_sesi"
                        value="{{ old('_modal') === 'create_session' ? old('jam_sesi') : '' }}"
                        required
                        placeholder="Contoh: 08:00 - 08:30"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] placeholder:text-stone-400 focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                    <p class="mt-1 text-[11px] text-stone-400">Format: Jam mulai - Jam selesai (durasi 30 menit)</p>
                </div>

                <div>
                    <label for="create_token_sesi" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Token Kuota Pengunjung
                    </label>
                    <input
                        type="number"
                        name="token_sesi"
                        id="create_token_sesi"
                        value="{{ old('_modal') === 'create_session' ? old('token_sesi', 10) : 10 }}"
                        min="1"
                        max="100"
                        required
                        placeholder="10"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                    <p class="mt-1 text-[11px] text-stone-400">Maksimal jumlah orang yang boleh reservasi di sesi ini.</p>
                </div>
            </div>

            <div class="px-6 sm:px-7 py-4 border-t border-stone-300 flex items-center justify-end gap-3 bg-white">
                <button
                    type="button"
                    onclick="closeCreateSessionModal()"
                    class="px-5 py-2 rounded-lg border border-stone-400 bg-white text-[#3F322A] text-xs sm:text-sm font-medium hover:bg-stone-100 transition cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-5 py-2 rounded-lg bg-[#E58B9C] hover:bg-[#D77487] text-white text-xs sm:text-sm font-medium transition cursor-pointer"
                >
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editSessionModal" class="fixed inset-0 z-50 bg-black/45 backdrop-blur-[2px] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[20px] border border-stone-300 shadow-2xl w-full max-w-md overflow-hidden">
        <div class="px-6 sm:px-7 py-5 border-b border-stone-300 flex items-center justify-between">
            <h3 class="text-lg sm:text-xl font-bold text-[#3F322A]">Edit Sesi Kunjungan</h3>
            <button type="button" onclick="closeEditSessionModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form id="editSessionForm" action="{{ old('_edit_action', '') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="_modal" value="edit_session">
            <input type="hidden" name="_edit_action" id="edit_session_action_hidden" value="{{ old('_edit_action', '') }}">

            <div class="px-6 sm:px-7 py-5 space-y-4">
                @if($errors->any() && old('_modal') === 'edit_session')
                    <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label for="edit_jam_sesi" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Rentang Jam Sesi
                    </label>
                    <input
                        type="text"
                        name="jam_sesi"
                        id="edit_jam_sesi"
                        value="{{ old('_modal') === 'edit_session' ? old('jam_sesi') : '' }}"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>

                <div>
                    <label for="edit_token_sesi" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Token Kuota (Orang)
                    </label>
                    <input
                        type="number"
                        name="token_sesi"
                        id="edit_token_sesi"
                        value="{{ old('_modal') === 'edit_session' ? old('token_sesi') : '' }}"
                        min="1"
                        max="100"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>
            </div>

            <div class="px-6 sm:px-7 py-4 border-t border-stone-300 flex items-center justify-end gap-3 bg-white">
                <button
                    type="button"
                    onclick="closeEditSessionModal()"
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
    function openCreateSessionModal() {
        document.getElementById('createSessionModal').classList.remove('hidden');
    }

    function closeCreateSessionModal() {
        document.getElementById('createSessionModal').classList.add('hidden');
    }

    function openEditSessionModal(btn) {
        const action = btn.getAttribute('data-action');
        const jam = btn.getAttribute('data-jam');
        const token = btn.getAttribute('data-token');

        document.getElementById('editSessionForm').action = action;
        document.getElementById('edit_session_action_hidden').value = action;
        document.getElementById('edit_jam_sesi').value = jam;
        document.getElementById('edit_token_sesi').value = token;
        document.getElementById('editSessionModal').classList.remove('hidden');
    }

    function closeEditSessionModal() {
        document.getElementById('editSessionModal').classList.add('hidden');
    }

    ['createSessionModal', 'editSessionModal'].forEach(function (id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) modal.classList.add('hidden');
            });
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeCreateSessionModal();
            closeEditSessionModal();
        }
    });

    @if($errors->any() && old('_modal') === 'create_session')
        openCreateSessionModal();
    @elseif($errors->any() && old('_modal') === 'edit_session')
        document.getElementById('editSessionModal').classList.remove('hidden');
    @endif
</script>
@endsection

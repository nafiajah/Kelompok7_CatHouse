@extends('layouts.admin')

@section('title', 'Sesi & Kuota Kunjungan - Admin Capyca')
@section('page_title', 'Manajemen Sesi & Kuota')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left: Add Session Form -->
    <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-3">
            Tambah Sesi Baru
        </h3>

        <form action="{{ route('admin.sessions.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label for="jam_sesi" class="block font-bold text-slate-700 mb-1.5">
                    Rentang Jam Sesi <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="jam_sesi" 
                    id="jam_sesi" 
                    value="{{ old('jam_sesi') }}" 
                    required 
                    placeholder="Contoh: 10:00 - 11:30" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('jam_sesi') border-red-500 @enderror"
                >
                <span class="text-[11px] text-slate-400 mt-1 block">Format: Jam Mulai - Jam Selesai</span>
                @error('jam_sesi')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="token_sesi" class="block font-bold text-slate-700 mb-1.5">
                    Token Kuota Pengunjung <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    name="token_sesi" 
                    id="token_sesi" 
                    value="{{ old('token_sesi', 15) }}" 
                    min="1" 
                    max="100" 
                    required 
                    placeholder="Contoh: 15" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('token_sesi') border-red-500 @enderror"
                >
                <span class="text-[11px] text-slate-400 mt-1 block">Maksimal jumlah orang yang boleh reservasi di jam ini</span>
                @error('token_sesi')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-sm transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Tambah Sesi
            </button>
        </form>
    </div>

    <!-- Right: List Sessions Table -->
    <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-800">Daftar Sesi Kunjungan ({{ count($sessions) }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase text-slate-500">
                    <tr>
                        <th class="py-3 px-6">No</th>
                        <th class="py-3 px-6">Jam Sesi</th>
                        <th class="py-3 px-6">Token Kuota (Maks. Orang)</th>
                        <th class="py-3 px-6">Total Booking</th>
                        <th class="py-3 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sessions as $index => $session)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3.5 px-6 font-mono text-slate-400">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-3.5 px-6 font-bold text-slate-800 text-sm flex items-center gap-2">
                                <i class="fa-regular fa-clock text-amber-600"></i>
                                {{ $session->jam_sesi }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 font-bold text-[11px]">
                                    {{ $session->token_sesi }} Orang
                                </span>
                            </td>
                            <td class="py-3.5 px-6 font-semibold text-slate-600">
                                {{ $session->reservations_count }} Reservasi
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        type="button" 
                                        onclick="openEditSession({{ $session->id }}, '{{ $session->jam_sesi }}', {{ $session->token_sesi }})"
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition"
                                        title="Edit Sesi"
                                    >
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </button>

                                    <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Hapus sesi {{ $session->jam_sesi }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                Belum ada sesi kunjungan yang diatur.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Edit Session -->
<div id="editSessionModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-slate-200">
        <h3 class="text-sm font-bold uppercase text-slate-800 mb-4">Edit Sesi Kunjungan</h3>
        
        <form id="editSessionForm" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_jam_sesi" class="block font-bold text-slate-700 mb-1">Jam Sesi</label>
                <input 
                    type="text" 
                    name="jam_sesi" 
                    id="edit_jam_sesi" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
            </div>

            <div>
                <label for="edit_token_sesi" class="block font-bold text-slate-700 mb-1">Token Kuota (Orang)</label>
                <input 
                    type="number" 
                    name="token_sesi" 
                    id="edit_token_sesi" 
                    min="1" 
                    max="100" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditSession()" class="px-4 py-2 rounded-xl text-slate-500 font-bold hover:bg-slate-100">
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
    function openEditSession(id, jam, token) {
        document.getElementById('editSessionForm').action = '/admin/sessions/' + id;
        document.getElementById('edit_jam_sesi').value = jam;
        document.getElementById('edit_token_sesi').value = token;
        document.getElementById('editSessionModal').classList.remove('hidden');
    }

    function closeEditSession() {
        document.getElementById('editSessionModal').classList.add('hidden');
    }
</script>
@endsection
@endsection

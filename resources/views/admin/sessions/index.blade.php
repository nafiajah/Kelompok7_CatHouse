@extends('layouts.admin')

@section('title', 'Sesi & Kuota Kunjungan - Cat House Admin')
@section('page_title', 'Manajemen Sesi & Kuota')

@section('content')
<div class="space-y-6">
    
    <!-- Top Card: Tambah Sesi Baru (Full Width Card) -->
    <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-200">
            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-stone-700">
                TAMBAH SESI BARU
            </h3>
        </div>

        <form action="{{ route('admin.sessions.store') }}" method="POST" class="p-6 space-y-4 text-xs sm:text-sm">
            @csrf

            <div>
                <label for="jam_sesi" class="block font-bold text-stone-700 mb-1.5 text-xs">
                    Rentang Jam Sesi <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="jam_sesi" 
                    id="jam_sesi" 
                    value="{{ old('jam_sesi') }}" 
                    required 
                    placeholder="Contoh: 10.00-11.35" 
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent @error('jam_sesi') border-red-500 @enderror bg-white"
                >
                <span class="text-[11px] text-stone-400 mt-1 block">Format: Jam mulai-Jam selesai</span>
                @error('jam_sesi')
                    <p class="mt-1 text-red-600 font-medium text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="token_sesi" class="block font-bold text-stone-700 mb-1.5 text-xs">
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
                    placeholder="15" 
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent @error('token_sesi') border-red-500 @enderror bg-white"
                >
                <span class="text-[11px] text-stone-400 mt-1 block">Maksimal jumlah orang yang boleh reservasi di jam ini</span>
                @error('token_sesi')
                    <p class="mt-1 text-red-600 font-medium text-xs">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2.5 bg-[#E58B9C] hover:bg-[#D77A8B] text-white font-medium rounded-xl shadow-xs transition flex items-center justify-center gap-1.5 text-sm">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Sesi
            </button>
        </form>
    </div>

    <!-- Bottom Card: Daftar Sesi Kunjungan (Full Width Card) -->
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
                                        onclick="openEditSession({{ $session->id }}, '{{ $session->jam_sesi }}', {{ $session->token_sesi }})"
                                        class="text-stone-700 hover:text-stone-900 transition"
                                        title="Edit Sesi"
                                    >
                                        <i class="fa-regular fa-pen-to-square text-lg"></i>
                                    </button>

                                    <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Hapus sesi {{ $session->jam_sesi }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="text-stone-700 hover:text-red-600 transition" 
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
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-stone-300">
        <h3 class="text-sm font-bold uppercase text-stone-800 mb-4">Edit Sesi Kunjungan</h3>
        
        <form id="editSessionForm" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_jam_sesi" class="block font-bold text-stone-700 mb-1">Jam Sesi</label>
                <input 
                    type="text" 
                    name="jam_sesi" 
                    id="edit_jam_sesi" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent"
                >
            </div>

            <div>
                <label for="edit_token_sesi" class="block font-bold text-stone-700 mb-1">Token Kuota (Orang)</label>
                <input 
                    type="number" 
                    name="token_sesi" 
                    id="edit_token_sesi" 
                    min="1" 
                    max="100" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent"
                >
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditSession()" class="px-4 py-2 rounded-xl text-stone-500 font-bold hover:bg-stone-100">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#E58B9C] hover:bg-[#D77A8B] text-white font-bold">
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

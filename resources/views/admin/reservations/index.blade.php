@extends('layouts.admin')

@section('title', 'Data Reservasi - Cat House Admin')
@section('page_title', 'Daftar Reservasi Kunjungan')

@section('content')
<div class="space-y-6">
    
    <!-- Filter Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-stone-300 shadow-md">
        <form action="{{ route('admin.reservations.index') }}" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-stone-600">Filter Tanggal:</span>
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date') }}" 
                    class="px-3 py-1.5 text-xs rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent bg-white"
                >
            </div>
            <button type="submit" class="px-4 py-1.5 bg-[#2E2421] text-white rounded-xl text-xs font-bold hover:bg-stone-900 transition">
                Terapkan
            </button>
            @if(request('date'))
                <a href="{{ route('admin.reservations.index') }}" class="px-3 py-1.5 bg-stone-100 text-stone-600 rounded-xl text-xs font-bold hover:bg-stone-200 transition">
                    Reset
                </a>
            @endif
        </form>

        <span class="text-xs text-stone-500 font-semibold">
            Total: {{ $reservations->total() }} Data Reservasi
        </span>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-[#EAE5E0] border-b border-stone-200 text-xs font-bold uppercase text-stone-600 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">ID & Booking Code</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Tanggal Kunjungan</th>
                        <th class="py-3.5 px-6">Sesi / Jam</th>
                        <th class="py-3.5 px-6">Tamu</th>
                        <th class="py-3.5 px-6">Total & Metode</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200">
                    @forelse($reservations as $res)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-rose-800 text-xs">
                                #CAT-{{ str_pad($res->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-stone-800 text-sm">{{ $res->user ? $res->user->nama_pelanggan : '-' }}</p>
                                <p class="text-stone-400 text-[11px]">{{ $res->user ? $res->user->no_telp : '-' }} &bull; {{ $res->user ? $res->user->email : '-' }}</p>
                            </td>
                            <td class="py-4 px-6 font-semibold text-stone-700">
                                {{ \Carbon\Carbon::parse($res->tanggal_reservasi)->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3.5 py-1 rounded-xl bg-[#94BCC1] text-white font-bold text-xs inline-block shadow-2xs">
                                    {{ $res->session ? $res->session->jam_sesi : $res->waktu_reservasi }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-bold text-stone-800">
                                {{ $res->payment ? $res->payment->jumlah_tamu : 1 }} Tamu
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-stone-800 text-sm block">Rp {{ number_format($res->payment ? $res->payment->total_harga : 0, 0, ',', '.') }}</span>
                                <span class="text-[10px] uppercase font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-full inline-block mt-0.5">
                                    {{ $res->payment ? $res->payment->metode_pembayaran : '-' }} (Lunas)
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a 
                                        href="{{ route('reservasi.show', $res->id) }}" 
                                        target="_blank" 
                                        class="text-stone-700 hover:text-stone-900 transition" 
                                        title="Lihat Tiket"
                                    >
                                        <i class="fa-regular fa-newspaper text-lg"></i>
                                    </a>
                                    <form action="{{ route('admin.reservations.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Hapus data reservasi ini?')">
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
                            <td colspan="7" class="py-12 text-center text-stone-400">
                                Belum ada data reservasi yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reservations->hasPages())
            <div class="p-4 border-t border-stone-200 bg-stone-50/50">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@extends('layouts.admin')

@section('title', 'Data Reservasi - Admin Capyca')
@section('page_title', 'Daftar Reservasi Kunjungan')

@section('content')
<div class="space-y-6">
    
    <!-- Filter Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.reservations.index') }}" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-500">Filter Tanggal:</span>
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date') }}" 
                    class="px-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white"
                >
            </div>
            <button type="submit" class="px-3 py-1.5 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition">
                Terapkan
            </button>
            @if(request('date'))
                <a href="{{ route('admin.reservations.index') }}" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition">
                    Reset
                </a>
            @endif
        </form>

        <span class="text-xs text-slate-500 font-semibold">
            Total: {{ $reservations->total() }} Data Reservasi
        </span>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase text-slate-500">
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
                <tbody class="divide-y divide-slate-100">
                    @forelse($reservations as $res)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-amber-800">
                                #CPY-{{ str_pad($res->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800 text-sm">{{ $res->user ? $res->user->nama_pelanggan : '-' }}</p>
                                <p class="text-slate-400 text-[11px]">{{ $res->user ? $res->user->no_telp : '-' }} • {{ $res->user ? $res->user->email : '-' }}</p>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-700">
                                {{ \Carbon\Carbon::parse($res->tanggal_reservasi)->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 font-bold text-[11px]">
                                    {{ $res->session ? $res->session->jam_sesi : $res->waktu_reservasi }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $res->payment ? $res->payment->jumlah_tamu : 1 }} Tamu
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-800 text-sm block">Rp {{ number_format($res->payment ? $res->payment->total_harga : 0, 0, ',', '.') }}</span>
                                <span class="text-[10px] uppercase font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full inline-block mt-0.5">
                                    {{ $res->payment ? $res->payment->metode_pembayaran : '-' }} (Lunas)
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('reservasi.show', $res->id) }}" target="_blank" class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Lihat Tiket">
                                        <i class="fa-solid fa-receipt text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.reservations.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Hapus data reservasi ini?')">
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
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                Belum ada data reservasi yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $reservations->links() }}
        </div>
    </div>

</div>
@endsection

@extends('layouts.admin')

@section('title', 'Laporan Pembayaran - Admin Capyca')
@section('page_title', 'Laporan Pembayaran & Transaksi')

@section('content')
<div class="space-y-6">
    
    <!-- Revenue Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Seluruh Transaksi</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <span class="text-xs text-slate-500">{{ $payments->total() }} Transaksi Berhasil</span>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Pemasukan QRIS</p>
            <h3 class="text-2xl font-extrabold text-amber-700 mt-1">Rp {{ number_format($totalQris, 0, ',', '.') }}</h3>
            <span class="text-xs text-amber-600 font-medium">Metode QRIS</span>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Pemasukan Transfer Bank</p>
            <h3 class="text-2xl font-extrabold text-blue-700 mt-1">Rp {{ number_format($totalBank, 0, ',', '.') }}</h3>
            <span class="text-xs text-blue-600 font-medium">Metode Rekening Bank</span>
        </div>
    </div>

    <!-- Filter Methods -->
    <div class="flex items-center gap-2">
        <a 
            href="{{ route('admin.payments.index') }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$method ? 'bg-slate-800 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}"
        >
            Semua Metode
        </a>
        <a 
            href="{{ route('admin.payments.index', ['metode' => 'qris']) }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $method === 'qris' ? 'bg-amber-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}"
        >
            QRIS
        </a>
        <a 
            href="{{ route('admin.payments.index', ['metode' => 'bank']) }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $method === 'bank' ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}"
        >
            Transfer Bank
        </a>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase text-slate-500">
                    <tr>
                        <th class="py-3.5 px-6">ID Pembayaran</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Jumlah Tamu</th>
                        <th class="py-3.5 px-6">Total Tagihan</th>
                        <th class="py-3.5 px-6">Metode</th>
                        <th class="py-3.5 px-6">Waktu Transaksi</th>
                        <th class="py-3.5 px-6 text-right">Tiket</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-500">
                                #PAY-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800 text-sm">{{ $payment->user ? $payment->user->nama_pelanggan : '-' }}</p>
                                <p class="text-slate-400 text-[11px]">{{ $payment->user ? $payment->user->email : '-' }}</p>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-700">
                                {{ $payment->jumlah_tamu }} Orang
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800 text-sm">
                                Rp {{ number_format($payment->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase {{ $payment->metode_pembayaran === 'qris' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $payment->metode_pembayaran }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->translatedFormat('d M Y H:i') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($payment->reservation)
                                    <a href="{{ route('reservasi.show', $payment->reservation->id) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 font-bold transition">
                                        Lihat Tiket
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                Belum ada riwayat transaksi pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $payments->links() }}
        </div>
    </div>

</div>
@endsection

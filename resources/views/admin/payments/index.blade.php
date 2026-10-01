@extends('layouts.admin')

@section('title', 'Laporan Pembayaran - Cat House Admin')
@section('page_title', 'Laporan Pembayaran & Transaksi')

@section('content')
<div class="space-y-6">
    
    <!-- Revenue Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-stone-300 shadow-md">
            <p class="text-xs font-bold uppercase tracking-wider text-stone-400">Total Seluruh Transaksi</p>
            <h3 class="text-2xl font-extrabold text-stone-800 mt-1 truncate">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <span class="text-xs text-stone-500 font-medium">{{ $payments->total() }} Transaksi Berhasil</span>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-stone-300 shadow-md">
            <p class="text-xs font-bold uppercase tracking-wider text-stone-400">Pemasukan QRIS</p>
            <h3 class="text-2xl font-extrabold text-rose-600 mt-1 truncate">Rp {{ number_format($totalQris, 0, ',', '.') }}</h3>
            <span class="text-xs text-rose-500 font-medium">Metode QRIS</span>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-stone-300 shadow-md">
            <p class="text-xs font-bold uppercase tracking-wider text-stone-400">Pemasukan Transfer Bank</p>
            <h3 class="text-2xl font-extrabold text-blue-700 mt-1 truncate">Rp {{ number_format($totalBank, 0, ',', '.') }}</h3>
            <span class="text-xs text-blue-600 font-medium">Metode Rekening Bank</span>
        </div>
    </div>

    <!-- Filter Methods -->
    <div class="flex items-center gap-2">
        <a 
            href="{{ route('admin.payments.index') }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition shadow-2xs {{ !$method ? 'bg-[#2E2421] text-white' : 'bg-white border border-stone-300 text-stone-600 hover:bg-stone-50' }}"
        >
            Semua Metode
        </a>
        <a 
            href="{{ route('admin.payments.index', ['metode' => 'qris']) }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition shadow-2xs {{ $method === 'qris' ? 'bg-[#AA4453] text-white' : 'bg-white border border-stone-300 text-stone-600 hover:bg-stone-50' }}"
        >
            QRIS
        </a>
        <a 
            href="{{ route('admin.payments.index', ['metode' => 'bank']) }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition shadow-2xs {{ $method === 'bank' ? 'bg-blue-600 text-white' : 'bg-white border border-stone-300 text-stone-600 hover:bg-stone-50' }}"
        >
            Transfer Bank
        </a>
    </div>

    <!-- Payments Table Card -->
    <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-[#EAE5E0] border-b border-stone-200 text-xs font-bold uppercase text-stone-600 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">ID Pembayaran</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Jumlah Tamu</th>
                        <th class="py-3.5 px-6">Total Tagihan</th>
                        <th class="py-3.5 px-6">Metode</th>
                        <th class="py-3.5 px-6">Waktu Transaksi</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6 font-mono font-bold text-stone-500">
                                #PAY-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-stone-800 text-sm">{{ $payment->user ? $payment->user->nama_pelanggan : '-' }}</p>
                                <p class="text-stone-400 text-[11px]">{{ $payment->user ? $payment->user->email : '-' }}</p>
                            </td>
                            <td class="py-4 px-6 font-semibold text-stone-700">
                                {{ $payment->jumlah_tamu }} Orang
                            </td>
                            <td class="py-4 px-6 font-bold text-stone-800 text-sm">
                                Rp {{ number_format($payment->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3.5 py-1 rounded-xl text-xs font-bold uppercase inline-block shadow-2xs {{ $payment->metode_pembayaran === 'qris' ? 'bg-[#F5BFC9] text-[#96384C]' : 'bg-[#94BCC1] text-white' }}">
                                    {{ $payment->metode_pembayaran }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-stone-500">
                                {{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->translatedFormat('d M Y H:i') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($payment->reservation)
                                    <a 
                                        href="{{ route('reservasi.show', $payment->reservation->id) }}" 
                                        target="_blank" 
                                        class="text-stone-700 hover:text-stone-900 transition inline-flex items-center gap-1.5" 
                                        title="Lihat Tiket"
                                    >
                                        <i class="fa-regular fa-newspaper text-lg"></i>
                                    </a>
                                @else
                                    <span class="text-stone-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-stone-400">
                                Belum ada riwayat transaksi pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="p-4 border-t border-stone-200 bg-stone-50/50">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

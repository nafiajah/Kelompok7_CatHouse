@extends('layouts.app')

@section('title', 'Bukti Pembayaran & Reservasi - Cat House')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        
        <!-- Success Alert Header -->
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 shadow-xs">
            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-emerald-900">Data Reservasi Telah Masuk ke Sistem!</h4>
                <p class="text-xs text-emerald-700 mt-0.5">Pembayaran Anda telah tervalidasi dan tercatat di database Cat House.</p>
            </div>
        </div>

        <!-- Receipt / Bukti Pembayaran Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-amber-100 overflow-hidden print:shadow-none print:border-none print:m-0" id="printableReceipt">
            
            <!-- Receipt Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-8 text-white text-center relative">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md text-white text-3xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <span class="text-xs uppercase font-extrabold tracking-widest text-emerald-200 block">Bukti Pembayaran Resmi</span>
                <h1 class="text-3xl font-bold font-playfair mt-1">CAT HOUSE</h1>
                <p class="text-xs text-emerald-100 mt-1">No. Bukti Pembayaran: <strong class="font-mono text-white text-sm">#PAY-{{ str_pad($reservation->payment ? $reservation->payment->id : $reservation->id, 5, '0', STR_PAD_LEFT) }}</strong></p>

                <!-- Status Badge -->
                <div class="mt-4 inline-flex items-center gap-2 px-5 py-1.5 rounded-full bg-white text-emerald-800 text-xs font-extrabold shadow-md">
                    <i class="fa-solid fa-check-circle text-emerald-600 text-sm"></i> PEMBAYARAN BERHASIL & LUNAS
                </div>
            </div>

            <!-- Receipt Body -->
            <div class="p-8 space-y-6">
                
                <!-- Booking & Customer Info -->
                <div class="grid grid-cols-2 gap-4 pb-6 border-b border-dashed border-slate-200 text-sm">
                    <div>
                        <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Kode Reservasi</span>
                        <span class="font-bold text-slate-800 text-base font-mono">#CPY-{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Waktu Transaksi</span>
                        <span class="font-bold text-slate-800 text-xs">
                            {{ $reservation->payment ? \Carbon\Carbon::parse($reservation->payment->tanggal_pembayaran)->translatedFormat('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB
                        </span>
                    </div>
                    <div class="pt-2">
                        <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Nama Pelanggan</span>
                        <span class="font-bold text-slate-800">{{ $reservation->user ? $reservation->user->nama_pelanggan : 'Tamu Cat House' }}</span>
                        <span class="text-xs text-slate-500 block">{{ $reservation->user ? $reservation->user->no_telp : '' }}</span>
                    </div>
                    <div class="pt-2">
                        <span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">Jumlah Pengunjung</span>
                        <span class="font-bold text-slate-800">{{ $reservation->payment ? $reservation->payment->jumlah_tamu : 1 }} Orang</span>
                    </div>
                </div>

                <!-- Schedule Section -->
                <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/60 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-amber-900 uppercase tracking-wider block">Jadwal Sesi Kunjungan:</span>
                        <p class="text-base font-bold text-slate-800 mt-0.5">
                            {{ \Carbon\Carbon::parse($reservation->tanggal_reservasi)->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="text-xs text-amber-800 font-semibold flex items-center gap-1.5 mt-0.5">
                            <i class="fa-regular fa-clock"></i> Sesi: {{ $reservation->session ? $reservation->session->jam_sesi : $reservation->waktu_reservasi }} (90 Menit)
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-1 bg-amber-200 text-amber-900 rounded-full font-bold text-xs uppercase">
                            Terkonfirmasi
                        </span>
                    </div>
                </div>

                <!-- Payment Breakdown Table -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Rincian Pembayaran</h3>
                    <div class="rounded-2xl border border-slate-200 overflow-hidden text-xs">
                        <div class="bg-slate-50 p-3 flex justify-between font-bold text-slate-700 border-b border-slate-200">
                            <span>Keterangan</span>
                            <span>Jumlah</span>
                        </div>
                        <div class="p-3.5 space-y-2 bg-white">
                            <div class="flex justify-between text-slate-600">
                                <span>Tiket Kunjungan Cat House ({{ $reservation->payment ? $reservation->payment->jumlah_tamu : 1 }} x Rp 35.000)</span>
                                <span class="font-semibold text-slate-800">Rp {{ number_format($reservation->payment ? $reservation->payment->total_harga : 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Free Welcome Drink & Cat Play Set</span>
                                <span class="font-semibold text-emerald-600">Termasuk</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Metode Pembayaran</span>
                                <span class="font-bold uppercase text-slate-800 px-2 py-0.5 rounded bg-slate-100">{{ $reservation->payment ? $reservation->payment->metode_pembayaran : '-' }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Status Verifikasi</span>
                                <span class="font-bold text-emerald-600 flex items-center gap-1"><i class="fa-solid fa-circle-check"></i> Berhasil Divalidasi</span>
                            </div>
                        </div>
                        <div class="p-4 bg-emerald-50/50 border-t border-slate-200 flex justify-between items-center text-sm">
                            <span class="font-bold text-slate-800">Total Dibayar:</span>
                            <span class="text-2xl font-extrabold text-emerald-700 font-playfair">
                                Rp {{ number_format($reservation->payment ? $reservation->payment->total_harga : 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Validation Stamp Footer -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-1 text-xs text-slate-500">
                    <p class="font-bold text-slate-700 flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-stamp text-emerald-600"></i> Sah Diterbitkan oleh Sistem Cat House
                    </p>
                    <p class="text-[11px]">Tunjukkan bukti pembayaran ini kepada staf resepsionis saat tiba di kafe.</p>
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 flex flex-col sm:flex-row gap-3 print:hidden">
                    <button onclick="window.print()" class="flex-1 py-3.5 px-4 rounded-xl bg-slate-900 hover:bg-black text-white font-bold text-xs transition flex items-center justify-center gap-2 shadow-md">
                        <i class="fa-solid fa-print text-sm"></i> Cetak / Simpan Bukti Pembayaran
                    </button>
                    <a href="{{ route('home') }}" class="py-3.5 px-5 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900 font-bold text-xs transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-house text-sm"></i> Selesai (Ke Beranda)
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

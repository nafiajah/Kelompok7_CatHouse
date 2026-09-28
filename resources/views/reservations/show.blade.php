@extends('layouts.app')

@section('title', 'Bukti Reservasi - Capyca Pet Cafe')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        
        <!-- Ticket Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-amber-100 overflow-hidden print:shadow-none print:border-none">
            
            <!-- Ticket Header -->
            <div class="bg-gradient-to-r from-amber-600 to-amber-500 p-8 text-white text-center relative">
                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md text-white text-2xl flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-cat"></i>
                </div>
                <span class="text-xs uppercase font-extrabold tracking-widest text-amber-200">Tiket Kunjungan Resmi</span>
                <h1 class="text-3xl font-bold font-playfair mt-1">Capyca Pet Cafe</h1>
                <p class="text-xs text-amber-100 mt-1">Kode Booking: <strong class="font-mono text-white text-sm">#CPY-{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</strong></p>

                <!-- Status Badge -->
                <div class="mt-4 inline-flex items-center gap-1.5 px-4 py-1 rounded-full bg-emerald-500/90 text-white text-xs font-bold shadow-sm">
                    <i class="fa-solid fa-circle-check"></i> Reservasi Dikonfirmasi
                </div>
            </div>

            <!-- Ticket Body -->
            <div class="p-8 space-y-6">
                
                <!-- Guest & Booking Info Grid -->
                <div class="grid grid-cols-2 gap-4 pb-6 border-b border-dashed border-amber-200 text-sm">
                    <div>
                        <span class="text-xs text-cafe-muted block">Nama Pemesan</span>
                        <span class="font-bold text-cafe-brown">{{ $reservation->user ? $reservation->user->nama_pelanggan : '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-cafe-muted block">Jumlah Tamu</span>
                        <span class="font-bold text-cafe-brown">{{ $reservation->payment ? $reservation->payment->jumlah_tamu : 1 }} Orang</span>
                    </div>
                    <div>
                        <span class="text-xs text-cafe-muted block">Tanggal Kunjungan</span>
                        <span class="font-bold text-cafe-brown">{{ \Carbon\Carbon::parse($reservation->tanggal_reservasi)->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-cafe-muted block">Sesi / Jam Kunjungan</span>
                        <span class="font-bold text-amber-700">
                            {{ $reservation->session ? $reservation->session->jam_sesi : $reservation->waktu_reservasi }}
                        </span>
                    </div>
                </div>

                <!-- Payment Details -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-cafe-brown mb-3">Rincian Pembayaran</h3>
                    <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-100 space-y-2 text-sm">
                        <div class="flex justify-between text-cafe-muted">
                            <span>Metode Pembayaran</span>
                            <span class="font-bold uppercase text-cafe-brown">{{ $reservation->payment ? $reservation->payment->metode_pembayaran : '-' }}</span>
                        </div>
                        <div class="flex justify-between text-cafe-muted">
                            <span>Waktu Transaksi</span>
                            <span class="font-medium text-cafe-brown">{{ $reservation->payment ? \Carbon\Carbon::parse($reservation->payment->tanggal_pembayaran)->format('d/m/Y H:i') : '-' }}</span>
                        </div>
                        <div class="border-t border-amber-200/60 pt-2 flex justify-between items-center">
                            <span class="font-bold text-cafe-brown">Total Biaya</span>
                            <span class="text-xl font-extrabold text-amber-700 font-playfair">
                                Rp {{ number_format($reservation->payment ? $reservation->payment->total_harga : 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Payment Instruction Mockup -->
                @if($reservation->payment && $reservation->payment->metode_pembayaran === 'qris')
                    <div class="text-center p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-500">Scan QRIS untuk Pembayaran</span>
                        <div class="w-44 h-44 mx-auto bg-white p-2 rounded-xl shadow-sm border border-slate-200 flex items-center justify-center">
                            <!-- Simulated QRIS image -->
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=CAPYCA-RESERVATION-{{ $reservation->id }}-{{ $reservation->payment->total_harga }}" alt="QRIS Code" class="w-full h-full">
                        </div>
                        <p class="text-xs text-slate-500">Mendukung GoPay, OVO, Dana, ShopeePay, BCA, dan seluruh Mobile Banking.</p>
                    </div>
                @else
                    <div class="p-5 rounded-2xl bg-blue-50 border border-blue-200 text-xs text-blue-950 space-y-2">
                        <p class="font-bold text-sm flex items-center gap-1.5"><i class="fa-solid fa-building-columns text-blue-600"></i> Rekening Bank Capyca Pet Cafe:</p>
                        <div class="bg-white p-3 rounded-xl border border-blue-100 flex justify-between items-center">
                            <div>
                                <span class="text-xs text-slate-500 block">Bank Central Asia (BCA)</span>
                                <span class="font-mono text-base font-bold text-slate-800">8820-1234-5678</span>
                                <span class="text-xs text-slate-500 block">a.n. Capyca Pet Cafe Indonesia</span>
                            </div>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">BCA</span>
                        </div>
                        <p class="text-[11px] text-slate-500 pt-1">Harap sertakan kode booking <strong>#CPY-{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</strong> pada berita transfer.</p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="pt-4 flex flex-col sm:flex-row gap-3 print:hidden">
                    <button onclick="window.print()" class="flex-1 py-3 px-4 rounded-xl bg-slate-900 hover:bg-black text-white font-bold text-xs transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-print"></i> Cetak / Simpan Tiket
                    </button>
                    <a href="{{ route('reservasi.history') }}" class="flex-1 py-3 px-4 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-900 font-bold text-xs transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Reservasi Saya
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Detail Tiket #' . str_pad($reservation->id, 5, '0', STR_PAD_LEFT) . ' - Cat House Admin')
@section('page_title', 'Detail Tiket & Reservasi')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    
    <!-- Top Action Bar (Hidden when printing) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-stone-300 shadow-md print:hidden">
        <a href="{{ route('admin.reservations.index') }}" class="px-4 py-2 bg-stone-100 text-stone-700 hover:bg-stone-200 rounded-xl text-xs font-bold transition flex items-center gap-2 w-fit">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Reservasi
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-[#2E2421] text-white hover:bg-stone-900 rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-print"></i> Cetak Bukti Tiket
            </button>
            <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Hapus data reservasi ini beserta pembayarannya?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-xl text-xs font-bold transition flex items-center gap-1.5" title="Hapus Reservasi">
                    <i class="fa-regular fa-trash-can"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Official Ticket Card -->
    <div class="bg-white rounded-3xl border border-stone-300 shadow-xl overflow-hidden print:shadow-none print:border-none print:m-0" id="printableTicket">
        
        <!-- Ticket Header Banner -->
        <div class="bg-gradient-to-r from-[#2E2421] to-[#3E2723] p-6 sm:p-8 text-white relative">
            <div class="flex flex-col sm:flex-row items-center sm:items-start justify-between gap-4 text-center sm:text-left">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md text-amber-200 text-2xl flex items-center justify-center flex-shrink-0 border border-white/20">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div>
                        <span class="text-[11px] uppercase font-extrabold tracking-widest text-[#E58B9C] block">Cat House Management &bull; Admin View</span>
                        <h2 class="text-2xl font-bold font-playfair tracking-wide mt-0.5">CAT HOUSE PET CAFE</h2>
                        <p class="text-xs text-stone-300 mt-1">Bukti Reservasi & Pembayaran Pelanggan</p>
                    </div>
                </div>
                
                <div class="text-center sm:text-right flex flex-col items-center sm:items-end">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-200 text-xs font-bold">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i> LUNAS & TERKONFIRMASI
                    </span>
                    <p class="text-xs text-stone-400 mt-2 font-mono">No. Bayar: #PAY-{{ str_pad($reservation->payment ? $reservation->payment->id : $reservation->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        <!-- Ticket Body Details -->
        <div class="p-6 sm:p-8 space-y-6">
            
            <!-- Booking & Customer Identification -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 p-4 rounded-2xl bg-[#F8F6E8]/70 border border-amber-200/60 text-xs">
                <div>
                    <span class="text-stone-400 uppercase tracking-wider font-semibold block text-[10px]">Kode Reservasi</span>
                    <span class="font-mono font-bold text-base text-[#96384C]">#CAT-{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div>
                    <span class="text-stone-400 uppercase tracking-wider font-semibold block text-[10px]">Waktu Pemesanan</span>
                    <span class="font-bold text-stone-800">
                        {{ $reservation->payment ? \Carbon\Carbon::parse($reservation->payment->tanggal_pembayaran)->translatedFormat('d M Y, H:i') : now()->translatedFormat('d M Y, H:i') }} WIB
                    </span>
                </div>
                <div>
                    <span class="text-stone-400 uppercase tracking-wider font-semibold block text-[10px]">Nama Pelanggan</span>
                    <span class="font-bold text-stone-800 text-sm block">{{ $reservation->user ? $reservation->user->nama_lengkap : 'Tamu' }}</span>
                    <span class="text-stone-500 text-[11px]">{{ $reservation->user ? $reservation->user->email : '-' }}</span>
                </div>
                <div>
                    <span class="text-stone-400 uppercase tracking-wider font-semibold block text-[10px]">Kontak WhatsApp/HP</span>
                    <span class="font-bold text-stone-800 block">{{ $reservation->user ? $reservation->user->no_telp : '-' }}</span>
                    <span class="text-stone-400 text-[11px]">Role: {{ $reservation->user ? ucfirst($reservation->user->role) : 'Guest' }}</span>
                </div>
            </div>

            <!-- Schedule Highlight -->
            <div class="p-4 sm:p-5 rounded-2xl bg-teal-50/60 border border-teal-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center text-lg flex-shrink-0">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold text-teal-900 uppercase tracking-wider block">Jadwal Sesi Kunjungan:</span>
                        <p class="text-sm sm:text-base font-bold text-stone-800 mt-0.5">
                            {{ \Carbon\Carbon::parse($reservation->tanggal_reservasi)->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <span class="px-3.5 py-1.5 rounded-xl bg-teal-600 text-white font-bold text-xs inline-block shadow-2xs">
                        Sesi: {{ $reservation->session ? $reservation->session->jam_sesi : $reservation->waktu_reservasi }} (90 Menit)
                    </span>
                    <p class="text-[11px] text-teal-800 font-semibold mt-1">Kuota Sesi: {{ $reservation->session ? $reservation->session->token_sesi : 15 }} Orang</p>
                </div>
            </div>

            <!-- Payment Breakdown Table -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-3">Rincian Pembayaran & Biaya</h3>
                <div class="rounded-2xl border border-stone-200 overflow-hidden text-xs">
                    <div class="bg-stone-50 p-3.5 flex justify-between font-bold text-stone-700 border-b border-stone-200">
                        <span>Deskripsi / Item</span>
                        <span>Jumlah Biaya</span>
                    </div>
                    <div class="p-4 space-y-2.5 bg-white text-stone-600">
                        <div class="flex justify-between items-center">
                            <span>Tiket Kunjungan Cat House ({{ $reservation->payment ? $reservation->payment->jumlah_tamu : 1 }} Tamu x Rp 35.000)</span>
                            <span class="font-bold text-stone-800">Rp {{ number_format($reservation->payment ? $reservation->payment->total_harga : 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Fasilitas: Free Welcome Drink & Cat Play Toys</span>
                            <span class="font-semibold text-emerald-600">Termasuk (Gratis)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Metode Pembayaran</span>
                            <span class="font-bold uppercase text-stone-800 px-2.5 py-0.5 rounded-lg bg-stone-100">
                                {{ $reservation->payment ? $reservation->payment->metode_pembayaran : '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Status Verifikasi Pembayaran</span>
                            <span class="font-bold text-emerald-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Berhasil Divalidasi
                            </span>
                        </div>
                    </div>
                    <div class="p-4 bg-emerald-50/50 border-t border-stone-200 flex justify-between items-center text-sm">
                        <span class="font-bold text-stone-800">Total Pembayaran Diterima:</span>
                        <span class="text-2xl font-extrabold text-emerald-700 font-playfair">
                            Rp {{ number_format($reservation->payment ? $reservation->payment->total_harga : 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Validation Stamp Footer -->
            <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 text-center space-y-1 text-xs text-stone-500">
                <p class="font-bold text-stone-700 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-stamp text-emerald-600 text-sm"></i> Sah Diterbitkan & Terdata di Sistem Informasi Cat House
                </p>
                <p class="text-[11px] text-stone-400">Bukti tiket ini dapat dicetak dan digunakan oleh staf kasir / resepsionis saat verifikasi kehadiran tamu.</p>
            </div>

        </div>
    </div>

</div>
@endsection

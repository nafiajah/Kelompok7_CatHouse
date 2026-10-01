@extends('layouts.admin')

@section('title', 'Dashboard - Admin Cat House')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="space-y-6 sm:space-y-8">
    
    <!-- Top Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Total Kucing -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-stone-200 shadow-sm flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-stone-400 truncate">Total Kucing</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-stone-800 mt-1 truncate">{{ $totalCats }}</h3>
                <span class="text-xs text-rose-500 font-semibold truncate block">{{ $totalVariants }} Ras Varian</span>
            </div>
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-rose-50 text-rose-400 flex items-center justify-center text-lg sm:text-xl flex-shrink-0">
                <i class="fa-solid fa-cat"></i>
            </div>
        </div>

        <!-- Total Reservasi -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-stone-200 shadow-sm flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-stone-400 truncate">Total Reservasi</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-stone-800 mt-1 truncate">{{ $totalReservations }}</h3>
                <span class="text-xs text-teal-600 font-semibold truncate block">Tamu Terjadwal</span>
            </div>
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg sm:text-xl flex-shrink-0">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-stone-200 shadow-sm flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-stone-400 truncate">Total Pemasukan</p>
                <h3 class="text-xl sm:text-2xl font-extrabold text-stone-800 mt-1 truncate">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <span class="text-xs text-rose-500 font-semibold truncate block">Dari Tiket Sesi</span>
            </div>
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-rose-50 text-rose-400 flex items-center justify-center text-lg sm:text-xl flex-shrink-0">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
        </div>

        <!-- Pending Moderasi Feedback -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-stone-200 shadow-sm flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-stone-400 truncate">Feedback Pending</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-stone-800 mt-1 truncate">{{ $pendingFeedbacks }}</h3>
                <span class="text-xs text-pink-500 font-semibold truncate block">Perlu Moderasi</span>
            </div>
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-pink-50 text-pink-400 flex items-center justify-center text-lg sm:text-xl flex-shrink-0">
                <i class="fa-solid fa-comments"></i>
            </div>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        
        <!-- Recent Reservations -->
        <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 sm:p-6 border-b border-stone-100 flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <h3 class="text-base font-bold text-stone-800 truncate">Reservasi Terbaru</h3>
                    <p class="text-xs text-stone-400 truncate">Daftar booking terbaru oleh pengunjung</p>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="text-xs font-bold text-rose-500 hover:text-rose-600 flex-shrink-0 whitespace-nowrap">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="divide-y divide-stone-100 flex-1">
                @forelse($recentReservations as $res)
                    <div class="p-3.5 sm:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 text-xs hover:bg-stone-50 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-800 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                {{ strtoupper(substr($res->user ? $res->user->nama_pelanggan : 'T', 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-stone-800 text-sm truncate">{{ $res->user ? $res->user->nama_pelanggan : '-' }}</p>
                                <p class="text-stone-400 text-xs">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d M Y') }} &bull; {{ $res->session ? $res->session->jam_sesi : $res->waktu_reservasi }}</p>
                            </div>
                        </div>
                        <div class="sm:text-right flex sm:flex-col justify-between items-center sm:items-end border-t sm:border-t-0 pt-2 sm:pt-0 border-stone-100 flex-shrink-0">
                            <span class="font-bold text-stone-800 text-sm block">Rp {{ number_format($res->payment ? $res->payment->total_harga : 0, 0, ',', '.') }}</span>
                            <span class="text-[10px] uppercase font-bold text-stone-400">{{ $res->payment ? $res->payment->metode_pembayaran : '-' }} ({{ $res->payment ? $res->payment->jumlah_tamu : 1 }} Tamu)</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-stone-400 text-xs">
                        Belum ada data reservasi.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Feedbacks -->
        <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 sm:p-6 border-b border-stone-100 flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <h3 class="text-base font-bold text-stone-800 truncate">Ulasan & Feedback Terbaru</h3>
                    <p class="text-xs text-stone-400 truncate">Review rating bintang dari pelanggan</p>
                </div>
                <a href="{{ route('admin.feedbacks.index') }}" class="text-xs font-bold text-rose-500 hover:text-rose-600 flex-shrink-0 whitespace-nowrap">
                    Kelola Feedback &rarr;
                </a>
            </div>

            <div class="divide-y divide-stone-100 flex-1">
                @forelse($recentFeedbacks as $fb)
                    <div class="p-3.5 sm:p-4 text-xs space-y-1.5 hover:bg-stone-50 transition">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-bold text-stone-800 truncate">{{ $fb->user ? $fb->user->nama_pelanggan : 'Anonim' }}</span>
                            <div class="flex text-amber-400 text-[11px] flex-shrink-0">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $fb->bintang ? 'text-amber-400' : 'text-stone-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-stone-600 line-clamp-2 italic">"{{ $fb->teks_saran }}"</p>
                        <div class="flex flex-wrap items-center justify-between gap-2 pt-1 text-[10px] text-stone-400">
                            <span>{{ \Carbon\Carbon::parse($fb->tanggal_saran)->diffForHumans() }}</span>
                            @if($fb->status_tampil === 'tampil')
                                <span class="text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">Tampil di Beranda</span>
                            @else
                                <span class="text-rose-700 font-bold bg-rose-50 px-2 py-0.5 rounded-full">Menunggu Moderasi</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-stone-400 text-xs">
                        Belum ada ulasan feedback.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection

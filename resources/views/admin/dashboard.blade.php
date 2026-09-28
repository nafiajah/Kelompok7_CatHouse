@extends('layouts.admin')

@section('title', 'Dashboard - Admin Capyca')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    
    <!-- Top Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Kucing -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Kucing</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalCats }}</h3>
                <span class="text-xs text-amber-600 font-semibold">{{ $totalVariants }} Ras Varian</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-cat"></i>
            </div>
        </div>

        <!-- Total Reservasi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Reservasi</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalReservations }}</h3>
                <span class="text-xs text-blue-600 font-semibold">Tamu Terjadwal</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pemasukan</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <span class="text-xs text-emerald-600 font-semibold">Dari Pembayaran Tiket</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
        </div>

        <!-- Pending Moderasi Feedback -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Feedback Pending</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $pendingFeedbacks }}</h3>
                <span class="text-xs text-purple-600 font-semibold">Perlu Moderasi</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-comments"></i>
            </div>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Reservations -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Reservasi Terbaru</h3>
                    <p class="text-xs text-slate-400">Daftar booking terbaru oleh pengunjung</p>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="divide-y divide-slate-100 flex-1">
                @forelse($recentReservations as $res)
                    <div class="p-4 flex items-center justify-between text-xs hover:bg-slate-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-800 font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($res->user ? $res->user->nama_pelanggan : 'T', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">{{ $res->user ? $res->user->nama_pelanggan : '-' }}</p>
                                <p class="text-slate-400">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d M Y') }} • {{ $res->session ? $res->session->jam_sesi : $res->waktu_reservasi }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-slate-800 text-sm block">Rp {{ number_format($res->payment ? $res->payment->total_harga : 0, 0, ',', '.') }}</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400">{{ $res->payment ? $res->payment->metode_pembayaran : '-' }} ({{ $res->payment ? $res->payment->jumlah_tamu : 1 }} Tamu)</span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs">
                        Belum ada data reservasi.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Feedbacks -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Ulasan & Feedback Terbaru</h3>
                    <p class="text-xs text-slate-400">Review rating bintang dari pelanggan</p>
                </div>
                <a href="{{ route('admin.feedbacks.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700">
                    Kelola Feedback &rarr;
                </a>
            </div>

            <div class="divide-y divide-slate-100 flex-1">
                @forelse($recentFeedbacks as $fb)
                    <div class="p-4 text-xs space-y-1.5 hover:bg-slate-50 transition">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-800">{{ $fb->user ? $fb->user->nama_pelanggan : 'Anonim' }}</span>
                            <div class="flex text-amber-400 text-[11px]">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $fb->bintang ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-slate-600 line-clamp-2 italic">"{{ $fb->teks_saran }}"</p>
                        <div class="flex items-center justify-between pt-1 text-[10px] text-slate-400">
                            <span>{{ \Carbon\Carbon::parse($fb->tanggal_saran)->diffForHumans() }}</span>
                            @if($fb->status_tampil === 'tampil')
                                <span class="text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">Tampil di Beranda</span>
                            @else
                                <span class="text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded-full">Menunggu Moderasi</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs">
                        Belum ada ulasan feedback.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection

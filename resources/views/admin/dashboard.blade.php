@extends('layouts.admin')

@section('title', 'Dashboard - Admin Cat House')
@section('page_title', 'Dashboard')

@section('styles')
<style>
    .dashboard-scroll {
        scrollbar-width: thin;
        scrollbar-color: #D6CBC5 transparent;
    }
    .dashboard-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .dashboard-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .dashboard-scroll::-webkit-scrollbar-thumb {
        background-color: #D6CBC5;
        border-radius: 9999px;
    }
    .dashboard-scroll::-webkit-scrollbar-thumb:hover {
        background-color: #B8ABA4;
    }
</style>
@endsection

@section('content')
<div class="space-y-6">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <div class="bg-white px-5 py-5 rounded-2xl border border-stone-300 shadow-[0_2px_8px_rgba(63,50,42,0.06)] flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wide text-[#6E5C52] truncate">TOTAL KUCING</p>
                <h3 class="text-2xl sm:text-[28px] font-bold text-[#3F322A] mt-2 leading-none truncate">{{ $totalCats }}</h3>
            </div>
            <div class="w-11 h-11 rounded-xl bg-[#F9CCD6] text-[#E28397] flex items-center justify-center flex-shrink-0">

                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M5.5 4.5L9.2 8.2C10.05 7.9 11 7.75 12 7.75s1.95.15 2.8.45l3.7-3.7c.4-.4 1.1-.15 1.1.42V13c0 4.14-3.36 7.5-7.6 7.5S4.4 17.14 4.4 13V4.92c0-.57.7-.82 1.1-.42zM9.25 13a1.15 1.15 0 100 2.3 1.15 1.15 0 000-2.3zm5.5 0a1.15 1.15 0 100 2.3 1.15 1.15 0 000-2.3zM12 16.75l-1.1-.95h2.2L12 16.75z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white px-5 py-5 rounded-2xl border border-stone-300 shadow-[0_2px_8px_rgba(63,50,42,0.06)] flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wide text-[#6E5C52] truncate">TOTAL RESERVASI</p>
                <h3 class="text-2xl sm:text-[28px] font-bold text-[#3F322A] mt-2 leading-none truncate">{{ $totalReservations }}</h3>
            </div>
            <div class="w-11 h-11 rounded-xl bg-[#B7CDD0] text-[#63898E] flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
        </div>

        <div class="bg-white px-5 py-5 rounded-2xl border border-stone-300 shadow-[0_2px_8px_rgba(63,50,42,0.06)] flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wide text-[#6E5C52] truncate">TOTAL PEMASUKAN</p>
                <h3 class="text-xl sm:text-2xl font-bold text-[#3F322A] mt-2 leading-none truncate">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </h3>
            </div>
            <div class="w-11 h-11 rounded-xl bg-[#F9CCD6] text-[#E28397] flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-money-bill-wave text-lg"></i>
            </div>
        </div>

        <div class="bg-white px-5 py-5 rounded-2xl border border-stone-300 shadow-[0_2px_8px_rgba(63,50,42,0.06)] flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wide text-[#6E5C52] truncate">FEEDBACK</p>
                <h3 class="text-2xl sm:text-[28px] font-bold text-[#3F322A] mt-2 leading-none truncate">{{ $totalFeedbacks }}</h3>
            </div>
            <div class="w-11 h-11 rounded-xl bg-[#B7CDD0] text-[#63898E] flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-comments text-xl"></i>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl border border-stone-300 shadow-[0_2px_8px_rgba(63,50,42,0.06)] overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-stone-300 flex items-center justify-between gap-2 flex-shrink-0">
                <div class="min-w-0">
                    <h3 class="text-base font-bold text-[#3F322A] truncate">Reservasi Terbaru</h3>
                    <p class="text-[11px] text-stone-500 truncate mt-0.5">Daftar booking terbaru oleh pengunjung</p>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#E58B9C] hover:text-[#D77487] transition flex-shrink-0 whitespace-nowrap">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>

            <div class="max-h-[430px] overflow-y-auto dashboard-scroll divide-y divide-stone-200 px-5">
                @forelse($recentReservations as $res)
                    @php
$namaUser = $res->user ? $res->user->nama_lengkap : 'Tamu';
                        $inisial = strtoupper(substr($namaUser, 0, 1));
                        $tglLabel = \Carbon\Carbon::parse($res->tanggal_reservasi)->locale('id')->translatedFormat('d M Y');
                        $jamLabel = $res->session ? $res->session->jam_sesi : substr((string) $res->waktu_reservasi, 0, 5);
                        $isConfirmed = ($res->status_konfirmasi ?? 'belum') === 'sudah';
@endphp
                    <div class="py-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-11 h-11 rounded-full bg-[#F4C4CF] text-[#3F322A] font-bold flex items-center justify-center text-lg flex-shrink-0">
                                {{ $inisial }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-[#3F322A] truncate">{{ $namaUser }}</p>
                                <p class="text-[11px] text-stone-500 mt-0.5 truncate">{{ $tglLabel }} &middot; {{ $jamLabel }}</p>
                            </div>
                        </div>

                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-bold text-[#3F322A]">
                                Rp {{ number_format($res->total_harga ?? 0, 0, ',', '.') }}
                            </p>
                            <span class="mt-1 inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $isConfirmed ? 'bg-[#F4C4CF] text-[#3F322A]' : 'bg-stone-200 text-stone-600' }}">
                                {{ $isConfirmed ? 'SUDAH' : 'BELUM' }} ({{ $res->jumlah_tamu ?? 1 }} TAMU)
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-stone-400 text-xs">
                        Belum ada data reservasi.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-stone-300 shadow-[0_2px_8px_rgba(63,50,42,0.06)] overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-stone-300 flex items-center justify-between gap-2 flex-shrink-0">
                <div class="min-w-0">
                    <h3 class="text-base font-bold text-[#3F322A] truncate">Feedback</h3>
                    <p class="text-[11px] text-stone-500 truncate mt-0.5">Review rating bintang dari pelanggan</p>
                </div>
                <a href="{{ route('admin.feedbacks.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#E58B9C] hover:text-[#D77487] transition flex-shrink-0 whitespace-nowrap">
                    <span>Kelola Feedback</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>

            <div class="max-h-[430px] overflow-y-auto dashboard-scroll divide-y divide-stone-200 px-5">
                @forelse($recentFeedbacks as $fb)
                    <div class="py-4 flex items-start justify-between gap-4">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-[#3F322A] truncate">
                                {{ $fb->user ? $fb->user->nama_lengkap : 'Anonim' }}
                            </p>
                            <p class="text-xs text-stone-600 italic mt-0.5 line-clamp-2">
                                "{{ $fb->teks_saran }}"
                            </p>
                            <p class="text-[11px] text-stone-400 mt-2">
                                {{ \Carbon\Carbon::parse($fb->tanggal_saran)->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex flex-col items-end justify-between gap-3 flex-shrink-0">
                            <div class="flex items-center gap-0.5 text-sm text-[#FCE14B]">
                                @for($i = 1; $i <= ($fb->bintang ?? 5); $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>

                            @if($fb->status_tampil === 'tampil')
                                <span class="px-3 py-1 rounded-full bg-[#F4C4CF] text-[#3F322A] text-[10px] font-semibold whitespace-nowrap">
                                    Tampil di Beranda
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-[#9AB5B9] text-[#2E221E] text-[10px] font-semibold whitespace-nowrap">
                                    Tidak Tampil
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-stone-400 text-xs">
                        Belum ada ulasan feedback.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection

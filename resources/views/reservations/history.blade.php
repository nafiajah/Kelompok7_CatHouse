@extends('layouts.app')

@section('title', 'Riwayat Reservasi Saya - Cat House')

@section('content')
<section class="bg-white py-12 sm:py-16">
    <div class="max-w-5xl mx-auto px-5 sm:px-8">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <h1 class="font-literata text-3xl sm:text-[36px] font-normal text-[#1F1815] leading-tight tracking-tight">
                    Riwayat Reservasi Saya
                </h1>
                <p class="text-xs sm:text-sm text-[#3F322A]/85 mt-1.5">
                    Daftar seluruh kunjungan yang pernah anda pesan
                </p>
            </div>

            <a
                href="{{ route('reservasi.create') }}"
                class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 bg-[#3F322A] hover:bg-[#2E221E] text-white text-xs font-medium rounded-lg shadow-xs transition self-start sm:self-auto shrink-0"
            >
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Reservasi Baru</span>
            </a>
        </div>

        <div class="bg-white rounded-[18px] border border-[#C8C0BC] shadow-[0_6px_18px_rgba(63,50,42,0.12)] overflow-hidden">
            @if(count($reservations) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-[#FFDAE1] border-b border-[#C8C0BC] text-xs font-semibold uppercase tracking-wide text-[#2E221E]">
                                <th class="py-4 px-6 text-center whitespace-nowrap">Kode Booking</th>
                                <th class="py-4 pl-6 sm:pl-10 pr-6 text-left whitespace-nowrap">Tanggal &amp; Sesi</th>
                                <th class="py-4 px-6 text-center whitespace-nowrap">Tamu</th>
                                <th class="py-4 px-6 text-center whitespace-nowrap">Total Harga</th>
                                <th class="py-4 px-6 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#D6CFCB] bg-white">
                            @foreach($reservations as $item)
                                @php
                                    $jamSesiDisplay = $item->session
                                        ? preg_replace('/\s*-\s*/', '-', trim($item->session->jam_sesi))
                                        : substr((string) $item->waktu_reservasi, 0, 5);
                                @endphp
                                <tr class="hover:bg-[#FFF7F9] transition-colors">
                                    <td class="py-5 sm:py-6 px-6 text-center text-xs sm:text-sm text-[#2E221E] whitespace-nowrap">
                                        #CPY-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="py-5 sm:py-6 pl-6 sm:pl-10 pr-6 text-left whitespace-nowrap">
                                        <p class="font-bold text-sm text-[#2E221E] leading-snug">
                                            {{ \Carbon\Carbon::parse($item->tanggal_reservasi)->locale('id')->translatedFormat('d M Y') }}
                                        </p>
                                        <p class="text-xs text-[#3F322A]/90 mt-1">
                                            {{ $jamSesiDisplay }}
                                        </p>
                                    </td>
                                    <td class="py-5 sm:py-6 px-6 text-center text-xs sm:text-sm text-[#2E221E] whitespace-nowrap">
                                        {{ $item->jumlah_tamu ?? 1 }} Orang
                                    </td>
                                    <td class="py-5 sm:py-6 px-6 text-center text-xs sm:text-sm text-[#2E221E] whitespace-nowrap">
                                        Rp. {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="py-5 sm:py-6 px-6 text-center whitespace-nowrap">
                                        <a
                                            href="{{ route('reservasi.show', $item->id) }}"
                                            class="inline-flex items-center justify-center gap-2 px-3.5 py-1.5 rounded-md bg-[#3F322A] hover:bg-[#2E221E] text-white text-xs font-medium shadow-2xs transition"
                                        >
                                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
                                                <path d="M13 5v2"/>
                                                <path d="M13 17v2"/>
                                                <path d="M13 11v2"/>
                                            </svg>
                                            <span>Lihat Tiket</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-16 px-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-[#FFF0F3] text-[#E58B9C] flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#3F322A]">Belum Ada Riwayat Reservasi</h3>
                    <p class="text-xs sm:text-sm text-[#5C4D44] mt-1.5 mb-6">
                        Anda belum pernah memesan sesi kunjungan di Cat House.
                    </p>
                    <a
                        href="{{ route('reservasi.create') }}"
                        class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-[#3F322A] hover:bg-[#2E221E] text-white font-medium text-xs rounded-lg shadow-xs transition"
                    >
                        <i class="fa-solid fa-plus text-[10px]"></i>
                        <span>Buat Reservasi Pertama Anda</span>
                    </a>
                </div>
            @endif
        </div>

    </div>
</section>
@endsection

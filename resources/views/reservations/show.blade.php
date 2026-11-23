@extends('layouts.app')

@section('title', 'Bukti Reservasi - Cat House')

@section('styles')
<style>
    @media print {
        header, footer, .print\:hidden {
            display: none !important;
        }
        body {
            background: #FFFFFF !important;
        }
        #printableReceipt {
            box-shadow: none !important;
            border: 1px solid #D6D3D1 !important;
            margin: 0 auto !important;
        }
    }
</style>
@endsection

@section('content')
@php
    $kodeReservasi = '#CPY-' . str_pad($reservation->id, 5, '0', STR_PAD_LEFT);
    $namaPelanggan = $reservation->user ? $reservation->user->nama_lengkap : 'Tamu Cat House';
    $jumlahPengunjung = $reservation->jumlah_tamu ?? 1;
    $tanggalFormatted = \Carbon\Carbon::parse($reservation->tanggal_reservasi)
        ->locale('id')
        ->translatedFormat('l, d F Y');
    $jamSesiDisplay = $reservation->session
        ? preg_replace('/\s*-\s*/', '-', trim($reservation->session->jam_sesi))
        : substr((string) $reservation->waktu_reservasi, 0, 5);
    $hargaSatuanDisplay = $hargaSatuan ?? 25000;
@endphp

<section class="bg-white py-8 sm:py-12">
    <div class="max-w-[640px] mx-auto px-4 sm:px-6">

        <!-- Top Status Notification Pill -->
        <div class="mb-6 px-4 py-2.5 rounded-xl bg-[#FDF1F3] border border-[#E5B6C0] flex items-center gap-3 print:hidden">
            <span class="w-6 h-6 rounded-full bg-[#E5B6C0] flex items-center justify-center shrink-0">
                <span class="w-2.5 h-2.5 rounded-full bg-white"></span>
            </span>
            <p class="text-xs sm:text-[13px] text-[#4A3D36]">
                Data reservasi telah masuk ke sistem dan tercatat di database Cat House
            </p>
        </div>

        <!-- Main Reservation Receipt Card -->
        <div
            id="printableReceipt"
            class="bg-white rounded-2xl border border-stone-200/90 shadow-[0_8px_28px_rgba(63,50,42,0.10)] overflow-hidden"
        >
            <!-- Sage/Teal Gradient Header -->
            <div class="bg-gradient-to-r from-[#BACFD1] via-[#98B7BA] to-[#7BA1A5] px-6 py-9 sm:py-10 text-center text-white">
                <p class="text-sm sm:text-[15px] font-normal text-white/95 tracking-normal">
                    Bukti reservasi resmi
                </p>
                <h1 class="font-literata text-4xl sm:text-[44px] font-bold tracking-tight mt-1 text-white leading-tight">
                    Cat House
                </h1>
                <div class="mt-4 inline-flex items-center gap-2 px-4 py-1 rounded-full bg-white text-[#5B7A7D] text-[11px] font-semibold shadow-2xs">
                    <span class="w-3.5 h-3.5 rounded-full border-[2.5px] border-[#9BB9BC] bg-white inline-block"></span>
                    <span>Reservasi Terkonfirmasi</span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- 2x2 Reservation Info Grid -->
                <div class="grid grid-cols-2 gap-x-6 sm:gap-x-10 gap-y-5 pb-6 border-b border-stone-200/80">
                    <div>
                        <p class="text-xs sm:text-[13px] text-stone-400">Kode reservasi</p>
                        <p class="mt-1 text-sm sm:text-[15px] font-medium text-[#D98497]">{{ $kodeReservasi }}</p>
                    </div>
                    <div>
                        <p class="text-xs sm:text-[13px] text-stone-400">Jumlah Pengunjung</p>
                        <p class="mt-1 text-sm sm:text-[15px] font-medium text-[#D98497]">{{ $jumlahPengunjung }} Orang</p>
                    </div>
                    <div>
                        <p class="text-xs sm:text-[13px] text-stone-400">Nama Pelanggan</p>
                        <p class="mt-1 text-sm sm:text-[15px] font-medium text-[#D98497]">{{ $namaPelanggan }}</p>
                    </div>
                    <div>
                        <p class="text-xs sm:text-[13px] text-stone-400">Jumlah Sesi</p>
                        <p class="mt-1 text-sm sm:text-[15px] font-medium text-[#D98497]">1 sesi</p>
                    </div>
                </div>

                <!-- Jadwal Sesi Kunjungan Box -->
                <div class="rounded-xl bg-[#DCE8E9] border border-[#9EB8BB] px-5 py-4 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm sm:text-[15px] font-medium text-[#2E221E]">
                            Jadwal Sesi Kunjungan
                        </p>
                        <p class="mt-1 text-sm font-semibold text-[#5A8388]">
                            {{ $tanggalFormatted }}
                        </p>
                        <p class="mt-1 text-xs sm:text-[13px] text-[#3F322A] flex items-center gap-1.5">
                            <i class="fa-solid fa-clock text-[#2E221E] text-xs"></i>
                            <span>{{ $jamSesiDisplay }}</span>
                        </p>
                    </div>

                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[#7C9A9D] text-[11px] font-medium shadow-2xs shrink-0">
                        <span class="w-3 h-3 rounded-full border-[2px] border-[#A7C2C5] bg-white inline-block"></span>
                        <span>Terkonfirmasi</span>
                    </span>
                </div>

                <!-- Rincian Harga -->
                <div class="pt-1 border-t border-stone-200/80">
                    <p class="text-xs sm:text-[13px] text-stone-400 mb-3 mt-4">Rincian Harga</p>

                    <div class="rounded-xl border border-[#B5C6C8] overflow-hidden shadow-[0_2px_6px_rgba(0,0,0,0.04)]">
                        <!-- Table Header -->
                        <div class="bg-[#BDD0D2] px-4 py-3 grid grid-cols-12 text-xs sm:text-sm font-medium text-[#2E221E]">
                            <span class="col-span-5">Keterangan</span>
                            <span class="col-span-4 text-center">Harga Satuan</span>
                            <span class="col-span-3 text-right">Total</span>
                        </div>

                        <!-- Item Row -->
                        <div class="bg-white px-4 py-3.5 grid grid-cols-12 items-center text-xs sm:text-sm text-[#D98497] border-b border-stone-200/80">
                            <span class="col-span-5">Tiket Reservasi {{ $jumlahPengunjung }}x</span>
                            <span class="col-span-4 text-center">Rp. {{ number_format($hargaSatuanDisplay, 0, ',', '.') }}</span>
                            <span class="col-span-3 text-right">Rp. {{ number_format($reservation->total_harga ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <!-- Payment Method Row -->
                        <div class="bg-white px-4 py-3.5">
                            <p class="text-xs text-stone-400">Metode Pembayaran:</p>
                            <p class="text-xs sm:text-sm text-[#D98497] mt-0.5">Di Tempat</p>
                        </div>
                    </div>
                </div>

                <!-- S&K Reminder Box -->
                <div class="rounded-xl bg-[#DCE8E9] border border-[#9EB8BB] px-5 py-4 text-center space-y-1">
                    <p class="text-xs sm:text-sm text-[#8F9D9E]">
                        Pastikan anda benar-benar telah membaca S&amp;K yang berlaku
                    </p>
                    <p class="text-xs sm:text-sm font-medium text-[#2E221E]">
                        Tunjukkan bukti reservasi ini kepada staff yang bertugas
                    </p>
                </div>

                <!-- Bottom 3 Action Buttons -->
                <div class="pt-3 pb-2 grid grid-cols-1 sm:grid-cols-3 gap-4 print:hidden">
                    <button
                        type="button"
                        onclick="window.print()"
                        class="flex items-center justify-center gap-3 px-4 py-3 rounded-xl bg-[#B0C7C9] hover:bg-[#9BB6B9] text-white transition cursor-pointer shadow-2xs"
                    >
                        <i class="fa-solid fa-print text-lg shrink-0"></i>
                        <span class="text-left text-xs sm:text-[13px] font-medium leading-tight">
                            Cetak atau<br>Simpan PDF
                        </span>
                    </button>

                    <a
                        href="{{ route('reservasi.create') }}"
                        class="flex items-center justify-center gap-3 px-4 py-3 rounded-xl bg-[#6D5E56] hover:bg-[#5A4C45] text-white transition shadow-2xs"
                    >
                        <i class="fa-solid fa-calendar-check text-lg shrink-0"></i>
                        <span class="text-left text-xs sm:text-[13px] font-medium leading-tight">
                            Tambah<br>Reservasi
                        </span>
                    </a>

                    <a
                        href="{{ route('home') }}"
                        class="flex items-center justify-center gap-3 px-4 py-3 rounded-xl bg-[#F3B7C3] hover:bg-[#E79FAE] text-white transition shadow-2xs"
                    >
                        <i class="fa-solid fa-house text-lg shrink-0"></i>
                        <span class="text-left text-xs sm:text-[13px] font-medium leading-tight">
                            Kembali ke<br>Beranda
                        </span>
                    </a>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection

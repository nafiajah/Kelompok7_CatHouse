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
                <span class="w-4 h-4 rounded-full bg-white flex items-center justify-center">
                    <i class="fa-solid fa-check text-[9px] text-[#E5B6C0]"></i>
                </span>
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
                    <span class="w-4 h-4 rounded-full border-[2px] border-[#9BB9BC] bg-white inline-flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-[8px] text-[#9BB9BC]"></i>
                    </span>
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
                        <span class="w-4 h-4 rounded-full border-[2px] border-[#A7C2C5] bg-white inline-flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check text-[8px] text-[#A7C2C5]"></i>
                        </span>
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
                        Pastikan anda benar-benar telah membaca
                        <button
                            type="button"
                            id="snkTrigger"
                            class="underline decoration-dotted underline-offset-4 font-semibold text-[#5A8388] hover:text-[#2E221E] transition cursor-pointer"
                        >S&amp;K yang berlaku</button>
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

<!-- Pop-out Modal Syarat & Ketentuan -->
<div
    id="snkModal"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/45 backdrop-blur-[2px] opacity-0 pointer-events-none transition-all duration-200 print:hidden"
    role="dialog"
    aria-modal="true"
    aria-labelledby="snkModalTitle"
>
    <div
        id="snkModalCard"
        class="relative w-full max-w-md bg-[#A9C4C7] border border-[#5E7F83] rounded-[22px] shadow-2xl p-6 sm:p-7 text-[#2E221E] transform scale-95 transition-all duration-200"
    >
        <!-- Close (X) Button -->
        <button
            type="button"
            id="snkCloseBtn"
            aria-label="Tutup Syarat dan Ketentuan"
            class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-white/75 hover:bg-white text-[#3F322A] flex items-center justify-center shadow-2xs transition cursor-pointer"
        >
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>

        <div class="flex items-center justify-center gap-2 pb-3 border-b border-[#3F322A]/45 pr-6">
            <i class="fa-solid fa-shield-halved text-[#5C4D44] text-base"></i>
            <h3 id="snkModalTitle" class="text-sm sm:text-base font-semibold text-[#2E221E]">
                Syarat dan ketentuan
            </h3>
        </div>

        <ul class="mt-4 pl-5 list-disc space-y-2.5 text-xs sm:text-sm leading-relaxed text-[#2E221E]">
            <li>Harap datang 15 menit lebih awal dari jadwal sesi Anda, keterlambatan dapat mengurangi durasi sesi Anda.</li>
            <li>Tidak dapat dijadwalkan ulang (reschedule).</li>
            <li>Reservasi yang dibatalkan tanpa konfirmasi akan dikenai denda.</li>
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function () {
        const trigger = document.getElementById('snkTrigger');
        const modal = document.getElementById('snkModal');
        const card = document.getElementById('snkModalCard');
        const closeBtn = document.getElementById('snkCloseBtn');

        if (!trigger || !modal || !card || !closeBtn) return;

        function openSnkModal() {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeSnkModal() {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }

        // Muncul hanya saat teks S&K yang berlaku diklik
        trigger.addEventListener('click', openSnkModal);

        // Tutup lewat tombol X
        closeBtn.addEventListener('click', closeSnkModal);

        // Tutup jika klik area backdrop di luar kartu
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeSnkModal();
            }
        });

        // Tutup dengan tombol Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('opacity-100')) {
                closeSnkModal();
            }
        });
    })();
</script>
@endsection

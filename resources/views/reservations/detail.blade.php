@extends('layouts.app')

@section('title', 'Detail Reservasi - Cat House')

@section('content')
<section class="bg-white py-10 sm:py-12">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm">
                <p class="font-semibold mb-1"><i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Mohon periksa kembali data reservasi Anda:</p>
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reservasi.store') }}" method="POST" id="reservationDetailForm">
            @csrf
            <input type="hidden" name="tanggal_reservasi" value="{{ $selectedDate }}">
            <input type="hidden" name="id_sesi" value="{{ $session->id }}">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 lg:gap-8 items-stretch">

                <!-- ===================================================
                     LEFT COLUMN: DETAIL RESERVASI FORM CARD
                     =================================================== -->
                <div class="lg:col-span-7 flex flex-col bg-[#FDF1F3] border border-[#8C7E76] rounded-[20px] shadow-[0_3px_10px_rgba(63,50,42,0.08)] overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 sm:px-8 py-4 border-b border-[#8C7E76] flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-calendar-days text-[#5C4D44] text-lg"></i>
                            <h1 class="text-base sm:text-lg font-bold text-[#3F322A]">Detail Reservasi</h1>
                        </div>
                        <a
                            href="{{ route('reservasi.create', ['tanggal' => $selectedDate, 'sesi' => $session->id]) }}"
                            class="text-xs font-medium text-[#5C4D44] hover:text-[#D77487] transition flex items-center gap-1"
                        >
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Ubah Jadwal
                        </a>
                    </div>

                    <!-- Form Fields -->
                    <div class="p-6 sm:p-8 flex-1 flex flex-col">
                        <div class="space-y-5">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-[#3F322A] mb-2">
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                name="nama_lengkap"
                                id="nama_lengkap"
                                value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}"
                                required
                                placeholder="Masukan nama lengkap Anda"
                                class="w-full px-4 py-3 rounded-xl bg-white border border-[#A39A95] text-sm text-[#3F322A] placeholder:text-[#9E9590] shadow-[0_2px_4px_rgba(0,0,0,0.06)] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 @error('nama_lengkap') border-red-500 @enderror"
                            >
                            @error('nama_lengkap')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-[#3F322A] mb-2">
                                Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', Auth::user()->email) }}"
                                required
                                placeholder="Masukan email Anda"
                                class="w-full px-4 py-3 rounded-xl bg-white border border-[#A39A95] text-sm text-[#3F322A] placeholder:text-[#9E9590] shadow-[0_2px_4px_rgba(0,0,0,0.06)] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 @error('email') border-red-500 @enderror"
                            >
                            @error('email')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor HP -->
                        <div>
                            <label for="no_telp" class="block text-sm font-medium text-[#3F322A] mb-2">
                                Nomor HP
                            </label>
                            <input
                                type="text"
                                name="no_telp"
                                id="no_telp"
                                value="{{ old('no_telp', Auth::user()->no_telp) }}"
                                required
                                placeholder="Contoh: 08123456789"
                                class="w-full px-4 py-3 rounded-xl bg-white border border-[#A39A95] text-sm text-[#3F322A] placeholder:text-[#9E9590] shadow-[0_2px_4px_rgba(0,0,0,0.06)] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 @error('no_telp') border-red-500 @enderror"
                            >
                            @error('no_telp')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah Tamu -->
                        <div>
                            <label for="jumlah_tamu" class="block text-sm font-medium text-[#3F322A] mb-2">
                                Jumlah Tamu
                            </label>
                            <div class="relative">
                                <select
                                    name="jumlah_tamu"
                                    id="jumlah_tamu"
                                    required
                                    class="w-full appearance-none px-4 py-3 pr-10 rounded-xl bg-white border border-[#A39A95] text-sm text-[#3F322A] shadow-[0_2px_4px_rgba(0,0,0,0.06)] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 cursor-pointer @error('jumlah_tamu') border-red-500 @enderror"
                                >
                                    <option value="" {{ old('jumlah_tamu') ? '' : 'selected' }}>Pilih Jumlah</option>
                                    @for ($i = 1; $i <= $maxGuestsAllowed; $i++)
                                        <option value="{{ $i }}" {{ (int) old('jumlah_tamu') === $i ? 'selected' : '' }}>
                                            {{ $i }} Orang
                                        </option>
                                    @endfor
                                </select>
                                <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-[#7A6B62] text-xs">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                            <p class="mt-1.5 text-[11px] text-[#7A6B62]">
                                Tersisa {{ $remainingQuota }} kuota pada sesi {{ str_replace(':', '.', $session->jam_sesi) }} ({{ $durasiMenit }} menit).
                            </p>
                            @error('jumlah_tamu')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-auto pt-10 pb-1">
                            <button
                                type="submit"
                                id="confirmReservationBtn"
                                class="w-full max-w-md mx-auto block py-3 px-6 rounded-xl bg-[#648E92] hover:bg-[#527A7E] text-white font-semibold text-sm sm:text-base transition-all duration-200 shadow-xs cursor-pointer"
                            >
                                Konfirmasi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ===================================================
                     RIGHT COLUMN: RINGKASAN PEMBAYARAN & SYARAT KETENTUAN
                     =================================================== -->
                <div class="lg:col-span-5 flex flex-col gap-6">

                    <!-- Ringkasan Pembayaran Card -->
                    <div class="bg-[#FDF1F3] border border-[#8C7E76] rounded-[20px] shadow-[0_3px_10px_rgba(63,50,42,0.08)] p-6 sm:p-7">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-[#8C7E76]">
                            <i class="fa-solid fa-receipt text-[#5C4D44] text-lg"></i>
                            <h2 class="text-base sm:text-lg font-bold text-[#3F322A]">Ringkasan Pembayaran</h2>
                        </div>

                        <!-- Info Pemesan & Jadwal -->
                        <div class="py-4 space-y-3 border-b border-[#8C7E76] text-sm">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[#5C4D44]">Nama</span>
                                <span id="summaryName" class="font-semibold text-[#3F322A] text-right truncate">
                                    {{ old('nama_lengkap', Auth::user()->nama_lengkap) ?: 'User' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[#5C4D44]">Tanggal</span>
                                <span class="font-semibold text-[#3F322A] text-right">
                                    {{ $selectedDateFormatted }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[#5C4D44]">Waktu Sesi</span>
                                <span class="font-semibold text-[#3F322A] text-right">
                                    {{ str_replace(':', '.', $session->jam_sesi) }} ({{ $durasiMenit }} Menit)
                                </span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[#5C4D44]">Jumlah Tamu</span>
                                <span id="summaryGuest" class="font-semibold text-[#3F322A]">-</span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[#5C4D44]">Lokasi</span>
                                <span class="font-semibold text-[#3F322A]">Cat House</span>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="py-4 space-y-3 border-b border-[#8C7E76] text-sm">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[#5C4D44]">
                                    Harga per Tamu
                                    <span class="ml-1 inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $isWeekend ? 'bg-[#E58B9C] text-white' : 'bg-[#FFDAE1] text-[#3F322A]' }}">
                                        {{ $isWeekend ? 'Weekend' : 'Weekday' }}
                                    </span>
                                </span>
                                <span class="font-semibold text-[#3F322A]">
                                    Rp {{ number_format($hargaPerTamu, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[#5C4D44]">Sub Total</span>
                                <span id="summarySubTotal" class="font-semibold text-[#3F322A]">Rp 0</span>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="pt-4 flex items-center justify-between">
                            <span class="text-lg font-bold text-[#3F322A]">Total</span>
                            <span id="summaryTotal" class="text-2xl sm:text-[28px] font-bold text-[#3F322A]">
                                Rp 0
                            </span>
                        </div>
                    </div>

                    <!-- Syarat dan Ketentuan Card -->
                    <div class="flex-1 flex flex-col justify-between bg-[#A9C4C7] border border-[#5E7F83] rounded-[20px] shadow-[0_3px_10px_rgba(63,50,42,0.08)] p-6 sm:p-7 text-[#2E221E]">
                        <div>
                            <div class="flex items-center justify-center gap-2 pb-3 border-b border-[#3F322A]/50">
                                <i class="fa-solid fa-shield-halved text-[#5C4D44] text-base"></i>
                                <h3 class="text-sm sm:text-base font-semibold text-[#2E221E]">Syarat dan ketentuan</h3>
                            </div>

                            <ul class="mt-4 pl-5 list-disc space-y-2 text-xs sm:text-sm leading-relaxed text-[#2E221E]">
                                <li>Harap datang 15 menit lebih awal dari jadwal sesi Anda, keterlambatan dapat mengurangi durasi sesi Anda.</li>
                                <li>Tidak dapat dijadwalkan ulang (reschedule).</li>
                                <li>Reservasi yang dibatalkan tanpa konfirmasi akan dikenai denda</li>
                            </ul>
                        </div>

                        <div>
                            <label for="setuju_syarat" class="mt-5 flex items-start gap-2.5 cursor-pointer select-none">
                                <input
                                    type="checkbox"
                                    name="setuju_syarat"
                                    id="setuju_syarat"
                                    value="1"
                                    required
                                    {{ old('setuju_syarat') ? 'checked' : '' }}
                                    class="mt-0.5 w-4 h-4 rounded border-[#5E7F83] bg-white accent-[#648E92] shrink-0 cursor-pointer"
                                >
                                <span class="text-[11px] sm:text-xs leading-snug text-[#2E221E]/90">
                                    Saya telah membaca dan menyetujui seluruh syarat dan ketentuan di atas
                                </span>
                            </label>
                            @error('setuju_syarat')
                                <p class="mt-2 text-xs text-red-800 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
    (function () {
        const hargaPerTamu = {{ $hargaPerTamu }};
        const nameInput = document.getElementById('nama_lengkap');
        const guestSelect = document.getElementById('jumlah_tamu');
        const summaryName = document.getElementById('summaryName');
        const summaryGuest = document.getElementById('summaryGuest');
        const summarySubTotal = document.getElementById('summarySubTotal');
        const summaryTotal = document.getElementById('summaryTotal');

        function formatRupiah(amount) {
            return 'Rp ' + Number(amount).toLocaleString('id-ID');
        }

        function updateSummary() {
            const nameVal = (nameInput.value || '').trim();
            summaryName.textContent = nameVal !== '' ? nameVal : 'User';

            const guests = parseInt(guestSelect.value, 10);
            if (!isNaN(guests) && guests > 0) {
                const total = guests * hargaPerTamu;
                summaryGuest.textContent = guests + ' Orang';
                summarySubTotal.textContent = formatRupiah(total);
                summaryTotal.textContent = formatRupiah(total);
            } else {
                summaryGuest.textContent = '-';
                summarySubTotal.textContent = 'Rp 0';
                summaryTotal.textContent = 'Rp 0';
            }
        }

        nameInput.addEventListener('input', updateSummary);
        guestSelect.addEventListener('change', updateSummary);

        // Initial render
        updateSummary();
    })();
</script>
@endsection

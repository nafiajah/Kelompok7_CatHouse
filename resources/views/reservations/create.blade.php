@extends('layouts.app')

@section('title', 'Formulir Reservasi - Capyca Pet Cafe')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-2">Booking Online</span>
            <h1 class="text-3xl sm:text-4xl font-bold font-playfair text-cafe-brown">Reservasi Sesi Kunjungan</h1>
            <p class="text-sm text-cafe-muted mt-2">Pilih waktu kunjungan, jumlah pengunjung, dan metode pembayaran Anda</p>
        </div>

        <form action="{{ route('reservasi.store') }}" method="POST" id="bookingForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Form Fields -->
                <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border border-amber-100 shadow-sm space-y-6">
                    
                    <!-- 1. Customer info summary -->
                    <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/60 flex items-center justify-between text-xs">
                        <div>
                            <span class="text-cafe-muted block">Data Pemesan:</span>
                            <span class="font-bold text-cafe-brown text-sm">{{ Auth::user()->nama_pelanggan }}</span>
                            <span class="text-cafe-muted block">{{ Auth::user()->email }} | {{ Auth::user()->no_telp }}</span>
                        </div>
                        <span class="px-2.5 py-1 bg-amber-200 text-amber-900 rounded-full font-bold uppercase text-[10px]">Pelanggan</span>
                    </div>

                    <!-- 2. Tanggal Reservasi -->
                    <div>
                        <label for="tanggal_reservasi" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-2">
                            1. Pilih Tanggal Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="tanggal_reservasi" 
                            id="tanggal_reservasi" 
                            min="{{ date('Y-m-d') }}"
                            value="{{ old('tanggal_reservasi', date('Y-m-d')) }}" 
                            required
                            class="w-full px-4 py-3 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown font-medium @error('tanggal_reservasi') border-red-500 @enderror"
                        >
                        @error('tanggal_reservasi')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 3. Sesi Kunjungan -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-2">
                            2. Pilih Jam Sesi (90 Menit) <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($sessions as $session)
                                <label class="relative flex items-center p-3.5 rounded-2xl border-2 cursor-pointer transition select-none session-card {{ old('id_sesi', request('sesi')) == $session->id ? 'border-amber-600 bg-amber-50/60' : 'border-amber-100 hover:border-amber-300 bg-white' }}">
                                    <input 
                                        type="radio" 
                                        name="id_sesi" 
                                        value="{{ $session->id }}" 
                                        class="sr-only"
                                        {{ old('id_sesi', request('sesi')) == $session->id ? 'checked' : '' }}
                                        required
                                        onchange="updateSelection()"
                                    >
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-bold text-cafe-brown">{{ $session->jam_sesi }}</span>
                                            <i class="fa-solid fa-check-circle text-amber-600 text-sm check-icon {{ old('id_sesi', request('sesi')) == $session->id ? 'inline' : 'hidden' }}"></i>
                                        </div>
                                        <span class="text-[11px] text-cafe-muted mt-0.5 block">
                                            Kuota Maks. {{ $session->token_sesi }} Orang
                                        </span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('id_sesi')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 4. Jumlah Tamu -->
                    <div>
                        <label for="jumlah_tamu" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-2">
                            3. Jumlah Pengunjung / Tamu <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="adjustGuest(-1)" class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 font-bold hover:bg-amber-200 transition text-lg flex items-center justify-center">
                                -
                            </button>
                            <input 
                                type="number" 
                                name="jumlah_tamu" 
                                id="jumlah_tamu" 
                                min="1" 
                                max="10" 
                                value="{{ old('jumlah_tamu', 1) }}" 
                                required 
                                readonly
                                class="w-24 py-2.5 text-center font-bold text-lg rounded-xl border border-amber-200 bg-amber-50/40 text-cafe-brown focus:outline-none"
                            >
                            <button type="button" onclick="adjustGuest(1)" class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 font-bold hover:bg-amber-200 transition text-lg flex items-center justify-center">
                                +
                            </button>
                            <span class="text-xs text-cafe-muted font-medium">Orang (Maks. 10 per reservasi)</span>
                        </div>
                        @error('jumlah_tamu')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 5. Metode Pembayaran -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-2">
                            4. Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="p-4 rounded-2xl border-2 cursor-pointer transition select-none flex items-center gap-3 payment-card {{ old('metode_pembayaran', 'qris') === 'qris' ? 'border-amber-600 bg-amber-50/60' : 'border-amber-100 hover:border-amber-300' }}">
                                <input 
                                    type="radio" 
                                    name="metode_pembayaran" 
                                    value="qris" 
                                    class="sr-only" 
                                    {{ old('metode_pembayaran', 'qris') === 'qris' ? 'checked' : '' }}
                                    onchange="updatePaymentCard()"
                                >
                                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-qrcode"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-cafe-brown">QRIS</p>
                                    <p class="text-[11px] text-cafe-muted">Gopay, OVO, Dana, BCA</p>
                                </div>
                            </label>

                            <label class="p-4 rounded-2xl border-2 cursor-pointer transition select-none flex items-center gap-3 payment-card {{ old('metode_pembayaran') === 'bank' ? 'border-amber-600 bg-amber-50/60' : 'border-amber-100 hover:border-amber-300' }}">
                                <input 
                                    type="radio" 
                                    name="metode_pembayaran" 
                                    value="bank" 
                                    class="sr-only" 
                                    {{ old('metode_pembayaran') === 'bank' ? 'checked' : '' }}
                                    onchange="updatePaymentCard()"
                                >
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-building-columns"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-cafe-brown">Bank Transfer</p>
                                    <p class="text-[11px] text-cafe-muted">BCA / Mandiri / BRI</p>
                                </div>
                            </label>
                        </div>
                        @error('metode_pembayaran')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Right Summary Card -->
                <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border border-amber-100 shadow-sm sticky top-24 space-y-6">
                    <h3 class="text-lg font-bold font-playfair text-cafe-brown border-b border-amber-100 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-amber-600"></i> Ringkasan Reservasi
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-cafe-muted">
                            <span>Harga Tiket per Tamu:</span>
                            <span class="font-semibold text-cafe-brown">Rp {{ number_format($hargaPerTamu, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-cafe-muted">
                            <span>Jumlah Tamu:</span>
                            <span id="summaryGuest" class="font-semibold text-cafe-brown">1 Orang</span>
                        </div>
                        <div class="flex justify-between text-cafe-muted">
                            <span>Fasilitas Termasuk:</span>
                            <span class="font-semibold text-emerald-600">Free Welcome Drink</span>
                        </div>
                        
                        <div class="border-t border-amber-100 pt-3 flex justify-between items-center text-base">
                            <span class="font-bold text-cafe-brown">Total Pembayaran:</span>
                            <span id="summaryTotal" class="text-2xl font-extrabold text-amber-600 font-playfair">
                                Rp {{ number_format($hargaPerTamu, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-3 bg-amber-50 rounded-2xl text-xs text-amber-800 space-y-1">
                        <p class="font-bold"><i class="fa-solid fa-circle-info text-amber-600"></i> Catatan Kunjungan:</p>
                        <p>Harap tiba 10 menit sebelum sesi dimulai. Tiket berlaku sesuai jam sesi yang dipilih.</p>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-4 px-4 bg-gradient-to-r from-amber-600 to-amber-500 text-white font-bold text-sm rounded-2xl shadow-lg shadow-amber-500/25 hover:from-amber-700 hover:to-amber-600 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-lock"></i> Konfirmasi & Bayar Sekarang
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    const hargaPerTamu = {{ $hargaPerTamu }};

    function adjustGuest(delta) {
        const input = document.getElementById('jumlah_tamu');
        let current = parseInt(input.value) || 1;
        let next = current + delta;
        if (next >= 1 && next <= 10) {
            input.value = next;
            updateCalculation();
        }
    }

    function updateCalculation() {
        const guests = parseInt(document.getElementById('jumlah_tamu').value) || 1;
        const total = guests * hargaPerTamu;
        document.getElementById('summaryGuest').textContent = guests + ' Orang';
        document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function updateSelection() {
        document.querySelectorAll('.session-card').forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            const icon = card.querySelector('.check-icon');
            if (radio.checked) {
                card.classList.add('border-amber-600', 'bg-amber-50/60');
                card.classList.remove('border-amber-100', 'bg-white');
                if (icon) icon.classList.remove('hidden');
            } else {
                card.classList.remove('border-amber-600', 'bg-amber-50/60');
                card.classList.add('border-amber-100', 'bg-white');
                if (icon) icon.classList.add('hidden');
            }
        });
    }

    function updatePaymentCard() {
        document.querySelectorAll('.payment-card').forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            if (radio.checked) {
                card.classList.add('border-amber-600', 'bg-amber-50/60');
                card.classList.remove('border-amber-100');
            } else {
                card.classList.remove('border-amber-600', 'bg-amber-50/60');
                card.classList.add('border-amber-100');
            }
        });
    }

    // Initial setup
    updateSelection();
    updateCalculation();
</script>
@endsection
@endsection

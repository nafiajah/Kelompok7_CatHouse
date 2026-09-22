@extends('layouts.app')

@section('title', 'Capyca Pet Cafe - Kafe Kucing & Teman Santai')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden pt-8 pb-16 sm:pb-24 lg:pt-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Left Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-100/80 border border-amber-300 text-amber-900 text-xs font-bold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-amber-600 animate-ping"></span>
                    <span>Kafe Kucing Paling Nyaman di Kota Anda 🐾</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold font-playfair text-cafe-brown tracking-tight leading-[1.15]">
                    Hangatkan Harimu Bersama <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-amber-500">Anabul Tercinta</span>
                </h1>

                <p class="text-base sm:text-lg text-cafe-muted leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Nikmati secangkir kopi hangat sambil bermain dengan beragam ras kucing yang bersih, sehat, dan ramah. Pengalaman relaksasi terbaik untuk melepas penat bersama keluarga dan sahabat.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('reservasi.create') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-amber-600 to-amber-500 text-white font-bold text-base rounded-2xl shadow-lg shadow-amber-500/25 hover:from-amber-700 hover:to-amber-600 hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-3">
                        <i class="fa-solid fa-calendar-plus text-lg"></i> Reservasi Kunjungan
                    </a>
                    <a href="{{ route('cats.index') }}" class="w-full sm:w-auto px-7 py-4 bg-white border-2 border-amber-200 text-cafe-brown font-bold text-base rounded-2xl hover:bg-amber-50 hover:border-amber-300 transition-all duration-200 flex items-center justify-center gap-2 shadow-sm">
                        <i class="fa-solid fa-paw text-amber-600"></i> Kenalan Sama Kucing
                    </a>
                </div>

                <!-- Stats summary -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-amber-900/10 max-w-lg mx-auto lg:mx-0">
                    <div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-amber-700 font-playfair">{{ count($cats) }}+</p>
                        <p class="text-xs font-semibold text-cafe-muted">Kucing Jinak</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-amber-700 font-playfair">{{ count($variants) }}+</p>
                        <p class="text-xs font-semibold text-cafe-muted">Pilihan Ras</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-extrabold text-amber-700 font-playfair">4.9 ★</p>
                        <p class="text-xs font-semibold text-cafe-muted">Rating Pelanggan</p>
                    </div>
                </div>
            </div>

            <!-- Hero Right Image Banner -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <!-- Decorative back layers -->
                    <div class="absolute -top-4 -left-4 w-72 h-72 bg-amber-300/30 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-4 -right-4 w-72 h-72 bg-orange-400/20 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white">
                        <img 
                            src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=800&auto=format&fit=crop&q=80" 
                            alt="Capyca Pet Cafe Cat" 
                            class="w-full h-96 sm:h-[450px] object-cover hover:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-6 text-white">
                            <span class="text-xs uppercase font-bold tracking-wider px-2.5 py-1 rounded-md bg-amber-500 inline-block mb-2">Bintang Kafe</span>
                            <h3 class="text-xl font-bold font-playfair">Mochi si British Shorthair</h3>
                            <p class="text-xs text-amber-200">Suka tidur di pangkuan dan sangat ramah dengan kamera 📸</p>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl border border-amber-100 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <div>
                            <p class="text-xs text-cafe-muted font-medium">Kesehatan Terjamin</p>
                            <p class="text-sm font-bold text-cafe-brown">Vaksin & Grooming Rutin</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-16 bg-white border-y border-amber-900/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-2">Kenapa Memilih Kami?</span>
            <h2 class="text-3xl sm:text-4xl font-bold font-playfair text-cafe-brown">
                Kenyamanan untuk Anda, Kebahagiaan untuk Anabul
            </h2>
            <p class="text-sm sm:text-base text-cafe-muted mt-3">
                Kami mengutamakan kebersihan lingkungan, nutrisi terbaik untuk anabul, dan kenyamanan pengunjung dengan membatasi kuota tamu di setiap sesinya.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 rounded-3xl bg-amber-50/50 border border-amber-100 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl mb-6 shadow-sm">
                    <i class="fa-solid fa-shield-cat"></i>
                </div>
                <h3 class="text-lg font-bold text-cafe-brown mb-2 font-playfair">Higienis & Steril</h3>
                <p class="text-sm text-cafe-muted leading-relaxed">
                    Setiap sudut kafe disterilkan secara berkala dengan air purifier medis dan desinfektan ramah hewan yang bebas bau.
                </p>
            </div>

            <div class="p-8 rounded-3xl bg-amber-50/50 border border-amber-100 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl mb-6 shadow-sm">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
                <h3 class="text-lg font-bold text-cafe-brown mb-2 font-playfair">Menu Minuman & Snack</h3>
                <p class="text-sm text-cafe-muted leading-relaxed">
                    Setiap reservasi sudah mendapatkan welcome drink pilihan. Kami juga menyediakan aneka kudapan manis pendamping santai.
                </p>
            </div>

            <div class="p-8 rounded-3xl bg-amber-50/50 border border-amber-100 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl mb-6 shadow-sm">
                    <i class="fa-solid fa-users-viewfinder"></i>
                </div>
                <h3 class="text-lg font-bold text-cafe-brown mb-2 font-playfair">Sistem Sesi Teratur</h3>
                <p class="text-sm text-cafe-muted leading-relaxed">
                    Sistem kuota token membatasi maksimal 15 orang per sesi agar kucing tidak stres dan Anda dapat berinteraksi secara leluasa.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Cats Gallery Section -->
<section id="kucing" class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-2">Penghuni Spesial</span>
                <h2 class="text-3xl sm:text-4xl font-bold font-playfair text-cafe-brown">Temui Sahabat Berbulu Kami</h2>
                <p class="text-sm text-cafe-muted mt-2">Setiap kucing memiliki kepribadian unik yang menggemaskan</p>
            </div>
            <a href="{{ route('cats.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-amber-700 hover:text-amber-800 transition">
                Lihat Semua Kucing ({{ count($cats) }}) <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <!-- Variant Filter Pills -->
        <div class="flex flex-wrap items-center gap-2 mb-8">
            <a 
                href="{{ route('home') }}#kucing" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$selectedVariant ? 'bg-amber-600 text-white shadow-md' : 'bg-white text-cafe-muted hover:bg-amber-50 border border-amber-200' }}"
            >
                Semua Ras
            </a>
            @foreach($variants as $variant)
                <a 
                    href="{{ route('home', ['variant' => $variant->id]) }}#kucing" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $selectedVariant == $variant->id ? 'bg-amber-600 text-white shadow-md' : 'bg-white text-cafe-muted hover:bg-amber-50 border border-amber-200' }}"
                >
                    {{ $variant->jenis }} ({{ $variant->data_kucing_count }})
                </a>
            @endforeach
        </div>

        <!-- Cats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($cats as $cat)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-amber-100 transition-all duration-300 group flex flex-col">
                    <div class="relative h-64 overflow-hidden bg-amber-50">
                        <img 
                            src="{{ $cat->foto_url }}" 
                            alt="{{ $cat->nama_kucing }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-md text-amber-900 font-bold text-xs px-3 py-1.5 rounded-full shadow-sm">
                            {{ $cat->variant ? $cat->variant->jenis : 'Varian' }}
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold font-playfair text-cafe-brown mb-2">{{ $cat->nama_kucing }}</h3>
                            <p class="text-sm text-cafe-muted line-clamp-3 leading-relaxed">
                                {{ $cat->deskripsi }}
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-amber-50 flex items-center justify-between">
                            <span class="text-xs text-amber-700 font-semibold flex items-center gap-1.5">
                                <i class="fa-solid fa-circle text-[8px] text-emerald-500"></i> Siap Disapa
                            </span>
                            <a href="{{ route('reservasi.create') }}" class="text-xs font-bold text-amber-600 hover:text-amber-800 transition">
                                Ajak Main &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-12 text-center bg-white rounded-3xl border border-dashed border-amber-200">
                    <i class="fa-solid fa-cat text-4xl text-amber-300 mb-3"></i>
                    <p class="text-cafe-muted text-sm">Belum ada data kucing pada kategori ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Sessions & Pricing Section -->
<section id="sesi" class="py-20 bg-white border-y border-amber-900/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-2">Jadwal & Kuota</span>
            <h2 class="text-3xl sm:text-4xl font-bold font-playfair text-cafe-brown">Pilihan Sesi Kunjungan</h2>
            <p class="text-sm sm:text-base text-cafe-muted mt-3">
                Durasi kunjungan 90 menit per sesi dengan kapasitas maksimal 15 orang untuk menjaga ketenangan kucing dan kepuasan Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($sessions as $index => $session)
                <div class="p-6 rounded-3xl bg-[#FAF6F0] border border-amber-200 hover:border-amber-400 transition hover:shadow-md flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-amber-200/80 text-amber-900 rounded-full text-xs font-bold">
                                Sesi {{ $index + 1 }}
                            </span>
                            <span class="text-xs font-bold text-cafe-muted flex items-center gap-1.5">
                                <i class="fa-solid fa-users text-amber-600"></i> Kuota: {{ $session->token_sesi }} Orang
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold font-playfair text-cafe-brown flex items-center gap-2 mb-2">
                            <i class="fa-regular fa-clock text-amber-600 text-lg"></i>
                            {{ $session->jam_sesi }}
                        </h3>
                        <p class="text-xs text-cafe-muted leading-relaxed">
                            Nikmati waktu santai, interaksi bebas dengan kucing, dan 1 welcome drink gratis.
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-amber-200/60 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-cafe-muted block">Tiket Masuk</span>
                            <span class="text-lg font-bold text-amber-800">Rp 35.000 <span class="text-xs font-normal text-cafe-muted">/orang</span></span>
                        </div>
                        <a href="{{ route('reservasi.create') }}?sesi={{ $session->id }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                            Pilih Sesi
                        </a>
                    </div>
                </div>
            @endforeach

            <!-- Pricing Banner Card -->
            <div class="p-6 rounded-3xl bg-gradient-to-br from-amber-600 to-amber-700 text-white flex flex-col justify-between shadow-lg">
                <div>
                    <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-bold uppercase tracking-wider inline-block mb-3">
                        Paket Hemat
                    </span>
                    <h3 class="text-2xl font-bold font-playfair mb-2">Semua Sesi Termasuk:</h3>
                    <ul class="space-y-2 text-xs text-amber-100">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-300"></i> 1 Welcome Drink (Kopi / Teh / Susu)</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-300"></i> Free WiFi berkecepatan tinggi</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-300"></i> Mainan bulu kucing & cat scratcher</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-300"></i> Hand sanitizer & lint roller pembersih bulu</li>
                    </ul>
                </div>
                <a href="{{ route('reservasi.create') }}" class="mt-6 w-full text-center py-2.5 bg-white text-amber-800 text-xs font-bold rounded-xl hover:bg-amber-50 transition">
                    Booking Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Customer Reviews Section -->
<section id="ulasan" class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-2">Suara Pelanggan</span>
                <h2 class="text-3xl sm:text-4xl font-bold font-playfair text-cafe-brown">Apa Kata Pengunjung Kami?</h2>
                <p class="text-sm text-cafe-muted mt-2">Cerita hangat dari para pecinta kucing yang telah berkunjung</p>
            </div>
            <a href="{{ route('feedback.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-600 text-white font-bold text-xs hover:bg-amber-700 transition shadow-sm">
                <i class="fa-solid fa-pen-nib"></i> Tulis Ulasan Kamu
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($feedbacks as $feedback)
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100 flex flex-col justify-between">
                    <div>
                        <!-- Stars -->
                        <div class="flex items-center gap-1 text-amber-400 text-sm mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star {{ $i <= $feedback->bintang ? 'text-amber-400' : 'text-slate-200' }}"></i>
                            @endfor
                            <span class="ml-2 text-xs font-bold text-amber-700">({{ $feedback->bintang }}.0)</span>
                        </div>
                        <p class="text-sm text-cafe-text italic leading-relaxed">
                            "{{ $feedback->teks_saran }}"
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-amber-50 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr($feedback->user ? $feedback->user->nama_pelanggan : 'P', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-cafe-brown">{{ $feedback->user ? $feedback->user->nama_pelanggan : 'Pengunjung Setia' }}</p>
                            <p class="text-xs text-cafe-muted">{{ \Carbon\Carbon::parse($feedback->tanggal_saran)->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-10 text-center bg-white rounded-3xl border border-dashed border-amber-200">
                    <p class="text-cafe-muted text-sm">Jadilah yang pertama memberikan ulasan untuk Capyca Pet Cafe!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-16 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 text-white text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10 space-y-6">
        <h2 class="text-3xl sm:text-5xl font-extrabold font-playfair tracking-tight">Siap Menghabiskan Waktu Bersama Anabul?</h2>
        <p class="text-base sm:text-lg text-amber-100 max-w-2xl mx-auto">
            Pesan tiket kunjungan Anda sekarang sebelum kuota sesi hari ini habis. Proses mudah, cepat, dan terkonfirmasi otomatis.
        </p>
        <div>
            <a href="{{ route('reservasi.create') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-amber-700 font-extrabold text-base rounded-2xl shadow-xl hover:bg-amber-50 hover:scale-105 transition-all duration-200">
                <i class="fa-solid fa-ticket text-amber-600"></i> Booking Sesi Sekarang
            </a>
        </div>
    </div>
</section>
@endsection

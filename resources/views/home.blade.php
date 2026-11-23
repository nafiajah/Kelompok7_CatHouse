@extends('layouts.app')

@section('title', 'Cat House Bukit Bintang - Play • Interact • Make Memories')

@php
    /**
     * Helper untuk mengecek foto manual di folder public/images/
     * Cukup simpan file foto dengan nama dasar di bawah ini (ekstensi .jpg / .jpeg / .png / .webp),
     * foto akan langsung tampil otomatis di halaman utama.
     */
    $resolveManualPhoto = function (string $baseName): ?string {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            $relativePath = "images/{$baseName}.{$ext}";
            if (file_exists(public_path($relativePath))) {
                return asset($relativePath);
            }
        }
        return null;
    };

    // 1. Foto Background Hero: simpan di public/images/hero-banner.jpg (atau .png/.webp)
    $heroPhoto = $resolveManualPhoto('hero-banner');

    // 2. Foto Tentang Kami: simpan di public/images/tentang-kami.jpg (atau .png/.webp)
    $aboutPhoto = $resolveManualPhoto('tentang-kami');

    // 3. Foto 3 Kucing Favorit: simpan di public/images/cat-bentley.jpg, cat-luna.jpg, cat-camala.jpg
    $favoriteCats = [
        [
            'name'    => 'Bentley',
            'tagline' => '"I\'m a Maine Coon Male cat"',
            'file'    => 'cat-bentley',
            'photo'   => $resolveManualPhoto('cat-bentley'),
        ],
        [
            'name'    => 'Luna',
            'tagline' => '"I\'m a Maine Coon mix Persian Female cat"',
            'file'    => 'cat-luna',
            'photo'   => $resolveManualPhoto('cat-luna'),
        ],
        [
            'name'    => 'Camala',
            'tagline' => '"I\'m a Maine Coon Female cat"',
            'file'    => 'cat-camala',
            'photo'   => $resolveManualPhoto('cat-camala'),
        ],
    ];
@endphp

@section('content')
<!-- =========================================================
     1. HERO SECTION
     Ganti foto background dengan menaruh file di:
     public/images/hero-banner.jpg (atau .png / .webp)
     ========================================================= -->
<section class="relative w-full min-h-[440px] sm:min-h-[500px] lg:min-h-[540px] flex items-center justify-center overflow-hidden">
    @if($heroPhoto)
        <img
            src="{{ $heroPhoto }}"
            alt="Cat House Bukit Bintang"
            class="absolute inset-0 w-full h-full object-cover object-center"
        >
        <div class="absolute inset-0 bg-black/30"></div>
    @else
        <!-- Placeholder Background sampai foto hero ditambahkan manual -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#A58F7B] via-[#897463] to-[#6A5749]"></div>
        <div class="absolute inset-0 opacity-15" style="background-image: radial-gradient(#FFFFFF 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute bottom-4 right-5 z-20 inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/35 backdrop-blur-xs border border-white/25 text-white/90 text-[11px] font-medium">
            <i class="fa-regular fa-image"></i>
            <span>Slot Foto Hero: <code class="font-mono text-white">public/images/hero-banner.jpg</code></span>
        </div>
    @endif

    <!-- Hero Content -->
    <div class="relative z-10 max-w-4xl mx-auto px-5 sm:px-8 text-center py-16">
        <h1 class="font-literata font-bold text-white text-4xl sm:text-5xl lg:text-[62px] leading-[1.15] tracking-tight drop-shadow-[0_2px_10px_rgba(0,0,0,0.35)]">
            Cat House Bukit Bintang
        </h1>
        <p class="mt-3 sm:mt-4 text-base sm:text-xl font-medium text-white/95 drop-shadow-[0_1px_6px_rgba(0,0,0,0.3)]">
            Keceriaan Kecil untuk Hari yang Lebih Baik.
        </p>
        <div class="mt-7 sm:mt-8">
            <a
                href="{{ route('reservasi.create') }}"
                class="inline-flex items-center justify-center gap-2.5 px-7 py-3 bg-[#E58B9C] hover:bg-[#D77487] text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
            >
                <i class="fa-regular fa-calendar text-base"></i>
                <span>Reservasi Sekarang</span>
            </a>
        </div>
    </div>
</section>

<!-- =========================================================
     2. MENGAPA HARUS CAT HOUSE? SECTION
     ========================================================= -->
<section class="bg-white py-16 sm:py-24">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">
        <!-- Section Heading -->
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-[#E58B9C] font-bold text-base sm:text-lg tracking-normal">
                Mengapa Harus Cat House?
            </p>
            <h2 class="mt-3 font-literata font-bold text-[#3F322A] text-3xl sm:text-4xl lg:text-[42px] leading-[1.2]">
                Ciptakan Momen Menyenangkan<br class="hidden sm:inline"> Bersama Anabul
            </h2>
            <p class="mt-4 text-xs sm:text-sm md:text-base text-[#5C4D44] leading-relaxed max-w-xl mx-auto">
                Hadirkan pengalaman menyenangkan melalui interaksi langsung dengan kucing dalam lingkungan yang bersih, nyaman, dan penuh kehangatan.
            </p>
        </div>

        <!-- 3 Feature Cards -->
        <div class="mt-12 sm:mt-14 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            <!-- Card 1: Lingkungan Bersih dan Nyaman -->
            <div class="bg-white rounded-[20px] border border-[#D5CBC5] p-7 sm:p-8 hover:border-[#E58B9C] hover:shadow-md transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-[#E58B9C] text-white flex items-center justify-center mb-5 shadow-xs">
                    <!-- Shield Check SVG -->
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3zm-1.06 13.54L7.4 12l1.41-1.41 2.12 2.12 4.24-4.24 1.41 1.41-5.64 5.66z"/>
                    </svg>
                </div>
                <h3 class="font-literata font-semibold text-base sm:text-lg text-[#3F322A] mb-2">
                    Lingkungan Bersih dan Nyaman
                </h3>
                <p class="text-xs sm:text-sm text-[#5C4D44] leading-relaxed">
                    Area bermain yang terjaga kebersihannya demi kenyamanan pengunjung dan kesehatan kucing.
                </p>
            </div>

            <!-- Card 2: Interaksi Bersama Kucing -->
            <div class="bg-white rounded-[20px] border border-[#D5CBC5] p-7 sm:p-8 hover:border-[#E58B9C] hover:shadow-md transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-[#E58B9C] text-white flex items-center justify-center mb-5 shadow-xs">
                    <!-- Cute Cat Face SVG -->
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M5.5 4.5L9.2 8.2C10.05 7.9 11 7.75 12 7.75s1.95.15 2.8.45l3.7-3.7c.4-.4 1.1-.15 1.1.42V13c0 4.14-3.36 7.5-7.6 7.5S4.4 17.14 4.4 13V4.92c0-.57.7-.82 1.1-.42zM9.25 13a1.15 1.15 0 100 2.3 1.15 1.15 0 000-2.3zm5.5 0a1.15 1.15 0 100 2.3 1.15 1.15 0 000-2.3zM12 16.75l-1.1-.95h2.2L12 16.75z"/>
                    </svg>
                </div>
                <h3 class="font-literata font-semibold text-base sm:text-lg text-[#3F322A] mb-2">
                    Interaksi Bersama Kucing
                </h3>
                <p class="text-xs sm:text-sm text-[#5C4D44] leading-relaxed">
                    Nikmati waktu bermain, berkenalan, dan membangun kedekatan dengan berbagai kucing.
                </p>
            </div>

            <!-- Card 3: Sesi Kunjungan Teratur -->
            <div class="bg-white rounded-[20px] border border-[#D5CBC5] p-7 sm:p-8 hover:border-[#E58B9C] hover:shadow-md transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-[#E58B9C] text-white flex items-center justify-center mb-5 shadow-xs">
                    <i class="fa-regular fa-calendar-check text-xl"></i>
                </div>
                <h3 class="font-literata font-semibold text-base sm:text-lg text-[#3F322A] mb-2">
                    Sesi Kunjungan Teratur
                </h3>
                <p class="text-xs sm:text-sm text-[#5C4D44] leading-relaxed">
                    Pembatasan jumlah pengunjung di setiap sesi untuk menjaga kenyamanan bersama kucing.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     3. TENTANG KAMI SECTION
     Ganti foto dengan menaruh file di:
     public/images/tentang-kami.jpg (atau .png / .webp)
     ========================================================= -->
<section id="tentang-kami" class="bg-[#FFDAE1] py-16 sm:py-24">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-14 items-center">
            <!-- Left Text Column -->
            <div class="md:col-span-6 space-y-5">
                <h2 class="font-literata font-bold text-[#3F322A] text-3xl sm:text-4xl lg:text-[44px] leading-tight">
                    Tentang Kami
                </h2>
                <p class="text-sm sm:text-base text-[#3F322A] leading-relaxed">
                    Cat House merupakan tempat yang hadir untuk memberikan pengalaman menyenangkan bagi para pecinta kucing melalui interaksi langsung dengan berbagai kucing yang menggemaskan.
                </p>
                <p class="text-sm sm:text-base text-[#3F322A] leading-relaxed">
                    Kami menyediakan lingkungan yang nyaman, bersih, dan aman bagi pengunjung untuk bermain, berkenalan, serta menghabiskan waktu bersama sahabat berbulu.
                </p>
            </div>

            <!-- Right Photo Column -->
            <div class="md:col-span-6 flex flex-col items-center md:items-end">
                <div class="w-full max-w-[400px]">
                    <div class="w-full aspect-[4/4.3] rounded-2xl overflow-hidden bg-white/75 shadow-sm">
                        @if($aboutPhoto)
                            <img
                                src="{{ $aboutPhoto }}"
                                alt="Tentang Cat House"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <!-- Placeholder Foto Tentang Kami -->
                            <div class="w-full h-full border-2 border-dashed border-[#E58B9C] rounded-2xl bg-white/60 flex flex-col items-center justify-center p-6 text-center text-[#5C4D44]">
                                <div class="w-14 h-14 rounded-full bg-[#FFDAE1] text-[#E58B9C] flex items-center justify-center text-2xl mb-3">
                                    <i class="fa-regular fa-image"></i>
                                </div>
                                <p class="text-sm font-semibold text-[#3F322A]">Slot Foto Tentang Kami</p>
                                <p class="text-xs text-[#5C4D44] mt-1">Simpan foto di:</p>
                                <code class="mt-1.5 px-2.5 py-1 rounded-md bg-white text-[11px] font-mono text-[#3F322A] border border-[#E58B9C]/40">public/images/tentang-kami.jpg</code>
                            </div>
                        @endif
                    </div>

                    <!-- Outlined View all button below photo -->
                    <div class="mt-4 flex justify-end">
                        <a
                            href="{{ route('about') }}"
                            class="inline-flex items-center justify-center px-5 py-1.5 rounded-lg border border-[#3F322A] text-[#3F322A] text-xs font-semibold hover:bg-[#3F322A] hover:text-white transition"
                        >
                            View all
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     4. KUCING FAVORIT / TEMUI SAHABAT BERBULU KAMI SECTION
     Ganti foto 3 kucing dengan menaruh file di:
     - public/images/cat-bentley.jpg
     - public/images/cat-luna.jpg
     - public/images/cat-camala.jpg
     ========================================================= -->
<section id="kucing-favorit" class="bg-white py-16 sm:py-24">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">
        <!-- Header -->
        <div>
            <p class="text-lg sm:text-xl font-bold text-[#3F322A]">
                Kucing Favorit
            </p>
            <div class="mt-1 flex flex-col sm:flex-row sm:items-end justify-between gap-2">
                <h2 class="font-literata font-bold text-[#E58B9C] text-3xl sm:text-4xl lg:text-[44px] leading-tight">
                    Temui Sahabat Berbulu Kami
                </h2>
                <a
                    href="{{ route('cats.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-[#E58B9C] hover:text-[#D77487] transition shrink-0"
                >
                    <span>View all</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
            <p class="mt-3 text-xs sm:text-sm text-[#5C4D44] leading-relaxed max-w-3xl">
                Kenali beberapa kucing pilihan kami dengan karakter dan kepribadian yang berbeda. Masing-masing memiliki pesona tersendiri yang siap menemani waktu bermain dan menciptakan pengalaman menyenangkan bersama Anda.
            </p>
        </div>

        <!-- 3 Kotak Slot Foto Kucing Favorit (foto sudah lengkap dengan bordernya) -->
        <div class="mt-10 sm:mt-12 grid grid-cols-1 sm:grid-cols-3 gap-7 lg:gap-10">
            @foreach($favoriteCats as $cat)
                @if($cat['photo'])
                    <div class="rounded-[18px] overflow-hidden hover:-translate-y-1 transition-all duration-300">
                        <img
                            src="{{ $cat['photo'] }}"
                            alt="{{ $cat['name'] }}"
                            class="w-full h-auto block rounded-[18px]"
                        >
                    </div>
                @else
                    <!-- Placeholder Kotak Slot Foto Kucing -->
                    <div class="aspect-square rounded-[18px] border-2 border-dashed border-[#E58B9C] bg-[#FFF5F7] flex flex-col items-center justify-center p-6 text-center text-[#5C4D44] hover:border-[#D77487] transition">
                        <div class="w-12 h-12 rounded-full bg-[#FFDAE1] text-[#E58B9C] flex items-center justify-center text-xl mb-3">
                            <i class="fa-regular fa-image"></i>
                        </div>
                        <p class="text-sm font-semibold text-[#3F322A]">Slot Foto {{ $cat['name'] }}</p>
                        <p class="text-xs text-[#5C4D44] mt-1">Simpan foto di:</p>
                        <code class="mt-1.5 px-2.5 py-1 rounded-md bg-white text-[11px] font-mono text-[#3F322A] border border-[#E58B9C]/40 break-all">public/images/{{ $cat['file'] }}.jpg</code>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- =========================================================
     5. FEEDBACK / CERITA MEREKA SETELAH BERKUNJUNG SECTION
     Menampilkan ulasan pengunjung dari database (status tampil)
     ========================================================= -->
<section id="feedback" class="bg-white pt-4 pb-16 sm:pt-8 sm:pb-24">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">
        <!-- Header -->
        <div>
            <p class="text-lg sm:text-xl font-bold text-[#3F322A]">
                Feedback
            </p>
            <h2 class="mt-1 font-literata font-bold text-[#E58B9C] text-3xl sm:text-4xl lg:text-[44px] leading-tight">
                Cerita Mereka Setelah Berkunjung
            </h2>
            <p class="mt-3 text-xs sm:text-sm text-[#5C4D44] leading-relaxed max-w-2xl">
                Setiap kunjungan memiliki cerita dan pengalaman tersendiri. Simak berbagai kesan dari pengunjung yang telah menghabiskan waktu bersama kucing-kucing menggemaskan di Cat House.
            </p>
        </div>

        @php
            $displayFeedbacks = ($feedbacks ?? collect())->isNotEmpty()
                ? $feedbacks->take(6)
                : collect([
                    (object) ['bintang' => 5, 'teks_saran' => 'Kucingnya ramah, tempatnya bersih dan nyaman.', 'user' => (object) ['nama_lengkap' => 'Nafi']],
                    (object) ['bintang' => 5, 'teks_saran' => 'Suka banget dengan suasananya.', 'user' => (object) ['nama_lengkap' => 'Mutia']],
                    (object) ['bintang' => 5, 'teks_saran' => 'Pengalaman yang menyenangkan.', 'user' => (object) ['nama_lengkap' => 'Rara']],
                ]);
        @endphp

        <!-- 3-Column Feedback Cards -->
        <div class="mt-10 sm:mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($displayFeedbacks as $fb)
                <div class="bg-white rounded-[18px] border border-[#8C7E76] px-6 py-5 flex flex-col justify-between min-h-[210px] shadow-[0_2px_6px_rgba(63,50,42,0.04)] hover:border-[#E58B9C] hover:shadow-md transition-all duration-200">
                    <!-- Top Stars Row -->
                    <div>
                        <div class="flex items-center gap-1 pb-3.5 border-b border-[#8C7E76]/70">
                            @for($s = 1; $s <= 5; $s++)
                                <i class="fa-solid fa-star text-base {{ $s <= ($fb->bintang ?? 5) ? 'text-[#FCE14B]' : 'text-stone-200' }}"></i>
                            @endfor
                        </div>

                        <!-- Feedback Quote -->
                        <p class="py-4 text-sm sm:text-[15px] text-[#3F322A] leading-relaxed">
                            "{{ $fb->teks_saran }}"
                        </p>
                    </div>

                    <!-- Reviewer Profile -->
                    <div class="flex items-center gap-3 pt-2">
                        <div class="w-9 h-9 rounded-full bg-[#E58B9C] text-white flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-bold text-[#3F322A] truncate leading-tight">
                                {{ $fb->user ? $fb->user->nama_lengkap : 'Pengunjung' }}
                            </p>
                            <p class="text-[11px] text-[#8C7E76] leading-tight mt-0.5">
                                Pengunjung
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

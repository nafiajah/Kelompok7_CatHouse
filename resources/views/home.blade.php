@extends('layouts.app')

@section('title', 'Cat House Bukit Bintang - Play • Interact • Make Memories')

@php
$resolveManualPhoto = function (string $baseName): ?string {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            $relativePath = "images/{$baseName}.{$ext}";
            if (file_exists(public_path($relativePath))) {
                return asset($relativePath);
            }
        }
        return null;
    };

    $heroPhoto = $resolveManualPhoto('hero-banner');

    $aboutPhoto = $resolveManualPhoto('tentang-kami');

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

<section class="relative w-full min-h-[440px] sm:min-h-[500px] lg:min-h-[540px] flex items-center justify-center overflow-hidden">
    @if($heroPhoto)
        <img
            src="{{ $heroPhoto }}"
            alt="Cat House Bukit Bintang"
            class="absolute inset-0 w-full h-full object-cover object-center"
        >
        <div class="absolute inset-0 bg-black/30"></div>
    @else

        <div class="absolute inset-0 bg-gradient-to-br from-[#A58F7B] via-[#897463] to-[#6A5749]"></div>
        <div class="absolute inset-0 opacity-15" style="background-image: radial-gradient(#FFFFFF 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute bottom-4 right-5 z-20 inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/35 backdrop-blur-xs border border-white/25 text-white/90 text-[11px] font-medium">
            <i class="fa-regular fa-image"></i>
            <span>Slot Foto Hero: <code class="font-mono text-white">public/images/hero-banner.jpg</code></span>
        </div>
    @endif

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

<section class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1360px] mx-auto px-5 sm:px-8 lg:px-10">

        <div class="text-center max-w-3xl mx-auto">
            <p class="text-[#E58B9C] font-bold text-lg sm:text-[21px] tracking-normal">
                Mengapa Harus Cat House?
            </p>
            <h2 class="mt-4 font-literata font-medium text-[#3F322A] text-3xl sm:text-4xl lg:text-[42px] leading-[1.2] tracking-[-0.01em]">
                Ciptakan Momen Menyenangkan<br class="hidden sm:inline"> Bersama Anabul
            </h2>
            <p class="mt-4 text-xs sm:text-sm md:text-[15px] text-[#4A3F39] leading-[1.65] max-w-2xl mx-auto">
                Hadirkan pengalaman menyenangkan melalui interaksi langsung dengan kucing<br class="hidden md:inline"> dalam lingkungan yang bersih, nyaman, dan penuh kehangatan.
            </p>
        </div>

        <div class="mt-10 sm:mt-12 grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6">

            <div class="bg-white rounded-[20px] border border-[#BEB7B2] px-6 py-5 sm:px-7 sm:py-6 hover:border-[#E58B9C] hover:shadow-sm transition-all duration-200">
                <div class="w-11 h-11 rounded-[12px] bg-[#E58B9C] text-white flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 2.5L4.75 5.45C4.3 5.64 4 6.08 4 6.57V11.3C4 16.05 7.41 20.38 12 21.75C16.59 20.38 20 16.05 20 11.3V6.57C20 6.08 19.7 5.64 19.25 5.45L12 2.5Z" fill="#FFFFFF"/>
                        <path d="M9.1 12.15L11.05 14.1L15.1 9.95" stroke="#E58B9C" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="font-literata font-medium text-[15px] sm:text-base text-[#3F322A] leading-snug mb-1.5">
                    Lingkungan Bersih dan Nyaman
                </h3>
                <p class="text-[11.5px] sm:text-[12px] text-[#4A3F39] leading-[1.55]">
                    Area bermain yang terjaga kebersihannya demi kenyamanan pengunjung dan kesehatan kucing.
                </p>
            </div>

            <div class="bg-white rounded-[20px] border border-[#BEB7B2] px-6 py-5 sm:px-7 sm:py-6 hover:border-[#E58B9C] hover:shadow-sm transition-all duration-200">
                <div class="w-11 h-11 rounded-[12px] bg-[#E58B9C] text-white flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5.4 5.2C5.05 4.85 4.45 5.1 4.45 5.6V13.2C4.45 17.15 7.8 20 12 20C16.2 20 19.55 17.15 19.55 13.2V5.6C19.55 5.1 18.95 4.85 18.6 5.2L15.3 8.45C14.3 8.05 13.18 7.85 12 7.85C10.82 7.85 9.7 8.05 8.7 8.45L5.4 5.2Z" fill="#FFFFFF"/>
                        <circle cx="9.4" cy="13.2" r="1.15" fill="#E58B9C"/>
                        <circle cx="14.6" cy="13.2" r="1.15" fill="#E58B9C"/>
                        <path d="M10.9 15.2H13.1L12 16.5L10.9 15.2Z" fill="#E58B9C"/>
                        <path d="M3.6 13.6H6.2M3.8 15.5H6.4M17.8 13.6H20.4M17.6 15.5H20.2" stroke="#E58B9C" stroke-width="1.2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="font-literata font-medium text-[15px] sm:text-base text-[#3F322A] leading-snug mb-1.5">
                    Interaksi Bersama Kucing
                </h3>
                <p class="text-[11.5px] sm:text-[12px] text-[#4A3F39] leading-[1.55]">
                    Nikmati waktu bermain, berkenalan, dan membangun kedekatan dengan berbagai kucing.
                </p>
            </div>

            <div class="bg-white rounded-[20px] border border-[#BEB7B2] px-6 py-5 sm:px-7 sm:py-6 hover:border-[#E58B9C] hover:shadow-sm transition-all duration-200">
                <div class="w-11 h-11 rounded-[12px] bg-[#E58B9C] text-white flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <rect x="4" y="5.5" width="16" height="15" rx="2.5" fill="#FFFFFF"/>
                        <path d="M8.25 3.5V6.5M15.75 3.5V6.5" stroke="#FFFFFF" stroke-width="2.1" stroke-linecap="round"/>
                        <path d="M4 9.6H20" stroke="#E58B9C" stroke-width="1.5"/>
                        <path d="M9.1 14.8L11.05 16.75L15.1 12.6" stroke="#E58B9C" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="font-literata font-medium text-[15px] sm:text-base text-[#3F322A] leading-snug mb-1.5">
                    Sesi Kunjungan Teratur
                </h3>
                <p class="text-[11.5px] sm:text-[12px] text-[#4A3F39] leading-[1.55]">
                    Pembatasan jumlah pengunjung di setiap sesi untuk menjaga kenyamanan bersama kucing.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="tentang-kami" class="bg-[#FFDAE1] py-16 sm:py-24">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-14 items-center">

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

<section id="kucing-favorit" class="bg-white py-16 sm:py-24">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">

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

<section id="feedback" class="bg-white pt-4 pb-16 sm:pt-8 sm:pb-24">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">

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

        <div class="mt-10 sm:mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($displayFeedbacks as $fb)
                <div class="bg-white rounded-[18px] border border-[#8C7E76] px-6 py-5 flex flex-col justify-between min-h-[210px] shadow-[0_2px_6px_rgba(63,50,42,0.04)] hover:border-[#E58B9C] hover:shadow-md transition-all duration-200">

                    <div>
                        <div class="flex items-center gap-1 pb-3.5 border-b border-[#8C7E76]/70">
                            @for($s = 1; $s <= 5; $s++)
                                <i class="fa-solid fa-star text-base {{ $s <= ($fb->bintang ?? 5) ? 'text-[#FCE14B]' : 'text-stone-200' }}"></i>
                            @endfor
                        </div>

                        <p class="py-4 text-sm sm:text-[15px] text-[#3F322A] leading-relaxed">
                            "{{ $fb->teks_saran }}"
                        </p>
                    </div>

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

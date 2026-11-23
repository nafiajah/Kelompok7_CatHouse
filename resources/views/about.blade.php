@extends('layouts.app')

@section('title', 'Tentang Kami - Cat House')

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

    $aboutHeroPhoto = $resolveManualPhoto('about-hero');

    $aboutVisionPhoto = $resolveManualPhoto('about-vision');

    $missions = [
        'Menyediakan lingkungan yang bersih, aman, dan nyaman bagi pengunjung maupun kucing.',
        'Menjaga kesehatan serta kesejahteraan kucing melalui perawatan dan perhatian yang baik.',
        'Menjadi tempat rekreasi yang menyenangkan untuk membangun kedekatan antara manusia dan kucing.',
        'Memberikan pelayanan yang ramah dan membantu agar setiap pengunjung merasa nyaman selama berkunjung ke Cat House.',
    ];
@endphp

@section('content')

<section class="relative w-full min-h-[460px] sm:min-h-[520px] lg:min-h-[560px] flex items-center justify-center overflow-hidden">
    @if($aboutHeroPhoto)
        <img
            src="{{ $aboutHeroPhoto }}"
            alt="Tentang Cat House"
            class="absolute inset-0 w-full h-full object-cover object-center"
        >
        <div class="absolute inset-0 bg-black/45"></div>
    @else

        <div class="absolute inset-0 bg-gradient-to-br from-[#6B5A4E] via-[#514339] to-[#3A2F27]"></div>
        <div class="absolute inset-0 opacity-15" style="background-image: radial-gradient(#FFFFFF 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute bottom-4 right-5 z-20 inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-xs border border-white/25 text-white/90 text-[11px] font-medium">
            <i class="fa-regular fa-image"></i>
            <span>Slot Foto Hero: <code class="font-mono text-white">public/images/about-hero.jpg</code></span>
        </div>
    @endif

    <div class="relative z-10 max-w-4xl mx-auto px-6 sm:px-10 py-16 sm:py-20">
        <h1 class="font-literata font-bold text-white text-center text-4xl sm:text-5xl lg:text-[58px] leading-tight tracking-tight drop-shadow-[0_2px_10px_rgba(0,0,0,0.45)]">
            Tentang Kami
        </h1>

        <div class="mt-6 sm:mt-8 max-w-3xl mx-auto space-y-5 text-white/95 text-sm sm:text-base lg:text-[17px] leading-relaxed font-normal drop-shadow-[0_1px_6px_rgba(0,0,0,0.35)]">
            <p>
                Cat House merupakan tempat rekreasi bagi para pecinta kucing yang ingin menikmati pengalaman berinteraksi secara langsung dengan berbagai kucing menggemaskan. Kami hadir sebagai ruang bagi pengunjung untuk bermain, berkenalan, mengelus, dan menghabiskan waktu bersama kucing dalam suasana yang nyaman dan menyenangkan.
            </p>
            <p>
                Dengan menghadirkan berbagai pilihan ras dan karakter kucing, Cat House berupaya memberikan pengalaman kunjungan yang berkesan bagi setiap pengunjung. Kami juga senantiasa memperhatikan kebersihan lingkungan, kenyamanan pengunjung, serta kesehatan dan kesejahteraan setiap kucing agar tercipta suasana yang aman dan menyenangkan bagi semua.
            </p>
        </div>
    </div>
</section>

<section class="bg-[#FFDAE1] py-14 sm:py-20">
    <div class="max-w-5xl mx-auto px-6 sm:px-10">

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-center">
            <div class="md:col-span-8">
                <h2 class="font-literata font-bold text-[#3F322A] text-3xl sm:text-4xl lg:text-[42px] leading-tight">
                    Our Vision
                </h2>
                <p class="mt-4 text-sm sm:text-[15px] text-[#3F322A] leading-relaxed text-justify font-normal">
                    Menjadi tempat bermain dan berinteraksi dengan kucing yang nyaman, ramah, dan menyenangkan bagi setiap pengunjung. Cat House berkomitmen untuk menghadirkan pengalaman positif sekaligus memperhatikan kebutuhan dan kesejahteraan setiap kucing.
                </p>
            </div>

            <div class="md:col-span-4 flex justify-center md:justify-end">
                <div class="w-full max-w-[240px] sm:max-w-[260px] aspect-[5/4] rounded-[24px] overflow-hidden border-[3px] border-white bg-white/75 shadow-sm">
                    @if($aboutVisionPhoto)
                        <img
                            src="{{ $aboutVisionPhoto }}"
                            alt="Our Vision Cat House"
                            class="w-full h-full object-cover"
                        >
                    @else

                        <div class="w-full h-full border-2 border-dashed border-[#E58B9C] rounded-[21px] bg-white/70 flex flex-col items-center justify-center p-4 text-center text-[#5C4D44]">
                            <div class="w-11 h-11 rounded-full bg-[#FFDAE1] text-[#E58B9C] flex items-center justify-center text-lg mb-2">
                                <i class="fa-regular fa-image"></i>
                            </div>
                            <p class="text-xs font-semibold text-[#3F322A]">Slot Foto Vision</p>
                            <code class="mt-1 px-2 py-0.5 rounded bg-white text-[10px] font-mono text-[#3F322A] border border-[#E58B9C]/40 break-all">images/about-vision.jpg</code>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-10 sm:mt-12 space-y-5">
            @foreach($missions as $mission)
                <div class="flex items-center gap-4 sm:gap-5">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-[#E58B9C] text-white flex items-center justify-center shrink-0 shadow-xs">

                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M5.5 4.5L9.2 8.2C10.05 7.9 11 7.75 12 7.75s1.95.15 2.8.45l3.7-3.7c.4-.4 1.1-.15 1.1.42V13c0 4.14-3.36 7.5-7.6 7.5S4.4 17.14 4.4 13V4.92c0-.57.7-.82 1.1-.42zM9.25 13a1.15 1.15 0 100 2.3 1.15 1.15 0 000-2.3zm5.5 0a1.15 1.15 0 100 2.3 1.15 1.15 0 000-2.3zM12 16.75l-1.1-.95h2.2L12 16.75z"/>
                        </svg>
                    </div>
                    <p class="text-sm sm:text-[15px] text-[#3F322A] leading-relaxed font-medium">
                        {{ $mission }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 sm:py-24">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="font-literata font-semibold text-[#3F322A] text-3xl sm:text-4xl lg:text-[42px] leading-tight">
            Jam Operasional
        </h2>

        <div class="mt-10 sm:mt-12 space-y-8 text-[#3F322A]">
            <div>
                <p class="text-xl sm:text-2xl font-bold tracking-tight">Senin - Minggu</p>
                <p class="mt-2 text-xl sm:text-2xl font-bold tracking-tight">08.00 - 17.00 WITA</p>
            </div>

            <div>
                <p class="text-xl sm:text-2xl font-bold tracking-tight">Jumat</p>
                <p class="mt-2 text-xl sm:text-2xl font-bold tracking-tight">13.00 - 17.00 WITA</p>
            </div>
        </div>
    </div>
</section>
@endsection

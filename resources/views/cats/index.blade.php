@extends('layouts.app')

@section('title', 'Kucing Kami - Cat House')

@section('content')
<section class="bg-white py-10 sm:py-14">
    <div class="max-w-5xl mx-auto px-5 sm:px-8">

        <!-- Header Box: MEET OUR CATS -->
        <div class="max-w-3xl mx-auto mb-12 sm:mb-14 bg-[#FDF1F3] border border-[#8C7E76] rounded-[20px] px-6 sm:px-10 py-7 sm:py-9 text-center shadow-[0_3px_10px_rgba(63,50,42,0.08)]">
            <h1 class="font-literata font-semibold text-[#3F322A] text-3xl sm:text-5xl lg:text-[54px] tracking-wide leading-tight uppercase">
                MEET OUR CATS
            </h1>
            <p class="mt-2 text-sm sm:text-lg lg:text-xl font-medium text-[#7A6B62]">
                Kenali Penghuni Menggemaskan Cat House
            </p>
        </div>

        <!-- 3-Column Dark Espresso Cat Cards (Data & Foto dari Database) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7 lg:gap-9">
            @forelse($cats as $cat)
                <article class="bg-[#413128] rounded-[24px] p-4 pb-6 flex flex-col shadow-[0_6px_18px_rgba(63,50,42,0.14)] hover:-translate-y-1 hover:shadow-[0_10px_24px_rgba(63,50,42,0.18)] transition-all duration-300">
                    <!-- Cat Photo from Database -->
                    <div class="w-full aspect-[4/4.3] rounded-[18px] overflow-hidden bg-[#E39797]">
                        <img
                            src="{{ $cat->foto_url }}"
                            alt="{{ $cat->nama_kucing }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                    </div>

                    <!-- Cat Details -->
                    <div class="pt-4 px-1.5 flex-1 flex flex-col">
                        <h2 class="font-literata font-bold text-white text-xl sm:text-[22px] leading-snug">
                            {{ $cat->nama_kucing }}
                        </h2>

                        <div class="mt-1.5">
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full bg-[#DC8E9B] text-white text-[11px] font-medium">
                                {{ $cat->variant ? $cat->variant->jenis : 'Kucing Cat House' }}
                            </span>
                        </div>

                        <p class="mt-2.5 text-xs text-white/90 leading-relaxed">
                            {{ $cat->deskripsi }}
                        </p>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-16 text-center bg-[#FDF1F3] rounded-[24px] border border-dashed border-[#E58B9C]">
                    <i class="fa-solid fa-cat text-5xl text-[#E58B9C] mb-3"></i>
                    <h3 class="font-literata text-lg font-bold text-[#3F322A]">Belum Ada Data Kucing</h3>
                    <p class="text-xs sm:text-sm text-[#7A6B62] mt-1">Data kucing yang ditambahkan di panel admin akan otomatis tampil di sini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($cats->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $cats->links() }}
            </div>
        @endif

    </div>
</section>
@endsection

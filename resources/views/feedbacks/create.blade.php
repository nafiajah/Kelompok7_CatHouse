@extends('layouts.app')

@section('title', 'Feedback - Cat House')

@section('content')
<section class="bg-white py-10 sm:py-12">
    <div class="max-w-5xl mx-auto px-5 sm:px-8">

        <!-- Outer Rounded Container -->
        <div class="rounded-[28px] border border-[#7A6E68] overflow-hidden shadow-[0_3px_12px_rgba(63,50,42,0.06)]">

            <!-- Top White Header -->
            <div class="bg-white px-6 sm:px-10 py-8 sm:py-10 text-center border-b border-[#7A6E68]">
                <h1 class="font-literata font-bold text-[#3F322A] text-3xl sm:text-4xl lg:text-[42px] leading-tight">
                    Ceritakan Pengalamanmu
                </h1>
                <p class="mt-2.5 text-xs sm:text-sm text-[#6E6259]">
                    Masukanmu membantu kami menjaga Cat House tetap nyaman untuk kucing dan pengunjung.
                </p>
            </div>

            <!-- Bottom Soft Blush Body -->
            <div class="bg-[#FDF1F3] px-5 sm:px-10 py-10 sm:py-14 flex justify-center">

                <!-- Centered White Form Card -->
                <div class="w-full max-w-[460px] bg-white rounded-[22px] border border-[#7A6E68] px-6 sm:px-8 py-7 sm:py-8 shadow-[0_2px_10px_rgba(63,50,42,0.05)]">

                    @if ($errors->any())
                        <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('feedback.store') }}" method="POST" id="feedbackForm">
                        @csrf

                        <!-- 1. Nama Lengkap -->
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-[#3F322A] mb-2.5">
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                name="nama_lengkap"
                                id="nama_lengkap"
                                value="{{ old('nama_lengkap', Auth::check() ? Auth::user()->nama_lengkap : '') }}"
                                placeholder="Masukan nama lengkap Anda"
                                class="w-full px-4 py-2.5 rounded-xl bg-white border border-[#9E9590] text-sm text-[#3F322A] placeholder:text-[#9E9590] shadow-[0_2px_4px_rgba(0,0,0,0.06)] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25"
                            >
                        </div>

                        <hr class="border-t border-[#7A6E68] my-5">

                        <!-- 2. Seberapa Puas Kamu? (Star Boxes) -->
                        <div>
                            <label class="block text-sm font-medium text-[#3F322A] mb-3">
                                Seberapa Puas Kamu?
                            </label>

                            <div class="flex items-center gap-3" id="starContainer">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button
                                        type="button"
                                        onclick="setRating({{ $i }})"
                                        data-rating="{{ $i }}"
                                        aria-label="Rating {{ $i }} bintang"
                                        class="star-box w-10 h-10 rounded-lg border border-[#9E9590] bg-white flex items-center justify-center text-lg text-[#3F322A] hover:border-[#E58B9C] transition cursor-pointer focus:outline-none"
                                    >
                                        <i class="fa-regular fa-star star-icon"></i>
                                    </button>
                                @endfor
                            </div>

                            <input type="hidden" name="bintang" id="bintang" value="{{ old('bintang', '') }}">
                            <p id="ratingHint" class="hidden mt-2 text-xs text-red-600 font-medium">
                                Silakan pilih tingkat kepuasan terlebih dahulu.
                            </p>
                            @error('bintang')
                                <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr class="border-t border-[#7A6E68] my-5">

                        <!-- 3. Pesan -->
                        <div>
                            <label for="teks_saran" class="block text-sm font-medium text-[#3F322A] mb-2.5">
                                Pesan
                            </label>
                            <textarea
                                name="teks_saran"
                                id="teks_saran"
                                rows="4"
                                required
                                placeholder="Apa yang kamu suka, atau apa yang bisa kami perbaiki?"
                                class="w-full px-4 py-3 rounded-xl bg-white border border-[#9E9590] text-sm text-[#3F322A] placeholder:text-[#9E9590] shadow-[0_2px_4px_rgba(0,0,0,0.06)] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 resize-none @error('teks_saran') border-red-500 @enderror"
                            >{{ old('teks_saran') }}</textarea>
                            @error('teks_saran')
                                <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button
                                type="submit"
                                class="w-full py-3 px-5 rounded-xl bg-[#3B2F28] hover:bg-[#2B211C] text-white font-medium text-sm sm:text-[15px] transition shadow-xs cursor-pointer"
                            >
                                Kirim Feedback
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</section>

@include('partials.guest-lock-overlay')
@endsection

@section('scripts')
<script>
    function setRating(rating) {
        const input = document.getElementById('bintang');
        const hint = document.getElementById('ratingHint');
        input.value = rating;
        if (hint) hint.classList.add('hidden');

        document.querySelectorAll('.star-box').forEach(btn => {
            const starRating = parseInt(btn.getAttribute('data-rating'), 10);
            const icon = btn.querySelector('.star-icon');

            if (starRating <= rating) {
                btn.classList.add('border-[#E58B9C]', 'bg-[#FFF5F7]');
                btn.classList.remove('border-[#9E9590]', 'bg-white');
                icon.classList.remove('fa-regular', 'text-[#3F322A]');
                icon.classList.add('fa-solid', 'text-[#E58B9C]');
            } else {
                btn.classList.remove('border-[#E58B9C]', 'bg-[#FFF5F7]');
                btn.classList.add('border-[#9E9590]', 'bg-white');
                icon.classList.remove('fa-solid', 'text-[#E58B9C]');
                icon.classList.add('fa-regular', 'text-[#3F322A]');
            }
        });
    }

    document.getElementById('feedbackForm')?.addEventListener('submit', function (e) {
        const val = parseInt(document.getElementById('bintang').value, 10);
        if (!val || val < 1 || val > 5) {
            e.preventDefault();
            document.getElementById('ratingHint')?.classList.remove('hidden');
        }
    });

    // Restore old rating if validation failed
    const initialRating = parseInt(document.getElementById('bintang').value, 10);
    if (initialRating >= 1 && initialRating <= 5) {
        setRating(initialRating);
    }
</script>
@endsection

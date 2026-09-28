@extends('layouts.app')

@section('title', 'Tulis Ulasan & Saran - Capyca Pet Cafe')

@section('content')
<div class="py-12">
    <div class="max-w-xl mx-auto px-4 sm:px-6">
        
        <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-8 sm:p-10 relative overflow-hidden">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-amber-500 text-white text-3xl flex items-center justify-center mx-auto mb-4 shadow-md">
                    <i class="fa-solid fa-star"></i>
                </div>
                <h1 class="text-2xl font-bold font-playfair text-cafe-brown">Tulis Ulasan Anda</h1>
                <p class="text-sm text-cafe-muted mt-1">Bagikan pengalaman seru Anda saat berkunjung ke Capyca Pet Cafe</p>
            </div>

            <form action="{{ route('feedback.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Star Rating Selection -->
                <div class="text-center">
                    <label class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-3">
                        Beri Penilaian Bintang <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="flex items-center justify-center gap-3 text-3xl text-slate-300" id="starContainer">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" class="star-btn hover:text-amber-400 transition transform hover:scale-125 focus:outline-none" data-rating="{{ $i }}">
                                <i class="fa-solid fa-star"></i>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="bintang" id="bintang" value="{{ old('bintang', 5) }}">
                    <p id="ratingLabel" class="text-xs font-bold text-amber-700 mt-2">5 Bintang (Sempurna & Sangat Puas)</p>
                    @error('bintang')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teks Saran -->
                <div>
                    <label for="teks_saran" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-2">
                        Pesan Ulasan & Saran <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="teks_saran" 
                        id="teks_saran" 
                        rows="5" 
                        required
                        placeholder="Ceritakan tentang kenyamanan kafe, keramahan kucing, dan pelayanan staf kami..." 
                        class="w-full px-4 py-3 rounded-2xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown @error('teks_saran') border-red-500 @enderror"
                    >{{ old('teks_saran') }}</textarea>
                    @error('teks_saran')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-3 bg-amber-50 rounded-2xl text-xs text-amber-800 space-y-1">
                    <p class="font-bold"><i class="fa-solid fa-shield-halved text-amber-600"></i> Informasi:</p>
                    <p>Ulasan Anda akan dimoderasi terlebih dahulu oleh admin sebelum dipublikasikan ke halaman utama.</p>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3.5 px-4 bg-gradient-to-r from-amber-600 to-amber-500 text-white font-bold text-sm rounded-xl shadow-lg hover:from-amber-700 hover:to-amber-600 transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <i class="fa-solid fa-paper-plane"></i> Kirim Ulasan
                </button>
            </form>
        </div>

    </div>
</div>

@section('scripts')
<script>
    const labels = {
        1: "1 Bintang (Kurang Puas)",
        2: "2 Bintang (Cukup)",
        3: "3 Bintang (Baik)",
        4: "4 Bintang (Sangat Baik)",
        5: "5 Bintang (Sempurna & Sangat Puas)"
    };

    function setRating(rating) {
        document.getElementById('bintang').value = rating;
        document.getElementById('ratingLabel').textContent = labels[rating];

        document.querySelectorAll('.star-btn').forEach(btn => {
            const starRating = parseInt(btn.getAttribute('data-rating'));
            if (starRating <= rating) {
                btn.classList.add('text-amber-400');
                btn.classList.remove('text-slate-300');
            } else {
                btn.classList.remove('text-amber-400');
                btn.classList.add('text-slate-300');
            }
        });
    }

    // Initialize with 5 stars
    setRating(parseInt(document.getElementById('bintang').value) || 5);
</script>
@endsection
@endsection

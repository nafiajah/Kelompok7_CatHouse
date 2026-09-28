@extends('layouts.app')

@section('title', 'Daftar Kucing - Capyca Pet Cafe')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-2">Galeri Lengkap</span>
            <h1 class="text-3xl sm:text-5xl font-bold font-playfair text-cafe-brown">Temui Keluarga Anabul Kami</h1>
            <p class="text-sm sm:text-base text-cafe-muted mt-3">
                Semua kucing di Capyca Pet Cafe telah divaksinasi lengkap, rutin mendapatkan perawatan grooming, dan terbiasa berinteraksi ramah dengan manusia.
            </p>
        </div>

        <!-- Search & Filter Controls -->
        <div class="bg-white p-6 rounded-3xl border border-amber-100 shadow-sm mb-10">
            <form action="{{ route('cats.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                <!-- Search Box -->
                <div class="md:col-span-6 relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-cafe-muted text-sm">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama kucing atau ciri-ciri..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown"
                    >
                </div>

                <!-- Variant Dropdown -->
                <div class="md:col-span-4">
                    <select 
                        name="variant" 
                        class="w-full px-4 py-2.5 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown"
                    >
                        <option value="">Semua Ras / Varian</option>
                        @foreach($variants as $variant)
                            <option value="{{ $variant->id }}" {{ request('variant') == $variant->id ? 'selected' : '' }}>
                                {{ $variant->jenis }} ({{ $variant->data_kucing_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-2 flex gap-2">
                    <button type="submit" class="w-full py-2.5 px-4 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl transition shadow-sm flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    @if(request('search') || request('variant'))
                        <a href="{{ route('cats.index') }}" class="py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition flex items-center justify-center" title="Reset filter">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Cats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($cats as $cat)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-amber-100 transition-all duration-300 flex flex-col group">
                    <div class="relative h-64 overflow-hidden bg-amber-50">
                        <img 
                            src="{{ $cat->foto_url }}" 
                            alt="{{ $cat->nama_kucing }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <span class="absolute top-4 right-4 bg-white/95 backdrop-blur-md text-amber-900 font-bold text-xs px-3 py-1 rounded-full shadow-sm">
                            {{ $cat->variant ? $cat->variant->jenis : 'Varian' }}
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-bold font-playfair text-cafe-brown">{{ $cat->nama_kucing }}</h3>
                                <span class="text-xs bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-0.5 rounded-full border border-emerald-200">
                                    Sehat & Ramah
                                </span>
                            </div>
                            <p class="text-sm text-cafe-muted leading-relaxed">
                                {{ $cat->deskripsi }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-amber-50 flex items-center justify-between">
                            <button 
                                onclick="showCatModal('{{ $cat->nama_kucing }}', '{{ $cat->variant ? $cat->variant->jenis : 'Varian' }}', '{{ addslashes($cat->deskripsi) }}', '{{ $cat->foto_url }}')" 
                                class="text-xs font-bold text-cafe-muted hover:text-amber-600 transition flex items-center gap-1"
                            >
                                <i class="fa-regular fa-eye"></i> Detail Lengkap
                            </button>
                            <a href="{{ route('reservasi.create') }}" class="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-sm transition">
                                Ajak Main
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-16 text-center bg-white rounded-3xl border border-dashed border-amber-200">
                    <i class="fa-solid fa-cat text-5xl text-amber-300 mb-3"></i>
                    <h4 class="text-base font-bold text-cafe-brown">Kucing Tidak Ditemukan</h4>
                    <p class="text-xs text-cafe-muted mt-1">Coba gunakan kata kunci pencarian atau ras yang berbeda.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $cats->links() }}
        </div>
    </div>
</div>

<!-- Cat Detail Modal -->
<div id="catModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-amber-100 animate-scale-in">
        <div class="relative h-64 bg-amber-100">
            <img id="modalImg" src="" alt="Kucing" class="w-full h-full object-cover">
            <button onclick="closeCatModal()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center text-lg font-bold shadow-md transition">
                &times;
            </button>
            <span id="modalVariant" class="absolute bottom-4 left-4 bg-amber-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm"></span>
        </div>
        <div class="p-6">
            <h3 id="modalName" class="text-2xl font-bold font-playfair text-cafe-brown mb-2"></h3>
            <p id="modalDesc" class="text-sm text-cafe-muted leading-relaxed mb-6"></p>

            <div class="flex items-center justify-between pt-4 border-t border-amber-100">
                <button onclick="closeCatModal()" class="px-4 py-2 text-xs font-bold text-cafe-muted hover:text-cafe-brown transition">
                    Tutup
                </button>
                <a href="{{ route('reservasi.create') }}" class="px-6 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold shadow-md transition">
                    Pesan Tiket Kunjungan &rarr;
                </a>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function showCatModal(name, variant, desc, img) {
        document.getElementById('modalName').textContent = name;
        document.getElementById('modalVariant').textContent = variant;
        document.getElementById('modalDesc').textContent = desc;
        document.getElementById('modalImg').src = img;
        document.getElementById('catModal').classList.remove('hidden');
    }

    function closeCatModal() {
        document.getElementById('catModal').classList.add('hidden');
    }
</script>
@endsection
@endsection

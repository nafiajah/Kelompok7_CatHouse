@extends('layouts.admin')

@section('title', 'Varian Jenis Kucing - Cat House Admin')
@section('page_title', 'Master Varian Jenis Kucing')

@section('content')
<div class="space-y-6">
    
    <!-- Top Card: Tambah Varian Baru (Full Width Card) -->
    <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-200">
            <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-stone-700">
                TAMBAH VARIAN BARU
            </h3>
        </div>

        <form action="{{ route('admin.variants.store') }}" method="POST" class="p-6 space-y-4 text-xs sm:text-sm">
            @csrf

            <div>
                <label for="jenis" class="block font-bold text-stone-700 mb-1.5 text-xs">
                    Nama/Jenis Kucing <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="jenis" 
                    id="jenis" 
                    value="{{ old('jenis') }}" 
                    required 
                    placeholder="Contoh: Persia, Munchkin" 
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent @error('jenis') border-red-500 @enderror bg-white"
                >
                @error('jenis')
                    <p class="mt-1 text-red-600 font-medium text-xs">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2.5 bg-[#E58B9C] hover:bg-[#D77A8B] text-white font-medium rounded-xl shadow-xs transition flex items-center justify-center gap-1.5 text-sm">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Varian
            </button>
        </form>
    </div>

    <!-- Bottom Card: Daftar Varian Terdaftar (Full Width Card) -->
    <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-200">
            <h3 class="text-base sm:text-lg font-bold text-stone-800">
                Daftar Varian Terdaftar ({{ count($variants) }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-[#EAE5E0] border-b border-stone-200 text-xs font-bold uppercase text-stone-600 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">NAMA JENIS</th>
                        <th class="py-3.5 px-6 text-center">JUMLAH KUCING</th>
                        <th class="py-3.5 px-6 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200">
                    @forelse($variants as $variant)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6 font-semibold text-stone-800 text-sm sm:text-base">
                                {{ $variant->jenis }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-4 py-1.5 rounded-xl bg-[#94BCC1] text-white font-bold text-xs inline-block shadow-2xs">
                                    {{ $variant->data_kucing_count }} Ekor
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <button 
                                        type="button" 
                                        onclick="openEditVariant({{ $variant->id }}, '{{ $variant->jenis }}')"
                                        class="text-stone-700 hover:text-stone-900 transition"
                                        title="Edit Varian"
                                    >
                                        <i class="fa-regular fa-pen-to-square text-lg"></i>
                                    </button>

                                    <form action="{{ route('admin.variants.destroy', $variant->id) }}" method="POST" onsubmit="return confirm('Hapus varian {{ $variant->jenis }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="text-stone-700 hover:text-red-600 transition" 
                                            title="Hapus"
                                        >
                                            <i class="fa-regular fa-trash-can text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-stone-400">
                                Belum ada varian ras kucing yang didaftarkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Edit Variant -->
<div id="editVariantModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-stone-300">
        <h3 class="text-sm font-bold uppercase text-stone-800 mb-4">Edit Nama Varian</h3>
        
        <form id="editVariantForm" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_jenis" class="block font-bold text-stone-700 mb-1">Nama Ras / Jenis</label>
                <input 
                    type="text" 
                    name="jenis" 
                    id="edit_jenis" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent"
                >
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditVariant()" class="px-4 py-2 rounded-xl text-stone-500 font-bold hover:bg-stone-100">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#E58B9C] hover:bg-[#D77A8B] text-white font-bold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function openEditVariant(id, jenis) {
        document.getElementById('editVariantForm').action = '/admin/variants/' + id;
        document.getElementById('edit_jenis').value = jenis;
        document.getElementById('editVariantModal').classList.remove('hidden');
    }

    function closeEditVariant() {
        document.getElementById('editVariantModal').classList.add('hidden');
    }
</script>
@endsection
@endsection

@extends('layouts.admin')

@section('title', 'Varian Jenis Kucing - Admin Capyca')
@section('page_title', 'Master Varian & Ras Kucing')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left: Add Form -->
    <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-3">
            Tambah Varian Baru
        </h3>

        <form action="{{ route('admin.variants.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label for="jenis" class="block font-bold text-slate-700 mb-1.5">
                    Nama Ras / Jenis Kucing <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="jenis" 
                    id="jenis" 
                    value="{{ old('jenis') }}" 
                    required 
                    placeholder="Contoh: Persia, Munchkin, Siam" 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('jenis') border-red-500 @enderror"
                >
                @error('jenis')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-sm transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Tambah Varian
            </button>
        </form>
    </div>

    <!-- Right: List Table -->
    <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-800">Daftar Varian Terdaftar ({{ count($variants) }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase text-slate-500">
                    <tr>
                        <th class="py-3 px-6">ID</th>
                        <th class="py-3 px-6">Nama Ras / Jenis</th>
                        <th class="py-3 px-6">Jumlah Kucing</th>
                        <th class="py-3 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($variants as $variant)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3.5 px-6 font-mono text-slate-400">
                                #{{ $variant->id }}
                            </td>
                            <td class="py-3.5 px-6 font-bold text-slate-800 text-sm">
                                {{ $variant->jenis }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 font-bold text-[11px]">
                                    {{ $variant->data_kucing_count }} Ekor
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        type="button" 
                                        onclick="openEditVariant({{ $variant->id }}, '{{ $variant->jenis }}')"
                                        class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition"
                                        title="Edit Varian"
                                    >
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </button>

                                    <form action="{{ route('admin.variants.destroy', $variant->id) }}" method="POST" onsubmit="return confirm('Hapus varian {{ $variant->jenis }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">
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
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-slate-200">
        <h3 class="text-sm font-bold uppercase text-slate-800 mb-4">Edit Nama Varian</h3>
        
        <form id="editVariantForm" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_jenis" class="block font-bold text-slate-700 mb-1">Nama Ras / Jenis</label>
                <input 
                    type="text" 
                    name="jenis" 
                    id="edit_jenis" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                >
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditVariant()" class="px-4 py-2 rounded-xl text-slate-500 font-bold hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold">
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

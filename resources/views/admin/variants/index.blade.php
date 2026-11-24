@extends('layouts.admin')

@section('title', 'Varian Jenis Kucing - Cat House Admin')
@section('page_title', 'Master Varian Jenis Kucing')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form action="{{ route('admin.variants.index') }}" method="GET" class="flex items-center gap-2 max-w-lg w-full">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama varian jenis kucing..."
                    class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent bg-white shadow-xs"
                >
            </div>
            <button type="submit" class="px-5 py-2.5 bg-[#2E2421] text-white rounded-xl text-xs sm:text-sm font-bold hover:bg-stone-900 transition shadow-xs flex-shrink-0 cursor-pointer">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.variants.index') }}" class="px-4 py-2.5 bg-stone-100 text-stone-600 rounded-xl text-xs sm:text-sm font-bold hover:bg-stone-200 transition flex-shrink-0">
                    Reset
                </a>
            @endif
        </form>

        <button
            type="button"
            onclick="openCreateVariantModal()"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#E58B9C] hover:bg-[#D77487] text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition flex-shrink-0 whitespace-nowrap cursor-pointer"
        >
            <i class="fa-solid fa-plus text-xs"></i> Tambah Varian Baru
        </button>
    </div>

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
                                        onclick="openEditVariantModal(this)"
                                        data-action="{{ route('admin.variants.update', $variant->id) }}"
                                        data-jenis="{{ $variant->jenis }}"
                                        class="text-stone-700 hover:text-stone-900 transition cursor-pointer"
                                        title="Edit Varian"
                                    >
                                        <i class="fa-regular fa-pen-to-square text-lg"></i>
                                    </button>

                                    <form action="{{ route('admin.variants.destroy', $variant->id) }}" method="POST" data-delete-confirm="Apakah Anda yakin ingin menghapus varian &quot;{{ $variant->jenis }}&quot;?">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-stone-700 hover:text-red-600 transition cursor-pointer"
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
                                @if(request('search'))
                                    Tidak ada varian ras kucing yang cocok dengan pencarian "{{ request('search') }}".
                                @else
                                    Belum ada varian ras kucing yang didaftarkan.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<div id="createVariantModal" class="fixed inset-0 z-50 bg-black/45 backdrop-blur-[2px] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[20px] border border-stone-300 shadow-2xl w-full max-w-md overflow-hidden">
        <div class="px-6 sm:px-7 py-5 border-b border-stone-300 flex items-center justify-between">
            <h3 class="text-lg sm:text-xl font-bold text-[#3F322A]">Tambah Varian Jenis</h3>
            <button type="button" onclick="closeCreateVariantModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form action="{{ route('admin.variants.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_modal" value="create_variant">

            <div class="px-6 sm:px-7 py-5 space-y-4">
                @if($errors->any() && old('_modal') === 'create_variant')
                    <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label for="create_jenis" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Nama / Jenis Kucing
                    </label>
                    <input
                        type="text"
                        name="jenis"
                        id="create_jenis"
                        value="{{ old('_modal') === 'create_variant' ? old('jenis') : '' }}"
                        required
                        placeholder="Contoh: Persia, Munchkin"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] placeholder:text-stone-400 focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>
            </div>

            <div class="px-6 sm:px-7 py-4 border-t border-stone-300 flex items-center justify-end gap-3 bg-white">
                <button
                    type="button"
                    onclick="closeCreateVariantModal()"
                    class="px-5 py-2 rounded-lg border border-stone-400 bg-white text-[#3F322A] text-xs sm:text-sm font-medium hover:bg-stone-100 transition cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-5 py-2 rounded-lg bg-[#E58B9C] hover:bg-[#D77487] text-white text-xs sm:text-sm font-medium transition cursor-pointer"
                >
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editVariantModal" class="fixed inset-0 z-50 bg-black/45 backdrop-blur-[2px] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[20px] border border-stone-300 shadow-2xl w-full max-w-md overflow-hidden">
        <div class="px-6 sm:px-7 py-5 border-b border-stone-300 flex items-center justify-between">
            <h3 class="text-lg sm:text-xl font-bold text-[#3F322A]">Edit Varian Jenis</h3>
            <button type="button" onclick="closeEditVariantModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form id="editVariantForm" action="{{ old('_edit_action', '') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="_modal" value="edit_variant">
            <input type="hidden" name="_edit_action" id="edit_variant_action_hidden" value="{{ old('_edit_action', '') }}">

            <div class="px-6 sm:px-7 py-5 space-y-4">
                @if($errors->any() && old('_modal') === 'edit_variant')
                    <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label for="edit_jenis" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Nama / Jenis Kucing
                    </label>
                    <input
                        type="text"
                        name="jenis"
                        id="edit_jenis"
                        value="{{ old('_modal') === 'edit_variant' ? old('jenis') : '' }}"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>
            </div>

            <div class="px-6 sm:px-7 py-4 border-t border-stone-300 flex items-center justify-end gap-3 bg-white">
                <button
                    type="button"
                    onclick="closeEditVariantModal()"
                    class="px-5 py-2 rounded-lg border border-stone-400 bg-white text-[#3F322A] text-xs sm:text-sm font-medium hover:bg-stone-100 transition cursor-pointer"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-5 py-2 rounded-lg bg-[#E58B9C] hover:bg-[#D77487] text-white text-xs sm:text-sm font-medium transition cursor-pointer"
                >
                    Edit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openCreateVariantModal() {
        document.getElementById('createVariantModal').classList.remove('hidden');
    }

    function closeCreateVariantModal() {
        document.getElementById('createVariantModal').classList.add('hidden');
    }

    function openEditVariantModal(btn) {
        const action = btn.getAttribute('data-action');
        const jenis = btn.getAttribute('data-jenis');

        document.getElementById('editVariantForm').action = action;
        document.getElementById('edit_variant_action_hidden').value = action;
        document.getElementById('edit_jenis').value = jenis;
        document.getElementById('editVariantModal').classList.remove('hidden');
    }

    function closeEditVariantModal() {
        document.getElementById('editVariantModal').classList.add('hidden');
    }

    ['createVariantModal', 'editVariantModal'].forEach(function (id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) modal.classList.add('hidden');
            });
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeCreateVariantModal();
            closeEditVariantModal();
        }
    });

    @if($errors->any() && old('_modal') === 'create_variant')
        openCreateVariantModal();
    @elseif($errors->any() && old('_modal') === 'edit_variant')
        document.getElementById('editVariantModal').classList.remove('hidden');
    @endif
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Data Kucing - Cat House Admin')
@section('page_title', 'Manajemen Data Kucing')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form action="{{ route('admin.kucing.index') }}" method="GET" class="flex items-center gap-2 max-w-lg w-full">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau deskripsi kucing..."
                    class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-accent bg-white shadow-xs"
                >
            </div>
            <button type="submit" class="px-5 py-2.5 bg-[#2E2421] text-white rounded-xl text-xs sm:text-sm font-bold hover:bg-stone-900 transition shadow-xs flex-shrink-0 cursor-pointer">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.kucing.index') }}" class="px-4 py-2.5 bg-stone-100 text-stone-600 rounded-xl text-xs sm:text-sm font-bold hover:bg-stone-200 transition flex-shrink-0">
                    Reset
                </a>
            @endif
        </form>

        <button
            type="button"
            onclick="openCreateCatModal()"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#E58B9C] hover:bg-[#D77487] text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition flex-shrink-0 whitespace-nowrap cursor-pointer"
        >
            <i class="fa-solid fa-plus text-xs"></i> Tambah Kucing Baru
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-white text-stone-700 font-bold uppercase text-xs tracking-wider">
                        <th class="py-4 px-6 text-center border-r border-b border-stone-200 w-28">FOTO</th>
                        <th class="py-4 px-6 text-center border-r border-b border-stone-200 whitespace-nowrap">NAMA KUCING</th>
                        <th class="py-4 px-6 text-center border-r border-b border-stone-200 whitespace-nowrap">VARIAN JENIS</th>
                        <th class="py-4 px-6 text-center border-r border-b border-stone-200">DESKRIPSI CIRI &amp; KARAKTER</th>
                        <th class="py-4 px-6 text-center border-b border-stone-200 w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cats as $cat)
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-4 px-6 text-center border-r border-b border-stone-200 align-middle">
                                <img
                                    src="{{ $cat->foto_url }}"
                                    alt="{{ $cat->nama_kucing }}"
                                    class="w-16 h-16 rounded-xl object-cover border border-stone-200 mx-auto shadow-xs"
                                >
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-stone-800 text-sm sm:text-base border-r border-b border-stone-200 align-middle whitespace-nowrap">
                                {{ $cat->nama_kucing }}
                            </td>
                            <td class="py-4 px-6 text-center border-r border-b border-stone-200 align-middle whitespace-nowrap">
                                <span class="px-4 py-1.5 rounded-xl bg-[#F5BFC9] text-[#96384C] font-bold text-xs inline-block shadow-2xs">
                                    {{ $cat->variant ? $cat->variant->jenis : '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-left text-xs text-stone-700 border-r border-b border-stone-200 align-middle leading-relaxed min-w-[280px]">
                                {{ $cat->deskripsi }}
                            </td>
                            <td class="py-4 px-6 text-center border-b border-stone-200 align-middle whitespace-nowrap">
                                <div class="flex items-center justify-center gap-3">
                                    <button
                                        type="button"
                                        onclick="openEditCatModal(this)"
                                        data-id="{{ $cat->id }}"
                                        data-action="{{ route('admin.kucing.update', $cat->id) }}"
                                        data-nama="{{ $cat->nama_kucing }}"
                                        data-variant="{{ $cat->id_variant }}"
                                        data-deskripsi="{{ $cat->deskripsi }}"
                                        data-foto="{{ $cat->foto_url }}"
                                        class="text-stone-700 hover:text-stone-900 transition cursor-pointer"
                                        title="Edit"
                                    >
                                        <i class="fa-regular fa-pen-to-square text-lg"></i>
                                    </button>
                                    <form action="{{ route('admin.kucing.destroy', $cat->id) }}" method="POST" data-delete-confirm="Apakah Anda yakin ingin menghapus data kucing &quot;{{ $cat->nama_kucing }}&quot;?">
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
                            <td colspan="5" class="py-12 text-center text-stone-400 border-b border-stone-200">
                                Belum ada data kucing yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cats->hasPages())
            <div class="p-4 border-t border-stone-200 bg-stone-50/50">
                {{ $cats->links() }}
            </div>
        @endif
    </div>

</div>

<div id="createCatModal" class="fixed inset-0 z-50 bg-black/45 backdrop-blur-[2px] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[20px] border border-stone-300 shadow-2xl w-full max-w-lg overflow-hidden">

        <div class="px-6 sm:px-7 py-5 border-b border-stone-300 flex items-center justify-between">
            <div>
                <h3 class="text-lg sm:text-xl font-bold text-[#3F322A]">Tambah Data Kucing</h3>
                <p class="text-[11px] text-stone-500 mt-0.5">Kolom bertanda <span class="text-red-500 font-bold">*</span> wajib diisi.</p>
            </div>
            <button type="button" onclick="closeCreateCatModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form action="{{ route('admin.kucing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_modal" value="create_cat">

            <div class="px-6 sm:px-7 py-5 space-y-4 max-h-[70vh] overflow-y-auto">
                @if($errors->any() && old('_modal') === 'create_cat')
                    <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label for="create_nama_kucing" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Nama Kucing <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_kucing"
                        id="create_nama_kucing"
                        value="{{ old('_modal') === 'create_cat' ? old('nama_kucing') : '' }}"
                        required
                        placeholder="Contoh: Mochi, Pandan"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] placeholder:text-stone-400 focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>

                <div>
                    <label for="create_id_variant" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Varian Jenis <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            name="id_variant"
                            id="create_id_variant"
                            required
                            class="w-full appearance-none px-3.5 py-2.5 pr-9 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white cursor-pointer"
                        >
                            @foreach($variants as $variant)
                                <option value="{{ $variant->id }}" {{ old('_modal') === 'create_cat' && old('id_variant') == $variant->id ? 'selected' : '' }}>
                                    {{ $variant->jenis }}
                                </option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-3.5 flex items-center text-stone-600 text-xs">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                </div>

                <div>
                    <label for="create_deskripsi" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Deskripsi Ciri &amp; Karakter <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="deskripsi"
                        id="create_deskripsi"
                        rows="4"
                        required
                        placeholder="Contoh: Kucing dengan bulu panjang dan..."
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] placeholder:text-stone-400 focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white resize-none"
                    >{{ old('_modal') === 'create_cat' ? old('deskripsi') : '' }}</textarea>
                </div>

                <div>
                    <label for="create_foto" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Foto <span class="text-red-500">*</span>
                    </label>
                    <div class="rounded-lg border border-stone-400 px-3 py-2 bg-white">
                        <input
                            type="file"
                            name="foto"
                            id="create_foto"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            required
                            onchange="previewCatImage(this, 'createFotoPreviewWrap', 'createFotoPreview')"
                            class="w-full text-xs text-stone-600 file:mr-3 file:py-1 file:px-2.5 file:rounded file:border file:border-stone-400 file:text-xs file:font-medium file:bg-[#FFDAE1] file:text-[#3F322A] hover:file:bg-[#F8BAC7] transition cursor-pointer"
                        >
                        <div id="createFotoPreviewWrap" class="hidden mt-3">
                            <img id="createFotoPreview" src="" alt="Preview Foto" class="w-16 h-16 rounded-lg object-cover border border-stone-200">
                        </div>
                    </div>
                    <div class="mt-2.5 p-3 rounded-xl bg-[#FFF9FA] border border-[#FFDAE1] text-xs text-[#5C4D44] space-y-1">
                        <p class="font-bold text-[#3F322A] flex items-center gap-1.5 text-xs">
                            <i class="fa-solid fa-circle-info text-[#E58B9C]"></i> Ketentuan Format &amp; Ukuran Foto:
                        </p>
                        <ul class="list-disc pl-5 space-y-0.5 text-[11.5px] text-[#5C4D44]">
                            <li><strong>Format yang diterima:</strong> JPG, JPEG, PNG, WEBP</li>
                            <li><strong>Ukuran maksimal:</strong> 3 MB (3.072 KB)</li>
                            <li><strong>Rekomendasi tampilan:</strong> Rasio 1:1 (persegi) atau 4:5 agar tampil proporsional di website</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="px-6 sm:px-7 py-4 border-t border-stone-300 flex items-center justify-end gap-3 bg-white">
                <button
                    type="button"
                    onclick="closeCreateCatModal()"
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

<div id="editCatModal" class="fixed inset-0 z-50 bg-black/45 backdrop-blur-[2px] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[20px] border border-stone-300 shadow-2xl w-full max-w-lg overflow-hidden">

        <div class="px-6 sm:px-7 py-5 border-b border-stone-300 flex items-center justify-between">
            <div>
                <h3 class="text-lg sm:text-xl font-bold text-[#3F322A]">Edit Data Kucing</h3>
                <p class="text-[11px] text-stone-500 mt-0.5">Kolom bertanda <span class="text-red-500 font-bold">*</span> wajib diisi.</p>
            </div>
            <button type="button" onclick="closeEditCatModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form id="editCatForm" action="{{ old('_edit_action', '') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="_modal" value="edit_cat">
            <input type="hidden" name="_edit_action" id="edit_cat_action_hidden" value="{{ old('_edit_action', '') }}">
            <input type="hidden" name="_edit_foto_url" id="edit_cat_foto_hidden" value="{{ old('_edit_foto_url', '') }}">

            <div class="px-6 sm:px-7 py-5 space-y-4 max-h-[70vh] overflow-y-auto">
                @if($errors->any() && old('_modal') === 'edit_cat')
                    <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-0.5">
                        @foreach($errors->all() as $error)
                            <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label for="edit_nama_kucing" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Nama Kucing <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_kucing"
                        id="edit_nama_kucing"
                        value="{{ old('_modal') === 'edit_cat' ? old('nama_kucing') : '' }}"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white"
                    >
                </div>

                <div>
                    <label for="edit_id_variant" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Varian Jenis <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            name="id_variant"
                            id="edit_id_variant"
                            required
                            class="w-full appearance-none px-3.5 py-2.5 pr-9 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white cursor-pointer"
                        >
                            @foreach($variants as $variant)
                                <option value="{{ $variant->id }}" {{ old('_modal') === 'edit_cat' && old('id_variant') == $variant->id ? 'selected' : '' }}>
                                    {{ $variant->jenis }}
                                </option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-3.5 flex items-center text-stone-600 text-xs">
                            <i class="fa-solid fa-chevron-down"></i>
                        </span>
                    </div>
                </div>

                <div>
                    <label for="edit_deskripsi" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Deskripsi Ciri &amp; Karakter <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="deskripsi"
                        id="edit_deskripsi"
                        rows="4"
                        required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-stone-400 text-xs sm:text-sm text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 bg-white resize-none"
                    >{{ old('_modal') === 'edit_cat' ? old('deskripsi') : '' }}</textarea>
                </div>

                <div>
                    <label for="edit_foto" class="block text-xs sm:text-sm font-bold text-[#3F322A] mb-1.5">
                        Foto <span class="text-xs font-normal text-stone-400 lowercase">(opsional jika tidak diganti)</span>
                    </label>
                    <div class="rounded-lg border border-stone-400 p-3 bg-white flex items-center gap-4">
                        <img
                            id="editFotoPreview"
                            src="{{ old('_modal') === 'edit_cat' ? old('_edit_foto_url') : '' }}"
                            alt="Foto Kucing"
                            class="w-16 h-16 rounded-lg object-cover border border-stone-200 shrink-0"
                        >
                        <div class="min-w-0 flex-1">
                            <input
                                type="file"
                                name="foto"
                                id="edit_foto"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                onchange="previewCatImage(this, null, 'editFotoPreview')"
                                class="w-full text-xs text-stone-600 file:mr-2.5 file:py-1 file:px-2.5 file:rounded file:border file:border-stone-400 file:text-xs file:font-medium file:bg-[#FFDAE1] file:text-[#3F322A] hover:file:bg-[#F8BAC7] transition cursor-pointer"
                            >
                            <p class="mt-1 text-[11px] text-stone-400">Kosongkan jika tidak ingin mengganti foto saat ini.</p>
                        </div>
                    </div>
                    <div class="mt-2.5 p-3 rounded-xl bg-[#FFF9FA] border border-[#FFDAE1] text-xs text-[#5C4D44] space-y-1">
                        <p class="font-bold text-[#3F322A] flex items-center gap-1.5 text-xs">
                            <i class="fa-solid fa-circle-info text-[#E58B9C]"></i> Ketentuan Format &amp; Ukuran Foto:
                        </p>
                        <ul class="list-disc pl-5 space-y-0.5 text-[11.5px] text-[#5C4D44]">
                            <li><strong>Format yang diterima:</strong> JPG, JPEG, PNG, WEBP</li>
                            <li><strong>Ukuran maksimal:</strong> 3 MB (3.072 KB)</li>
                            <li><strong>Rekomendasi tampilan:</strong> Rasio 1:1 (persegi) atau 4:5 agar tampil proporsional di website</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="px-6 sm:px-7 py-4 border-t border-stone-300 flex items-center justify-end gap-3 bg-white">
                <button
                    type="button"
                    onclick="closeEditCatModal()"
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
    function openCreateCatModal() {
        document.getElementById('createCatModal').classList.remove('hidden');
    }

    function closeCreateCatModal() {
        document.getElementById('createCatModal').classList.add('hidden');
    }

    function openEditCatModal(btn) {
        const action = btn.getAttribute('data-action');
        const nama = btn.getAttribute('data-nama');
        const variant = btn.getAttribute('data-variant');
        const deskripsi = btn.getAttribute('data-deskripsi');
        const foto = btn.getAttribute('data-foto');

        document.getElementById('editCatForm').action = action;
        document.getElementById('edit_cat_action_hidden').value = action;
        document.getElementById('edit_cat_foto_hidden').value = foto;
        document.getElementById('edit_nama_kucing').value = nama;
        document.getElementById('edit_id_variant').value = variant;
        document.getElementById('edit_deskripsi').value = deskripsi;
        document.getElementById('editFotoPreview').src = foto;
        document.getElementById('edit_foto').value = '';

        document.getElementById('editCatModal').classList.remove('hidden');
    }

    function closeEditCatModal() {
        document.getElementById('editCatModal').classList.add('hidden');
    }

    function previewCatImage(input, wrapId, imgId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById(imgId);
                if (img) img.src = e.target.result;
                if (wrapId) {
                    const wrap = document.getElementById(wrapId);
                    if (wrap) wrap.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    ['createCatModal', 'editCatModal'].forEach(function (id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) modal.classList.add('hidden');
            });
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeCreateCatModal();
            closeEditCatModal();
        }
    });

    @if($errors->any() && old('_modal') === 'create_cat')
        openCreateCatModal();
    @elseif($errors->any() && old('_modal') === 'edit_cat')
        document.getElementById('editCatModal').classList.remove('hidden');
    @endif
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Edit Kucing - Admin Capyca')
@section('page_title', 'Edit Data Kucing')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white p-8 rounded-2xl border border-stone-200 shadow-sm space-y-6">

        <div class="flex items-center justify-between pb-4 border-b border-stone-100">
            <div>
                <h3 class="text-base font-bold text-stone-800">Edit Data: {{ $cat->nama_kucing }}</h3>
                <p class="text-xs text-stone-500 mt-0.5">Kolom bertanda <span class="text-red-500 font-bold">*</span> wajib diisi.</p>
            </div>
            <a href="{{ route('admin.kucing.index') }}" class="text-xs font-bold text-stone-500 hover:text-stone-800">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('admin.kucing.update', $cat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_kucing" class="block font-bold uppercase text-stone-700 mb-1.5">
                    Nama Kucing <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nama_kucing"
                    id="nama_kucing"
                    value="{{ old('nama_kucing', $cat->nama_kucing) }}"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('nama_kucing') border-red-500 @enderror"
                >
                @error('nama_kucing')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="id_variant" class="block font-bold uppercase text-stone-700 mb-1.5">
                    Ras / Varian Jenis <span class="text-red-500">*</span>
                </label>
                <select
                    name="id_variant"
                    id="id_variant"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('id_variant') border-red-500 @enderror"
                >
                    <option value="">Pilih Ras Kucing</option>
                    @foreach($variants as $variant)
                        <option value="{{ $variant->id }}" {{ old('id_variant', $cat->id_variant) == $variant->id ? 'selected' : '' }}>
                            {{ $variant->jenis }}
                        </option>
                    @endforeach
                </select>
                @error('id_variant')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block font-bold uppercase text-stone-700 mb-1.5">
                    Deskripsi Ciri & Kepribadian <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="deskripsi"
                    id="deskripsi"
                    rows="4"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('deskripsi') border-red-500 @enderror"
                >{{ old('deskripsi', $cat->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-bold uppercase text-stone-700 mb-1.5">
                    Foto Saat Ini
                </label>
                <div class="flex items-center gap-4 mb-2">
                    <img src="{{ $cat->foto_url }}" alt="{{ $cat->nama_kucing }}" class="w-20 h-20 rounded-xl object-cover border border-stone-200 shadow-xs">
                    <span class="text-stone-500 text-xs">Kosongkan kolom di bawah jika tidak ingin mengganti foto saat ini.</span>
                </div>

                <label for="foto" class="block font-bold uppercase text-stone-700 mb-1.5">
                    Unggah Foto Baru <span class="text-xs font-normal text-stone-400 lowercase">(opsional jika tidak ingin mengganti foto)</span>
                </label>
                <input
                    type="file"
                    name="foto"
                    id="foto"
                    accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="w-full px-4 py-2 rounded-xl border border-stone-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#FFDAE1] file:text-[#3F322A] hover:file:bg-[#F8BAC7] transition @error('foto') border-red-500 @enderror"
                >
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
                @error('foto')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-stone-100">
                <a href="{{ route('admin.kucing.index') }}" class="px-4 py-2.5 rounded-xl text-stone-600 font-bold hover:bg-stone-100 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-brand-700 hover:bg-brand-800 text-white font-bold rounded-xl shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Edit Kucing - Admin Capyca')
@section('page_title', 'Edit Data Kucing')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-800">Edit Data: {{ $cat->nama_kucing }}</h3>
                <p class="text-xs text-slate-400">Perbarui data atau unggah foto baru jika diperlukan</p>
            </div>
            <a href="{{ route('admin.kucing.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('admin.kucing.update', $cat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_kucing" class="block font-bold uppercase text-slate-700 mb-1.5">
                    Nama Kucing <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="nama_kucing" 
                    id="nama_kucing" 
                    value="{{ old('nama_kucing', $cat->nama_kucing) }}" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('nama_kucing') border-red-500 @enderror"
                >
                @error('nama_kucing')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="id_variant" class="block font-bold uppercase text-slate-700 mb-1.5">
                    Ras / Varian Jenis <span class="text-red-500">*</span>
                </label>
                <select 
                    name="id_variant" 
                    id="id_variant" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('id_variant') border-red-500 @enderror"
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
                <label for="deskripsi" class="block font-bold uppercase text-slate-700 mb-1.5">
                    Deskripsi Ciri & Kepribadian <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="deskripsi" 
                    id="deskripsi" 
                    rows="4" 
                    required 
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 @error('deskripsi') border-red-500 @enderror"
                >{{ old('deskripsi', $cat->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 mb-1.5">
                    Foto Saat Ini
                </label>
                <div class="flex items-center gap-4 mb-2">
                    <img src="{{ $cat->foto_url }}" alt="{{ $cat->nama_kucing }}" class="w-20 h-20 rounded-xl object-cover border border-slate-200 shadow-xs">
                    <span class="text-slate-500 text-xs">Kosongkan kolom di bawah jika tidak ingin mengganti foto saat ini.</span>
                </div>

                <label for="foto" class="block font-bold uppercase text-slate-700 mb-1.5">
                    Unggah Foto Baru (Opsional)
                </label>
                <input 
                    type="file" 
                    name="foto" 
                    id="foto" 
                    accept="image/*" 
                    class="w-full px-4 py-2 rounded-xl border border-slate-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 @error('foto') border-red-500 @enderror"
                >
                <span class="text-[11px] text-slate-400 mt-1 block">Format: JPG, PNG, WEBP. Maksimal 3MB.</span>
                @error('foto')
                    <p class="mt-1 text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.kucing.index') }}" class="px-4 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-slate-100 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Data Kucing - Admin Capyca')
@section('page_title', 'Manajemen Data Kucing')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form action="{{ route('admin.kucing.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama atau deskripsi kucing..." 
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white"
                >
            </div>
            <button type="submit" class="px-3 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.kucing.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.kucing.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
            <i class="fa-solid fa-plus"></i> Tambah Kucing Baru
        </a>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase text-slate-500">
                    <tr>
                        <th class="py-3.5 px-6">Foto</th>
                        <th class="py-3.5 px-6">Nama Kucing</th>
                        <th class="py-3.5 px-6">Ras / Varian</th>
                        <th class="py-3.5 px-6">Deskripsi Ciri & Karakter</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cats as $cat)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 px-6">
                                <img 
                                    src="{{ $cat->foto_url }}" 
                                    alt="{{ $cat->nama_kucing }}" 
                                    class="w-14 h-14 rounded-xl object-cover border border-slate-200 shadow-xs"
                                >
                            </td>
                            <td class="py-3 px-6 font-bold text-slate-800 text-sm">
                                {{ $cat->nama_kucing }}
                            </td>
                            <td class="py-3 px-6">
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-semibold text-[11px]">
                                    {{ $cat->variant ? $cat->variant->jenis : '-' }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-slate-600 max-w-xs truncate" title="{{ $cat->deskripsi }}">
                                {{ $cat->deskripsi }}
                            </td>
                            <td class="py-3 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.kucing.edit', $cat->id) }}" class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.kucing.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kucing {{ $cat->nama_kucing }}?')">
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
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                Belum ada data kucing yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $cats->links() }}
        </div>
    </div>

</div>
@endsection

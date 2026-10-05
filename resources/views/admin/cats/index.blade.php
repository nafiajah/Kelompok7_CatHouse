@extends('layouts.admin')

@section('title', 'Data Kucing - Cat House Admin')
@section('page_title', 'Manajemen Data Kucing')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
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
            <button type="submit" class="px-5 py-2.5 bg-[#2E2421] text-white rounded-xl text-xs sm:text-sm font-bold hover:bg-stone-900 transition shadow-xs flex-shrink-0">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.kucing.index') }}" class="px-4 py-2.5 bg-stone-100 text-stone-600 rounded-xl text-xs sm:text-sm font-bold hover:bg-stone-200 transition flex-shrink-0">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.kucing.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#AA4453] hover:bg-[#963847] text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition flex-shrink-0 whitespace-nowrap">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Kucing Baru
        </a>
    </div>

    <!-- Data Table Card (Full Grid Style) -->
    <div class="bg-white rounded-2xl border border-stone-300 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-white text-stone-700 font-bold uppercase text-xs tracking-wider">
                        <th class="py-4 px-6 text-center border-r border-b border-stone-200 w-28">FOTO</th>
                        <th class="py-4 px-6 text-center border-r border-b border-stone-200 whitespace-nowrap">NAMA KUCING</th>
                        <th class="py-4 px-6 text-center border-r border-b border-stone-200 whitespace-nowrap">VARIAN JENIS</th>
                        <th class="py-4 px-6 text-center border-r border-b border-stone-200">DESKRIPSI CIRI & KARAKTER</th>
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
                                    <a 
                                        href="{{ route('admin.kucing.edit', $cat->id) }}" 
                                        class="text-stone-700 hover:text-stone-900 transition" 
                                        title="Edit"
                                    >
                                        <i class="fa-regular fa-pen-to-square text-lg"></i>
                                    </a>
                                    <form action="{{ route('admin.kucing.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kucing {{ $cat->nama_kucing }}?')">
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
@endsection

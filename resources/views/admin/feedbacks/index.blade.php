@extends('layouts.admin')

@section('title', 'Moderasi Feedback - Admin Capyca')
@section('page_title', 'Moderasi Ulasan & Feedback')

@section('content')
<div class="space-y-6">
    
    <!-- Filter Tabs -->
    <div class="flex items-center gap-2">
        <a 
            href="{{ route('admin.feedbacks.index') }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$status ? 'bg-slate-800 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}"
        >
            Semua Ulasan
        </a>
        <a 
            href="{{ route('admin.feedbacks.index', ['status' => 'tampil']) }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'tampil' ? 'bg-emerald-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}"
        >
            Tampil di Beranda
        </a>
        <a 
            href="{{ route('admin.feedbacks.index', ['status' => 'tidak']) }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'tidak' ? 'bg-amber-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}"
        >
            Menunggu Moderasi
        </a>
    </div>

    <!-- Feedbacks Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase text-slate-500">
                    <tr>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Rating Bintang</th>
                        <th class="py-3.5 px-6">Isi Ulasan & Saran</th>
                        <th class="py-3.5 px-6">Tanggal Kirim</th>
                        <th class="py-3.5 px-6">Status Tampil</th>
                        <th class="py-3.5 px-6 text-right">Aksi Moderasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($feedbacks as $feedback)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800 text-sm">{{ $feedback->user ? $feedback->user->nama_pelanggan : 'Pengunjung' }}</p>
                                <p class="text-slate-400 text-[11px]">{{ $feedback->user ? $feedback->user->email : '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex text-amber-400 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $feedback->bintang ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-[11px] text-slate-400 font-semibold">{{ $feedback->bintang }} dari 5 Bintang</span>
                            </td>
                            <td class="py-4 px-6 text-slate-700 max-w-sm">
                                <p class="line-clamp-3 leading-relaxed italic">
                                    "{{ $feedback->teks_saran }}"
                                </p>
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ \Carbon\Carbon::parse($feedback->tanggal_saran)->translatedFormat('d M Y H:i') }}
                            </td>
                            <td class="py-4 px-6">
                                @if($feedback->status_tampil === 'tampil')
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 font-bold text-[10px] uppercase border border-emerald-200 flex items-center gap-1 w-max">
                                        <i class="fa-solid fa-eye text-xs"></i> Tampil
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px] uppercase border border-slate-200 flex items-center gap-1 w-max">
                                        <i class="fa-solid fa-eye-slash text-xs"></i> Tersembunyi
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Toggle status button -->
                                    <form action="{{ route('admin.feedbacks.toggle', $feedback->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if($feedback->status_tampil === 'tampil')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-800 hover:bg-amber-100 font-bold transition flex items-center gap-1" title="Sembunyikan dari beranda">
                                                <i class="fa-solid fa-eye-slash"></i> Sembunyikan
                                            </button>
                                        @else
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-bold transition flex items-center gap-1" title="Tampilkan di beranda">
                                                <i class="fa-solid fa-eye"></i> Tampilkan
                                            </button>
                                        @endif
                                    </form>

                                    <!-- Delete button -->
                                    <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Ulasan">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Belum ada ulasan feedback dari pengunjung.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $feedbacks->links() }}
        </div>
    </div>

</div>
@endsection

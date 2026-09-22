@extends('layouts.app')

@section('title', 'Riwayat Reservasi - Capyca Pet Cafe')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-playfair text-cafe-brown">Riwayat Reservasi Saya</h1>
                <p class="text-sm text-cafe-muted mt-1">Daftar seluruh tiket kunjungan yang pernah Anda pesan</p>
            </div>
            <a href="{{ route('reservasi.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                <i class="fa-solid fa-plus"></i> Reservasi Baru
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-amber-100 shadow-sm overflow-hidden">
            @if(count($reservations) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-amber-50/70 border-b border-amber-100 text-xs font-bold uppercase text-cafe-brown">
                            <tr>
                                <th class="py-4 px-6">Kode Booking</th>
                                <th class="py-4 px-6">Tanggal & Sesi</th>
                                <th class="py-4 px-6">Tamu</th>
                                <th class="py-4 px-6">Pembayaran</th>
                                <th class="py-4 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-50">
                            @foreach($reservations as $item)
                                <tr class="hover:bg-amber-50/30 transition">
                                    <td class="py-4 px-6 font-mono font-bold text-amber-800 text-xs">
                                        #CPY-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-cafe-brown">{{ \Carbon\Carbon::parse($item->tanggal_reservasi)->translatedFormat('d M Y') }}</p>
                                        <p class="text-xs text-cafe-muted">{{ $item->session ? $item->session->jam_sesi : $item->waktu_reservasi }}</p>
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-cafe-brown">
                                        {{ $item->payment ? $item->payment->jumlah_tamu : 1 }} Orang
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-amber-700 block">Rp {{ number_format($item->payment ? $item->payment->total_harga : 0, 0, ',', '.') }}</span>
                                        <span class="text-[11px] uppercase font-bold text-cafe-muted">{{ $item->payment ? $item->payment->metode_pembayaran : '-' }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <a href="{{ route('reservasi.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold transition">
                                            <i class="fa-solid fa-receipt"></i> Lihat Tiket
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-16 text-center">
                    <i class="fa-solid fa-ticket text-5xl text-amber-200 mb-3"></i>
                    <h3 class="text-base font-bold text-cafe-brown">Belum Ada Riwayat Reservasi</h3>
                    <p class="text-xs text-cafe-muted mt-1 mb-6">Anda belum pernah memesan sesi kunjungan di Capyca Pet Cafe.</p>
                    <a href="{{ route('reservasi.create') }}" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                        Buat Reservasi Pertama Anda
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

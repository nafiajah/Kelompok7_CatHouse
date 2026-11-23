@extends('layouts.admin')

@section('title', 'Data Feedback - Cat House Admin')
@section('page_title', 'Data Feedback')

@section('content')
<div class="space-y-5">

    <div class="flex flex-wrap items-center gap-3">
        <a
            href="{{ route('admin.feedbacks.index') }}"
            class="px-6 py-2.5 rounded-2xl text-xs sm:text-sm font-semibold transition {{ !$status ? 'bg-[#3B2F28] text-white shadow-2xs' : 'bg-white border border-[#7A6E68] text-[#3F322A] hover:bg-[#FFF5F7]' }}"
        >
            Semua Ulasan
        </a>
        <a
            href="{{ route('admin.feedbacks.index', ['status' => 'tampil']) }}"
            class="px-6 py-2.5 rounded-2xl text-xs sm:text-sm font-semibold transition {{ $status === 'tampil' ? 'bg-[#3B2F28] text-white shadow-2xs' : 'bg-white border border-[#7A6E68] text-[#3F322A] hover:bg-[#FFF5F7]' }}"
        >
            Tampil di Beranda
        </a>
        <a
            href="{{ route('admin.feedbacks.index', ['status' => 'tidak']) }}"
            class="px-6 py-2.5 rounded-2xl text-xs sm:text-sm font-semibold transition {{ $status === 'tidak' ? 'bg-[#3B2F28] text-white shadow-2xs' : 'bg-white border border-[#7A6E68] text-[#3F322A] hover:bg-[#FFF5F7]' }}"
        >
            Tidak Tampil
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-[#C7B7B0] shadow-[0_3px_10px_rgba(63,50,42,0.08)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#FFDAE1] text-[#3F322A] text-xs font-bold uppercase tracking-wide border-b border-[#D8B4BC]">
                        <th class="py-4 px-5 text-left border-r border-[#D8B4BC] whitespace-nowrap">PENGUNJUNG</th>
                        <th class="py-4 px-4 text-center border-r border-[#D8B4BC] whitespace-nowrap">RATING BINTANG</th>
                        <th class="py-4 px-5 text-center border-r border-[#D8B4BC] whitespace-nowrap">ISI ULASAN &amp; SARAN</th>
                        <th class="py-4 px-4 text-center border-r border-[#D8B4BC] whitespace-nowrap">TANGGAL KIRIM</th>
                        <th class="py-4 px-4 text-center whitespace-nowrap">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DFD5D1]">
                    @forelse($feedbacks as $feedback)
                        <tr class="hover:bg-[#FFF9FA] transition">

                            <td class="py-5 px-5 text-left border-r border-[#DFD5D1] align-middle whitespace-nowrap">
                                <p class="font-bold text-[#3F322A] text-sm">
                                    {{ $feedback->user ? $feedback->user->nama_lengkap : 'Anonim' }}
                                </p>
                                <p class="text-xs text-[#5C4D44] mt-0.5">
                                    {{ $feedback->user ? $feedback->user->email : '-' }}
                                </p>
                            </td>

                            <td class="py-5 px-4 text-center border-r border-[#DFD5D1] align-middle whitespace-nowrap">
                                <div class="flex items-center justify-center gap-0.5 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= ($feedback->bintang ?? 5) ? 'text-[#FCE14B]' : 'text-stone-200' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-[11px] font-bold text-[#3F322A] mt-1">
                                    {{ $feedback->bintang }} dari 5 Bintang
                                </p>
                            </td>

                            <td class="py-5 px-5 text-left border-r border-[#DFD5D1] align-middle max-w-md min-w-[240px]">
                                <p class="text-xs italic text-[#3F322A] leading-relaxed">
                                    "{{ $feedback->teks_saran }}"
                                </p>
                            </td>

                            <td class="py-5 px-4 text-center border-r border-[#DFD5D1] align-middle text-xs sm:text-sm font-medium text-[#3F322A] whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($feedback->tanggal_saran)->format('d M Y H:i') }}
                            </td>

                            <td class="py-5 px-4 text-center align-middle whitespace-nowrap">
                                <div class="relative inline-block">
                                    <select
                                        onchange="updateFeedbackStatus(this)"
                                        data-url="{{ route('admin.feedbacks.toggle', $feedback->id) }}"
                                        data-prev="{{ $feedback->status_tampil }}"
                                        aria-label="Status tampil feedback"
                                        class="appearance-none bg-white border border-[#3F322A] rounded-lg pl-3.5 pr-8 py-1.5 text-xs font-medium text-[#3F322A] focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 cursor-pointer transition"
                                    >
                                        <option value="tampil" {{ $feedback->status_tampil === 'tampil' ? 'selected' : '' }}>Tampil</option>
                                        <option value="tidak" {{ $feedback->status_tampil !== 'tampil' ? 'selected' : '' }}>Tidak Tampil</option>
                                    </select>
                                    <span class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center text-[#3F322A] text-[10px]">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-stone-400 text-xs sm:text-sm">
                                Belum ada ulasan feedback yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($feedbacks->total() > 0)
        @php
$currentPage = $feedbacks->currentPage();
            $lastPage = max(1, $feedbacks->lastPage());
@endphp
        <div class="flex items-center justify-end gap-2.5 pt-1 text-xs sm:text-sm text-[#3F322A]">
            @if($feedbacks->onFirstPage())
                <span class="w-8 h-8 rounded-md bg-stone-200/80 text-stone-400 flex items-center justify-center cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </span>
            @else
                <a href="{{ $feedbacks->previousPageUrl() }}" class="w-8 h-8 rounded-md bg-stone-200 hover:bg-stone-300 text-[#3F322A] flex items-center justify-center transition">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
            @endif

            <span class="min-w-[32px] h-8 px-2 rounded-md bg-[#FFDAE1] text-[#3F322A] font-semibold flex items-center justify-center">
                {{ $currentPage }}
            </span>

            <span class="text-xs text-[#5C4D44]">of</span>

            <span class="min-w-[32px] h-8 px-2 rounded-md bg-white border border-stone-300 text-[#3F322A] font-semibold flex items-center justify-center">
                {{ $lastPage }}
            </span>

            @if($feedbacks->hasMorePages())
                <a href="{{ $feedbacks->nextPageUrl() }}" class="w-8 h-8 rounded-md bg-stone-200 hover:bg-stone-300 text-[#3F322A] flex items-center justify-center transition">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            @else
                <span class="w-8 h-8 rounded-md bg-stone-200/80 text-stone-400 flex items-center justify-center cursor-not-allowed">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </span>
            @endif

            <span class="ml-1 text-xs sm:text-sm text-[#5C4D44]">
                Page {{ $currentPage }} of {{ $lastPage }}
            </span>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    const feedbackCsrf = "{{ csrf_token() }}";
    const currentFeedbackFilter = "{{ $status ?? '' }}";

    async function updateFeedbackStatus(selectEl) {
        const url = selectEl.getAttribute('data-url');
        const prevVal = selectEl.getAttribute('data-prev');
        const newVal = selectEl.value;
        const row = selectEl.closest('tr');

        selectEl.disabled = true;

        try {
            const response = await fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': feedbackCsrf,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ status_tampil: newVal }),
            });

            if (!response.ok) {
                throw new Error('Gagal memperbarui status feedback');
            }

            const data = await response.json();
            const finalVal = data.status_tampil || newVal;
            selectEl.value = finalVal;
            selectEl.setAttribute('data-prev', finalVal);

            if (row && ((currentFeedbackFilter === 'tampil' && finalVal !== 'tampil') ||
                (currentFeedbackFilter === 'tidak' && finalVal !== 'tidak'))) {
                row.style.transition = 'opacity 180ms ease';
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 190);
            }
        } catch (err) {
            selectEl.value = prevVal;
            console.error(err);
        } finally {
            selectEl.disabled = false;
        }
    }
</script>
@endsection

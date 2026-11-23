@extends('layouts.admin')

@section('title', 'Data Reservasi - Cat House Admin')
@section('page_title', 'Data Reservasi')

@section('content')
<div class="space-y-5">

    <form action="{{ route('admin.reservations.index') }}" method="GET" class="flex items-center gap-3 max-w-2xl">
        @if($status && $status !== 'semua')
            <input type="hidden" name="status" value="{{ $status }}">
        @endif

        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-stone-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari berdasarkan booking number (contoh: #CAT-00001)..."
                class="w-full pl-11 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border border-stone-300 bg-white text-[#3F322A] placeholder:text-stone-400 focus:outline-none focus:border-[#E58B9C] focus:ring-2 focus:ring-[#E58B9C]/25 shadow-2xs"
            >
        </div>

        <button
            type="submit"
            class="px-6 py-2.5 rounded-xl bg-[#3B2F28] hover:bg-[#2B211C] text-white text-xs sm:text-sm font-semibold transition shadow-2xs flex-shrink-0 cursor-pointer"
        >
            Cari
        </button>

        @if($search !== '')
            <a
                href="{{ route('admin.reservations.index', $status !== 'semua' ? ['status' => $status] : []) }}"
                class="px-4 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 text-xs sm:text-sm font-semibold transition flex-shrink-0"
            >
                Reset
            </a>
        @endif
    </form>

    <div class="flex flex-wrap items-center gap-3">
        <a
            href="{{ route('admin.reservations.index', array_filter(['search' => $search])) }}"
            class="px-6 py-2.5 rounded-2xl text-xs sm:text-sm font-semibold transition {{ $status === 'semua' || !$status ? 'bg-[#3B2F28] text-white shadow-2xs' : 'bg-white border border-[#3B2F28] text-[#3B2F28] hover:bg-[#FFF5F7]' }}"
        >
            Semua Reservasi
        </a>
        <a
            href="{{ route('admin.reservations.index', array_filter(['status' => 'sudah', 'search' => $search])) }}"
            class="px-6 py-2.5 rounded-2xl text-xs sm:text-sm font-semibold transition {{ $status === 'sudah' ? 'bg-[#3B2F28] text-white shadow-2xs' : 'bg-white border border-[#3B2F28] text-[#3B2F28] hover:bg-[#FFF5F7]' }}"
        >
            Sudah Konfirmasi
        </a>
        <a
            href="{{ route('admin.reservations.index', array_filter(['status' => 'belum', 'search' => $search])) }}"
            class="px-6 py-2.5 rounded-2xl text-xs sm:text-sm font-semibold transition {{ $status === 'belum' ? 'bg-[#3B2F28] text-white shadow-2xs' : 'bg-white border border-[#3B2F28] text-[#3B2F28] hover:bg-[#FFF5F7]' }}"
        >
            Belum Konfirmasi
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-[#C7B7B0] shadow-[0_3px_10px_rgba(63,50,42,0.08)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-center text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-[#FFDAE1] text-[#3F322A] text-xs font-bold uppercase tracking-wide border-b border-[#D8B4BC]">
                        <th class="py-4 px-4 border-r border-[#D8B4BC] whitespace-nowrap">BOOKING CODE</th>
                        <th class="py-4 px-4 border-r border-[#D8B4BC] whitespace-nowrap">NAMA</th>
                        <th class="py-4 px-4 border-r border-[#D8B4BC] whitespace-nowrap">TANGGAL &amp; Jam</th>
                        <th class="py-4 px-4 border-r border-[#D8B4BC] whitespace-nowrap">SESI</th>
                        <th class="py-4 px-4 border-r border-[#D8B4BC] whitespace-nowrap">ORANG</th>
                        <th class="py-4 px-4 border-r border-[#D8B4BC] whitespace-nowrap">TOTAL HARGA</th>
                        <th class="py-4 px-4 whitespace-nowrap">KONFIRMASI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#DFD5D1]">
                    @forelse($reservations as $res)
                        @php
$kode = '#CAT-' . str_pad($res->id, 5, '0', STR_PAD_LEFT);
                            $tglShort = \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d M Y');
                            $tglIndo = \Carbon\Carbon::parse($res->tanggal_reservasi)->locale('id')->translatedFormat('l, d F Y');
                            $jamSesi = $res->session ? str_replace(':', '.', $res->session->jam_sesi) : substr((string) $res->waktu_reservasi, 0, 5);
                            $tamuCount = max(1, (int) ($res->jumlah_tamu ?? 1));
                            $hargaSatuan = $res->total_harga > 0 ? (int) round($res->total_harga / $tamuCount) : 25000;
                            $isConfirmed = ($res->status_konfirmasi ?? 'belum') === 'sudah';
@endphp
                        <tr class="hover:bg-[#FFF9FA] transition">

                            <td class="py-5 px-4 border-r border-[#DFD5D1] whitespace-nowrap">
                                <button
                                    type="button"
                                    onclick="openReservationDetailModal(this)"
                                    data-kode="{{ $kode }}"
                                    data-nama="{{ $res->user ? $res->user->nama_lengkap : '-' }}"
                                    data-email="{{ $res->user ? $res->user->email : '-' }}"
                                    data-telp="{{ $res->user ? $res->user->no_telp : '-' }}"
                                    data-tanggal="{{ $tglIndo }}"
                                    data-sesi="{{ $res->session ? $res->session->jam_sesi : $res->waktu_reservasi }}"
                                    data-tamu="{{ $tamuCount }} Orang"
                                    data-satuan="Rp {{ number_format($hargaSatuan, 0, ',', '.') }}"
                                    data-total="Rp {{ number_format($res->total_harga ?? 0, 0, ',', '.') }}"
                                    data-status="{{ $isConfirmed ? 'Sudah Terkonfirmasi' : 'Belum Dikonfirmasi' }}"
                                    data-delete-action="{{ route('admin.reservations.destroy', $res->id) }}"
                                    class="font-semibold text-[#E58B9C] hover:text-[#D77487] hover:underline transition cursor-pointer"
                                    title="Klik untuk melihat detail reservasi"
                                >
                                    {{ $kode }}
                                </button>
                            </td>

                            <td class="py-5 px-4 border-r border-[#DFD5D1] font-bold text-[#3F322A] uppercase">
                                {{ $res->user ? $res->user->nama_lengkap : '-' }}
                            </td>

                            <td class="py-5 px-4 border-r border-[#DFD5D1] text-[#3F322A] whitespace-nowrap">
                                <p class="font-medium leading-snug">{{ $tglShort }}</p>
                                <p class="text-xs text-[#5C4D44] mt-0.5">{{ $jamSesi }}</p>
                            </td>

                            <td class="py-5 px-4 border-r border-[#DFD5D1] font-medium text-[#3F322A] whitespace-nowrap">
                                1 Sesi
                            </td>

                            <td class="py-5 px-4 border-r border-[#DFD5D1] font-medium text-[#3F322A] whitespace-nowrap">
                                {{ $tamuCount }} Orang
                            </td>

                            <td class="py-5 px-4 border-r border-[#DFD5D1] font-medium text-[#3F322A] whitespace-nowrap">
                                Rp {{ number_format($res->total_harga ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="py-5 px-4 whitespace-nowrap">
                                <button
                                    type="button"
                                    onclick="toggleReservationStatus(this)"
                                    data-url="{{ route('admin.reservations.toggle', $res->id) }}"
                                    data-status="{{ $isConfirmed ? 'sudah' : 'belum' }}"
                                    title="{{ $isConfirmed ? 'Klik untuk ubah menjadi Belum' : 'Klik untuk tandai Sudah Konfirmasi' }}"
                                    class="px-5 py-1.5 rounded-full text-xs font-semibold transition cursor-pointer {{ $isConfirmed ? 'bg-[#94BCC1] hover:bg-[#7FA9AE] text-white' : 'bg-[#D9D5D2] hover:bg-[#C7C1BD] text-[#3F322A]' }}"
                                >
                                    {{ $isConfirmed ? 'Sudah' : 'Belum' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-stone-400 text-xs sm:text-sm">
                                Tidak ada data reservasi yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($reservations->total() > 0)
        @php
$currentPage = $reservations->currentPage();
            $lastPage = max(1, $reservations->lastPage());
@endphp
        <div class="flex items-center justify-end gap-2.5 pt-1 text-xs sm:text-sm text-[#3F322A]">

            @if($reservations->onFirstPage())
                <span class="w-8 h-8 rounded-md bg-stone-200/80 text-stone-400 flex items-center justify-center cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </span>
            @else
                <a href="{{ $reservations->previousPageUrl() }}" class="w-8 h-8 rounded-md bg-stone-200 hover:bg-stone-300 text-[#3F322A] flex items-center justify-center transition">
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

            @if($reservations->hasMorePages())
                <a href="{{ $reservations->nextPageUrl() }}" class="w-8 h-8 rounded-md bg-stone-200 hover:bg-stone-300 text-[#3F322A] flex items-center justify-center transition">
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

<div id="detailReservationModal" class="fixed inset-0 z-50 bg-black/45 backdrop-blur-[2px] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[20px] border border-stone-300 shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="px-6 sm:px-7 py-5 border-b border-stone-300 flex items-center justify-between">
            <h3 class="text-lg sm:text-xl font-bold text-[#3F322A]">Detail Data Reservasi</h3>
            <button type="button" onclick="closeReservationDetailModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div class="px-6 sm:px-7 py-5 space-y-4 text-xs sm:text-sm max-h-[70vh] overflow-y-auto">
            <div class="grid grid-cols-2 gap-4 pb-4 border-b border-stone-200">
                <div>
                    <p class="text-[11px] font-bold text-stone-400 uppercase">Booking Code</p>
                    <p id="detail_res_kode" class="mt-1 font-mono font-bold text-[#E58B9C]"></p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-stone-400 uppercase">Status Konfirmasi</p>
                    <p id="detail_res_status" class="mt-1 font-semibold text-[#3F322A]"></p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-stone-400 uppercase">Nama Pelanggan</p>
                    <p id="detail_res_nama" class="mt-1 font-semibold text-[#3F322A]"></p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-stone-400 uppercase">No. Telepon</p>
                    <p id="detail_res_telp" class="mt-1 font-medium text-[#3F322A]"></p>
                </div>
                <div class="col-span-2">
                    <p class="text-[11px] font-bold text-stone-400 uppercase">Email</p>
                    <p id="detail_res_email" class="mt-1 font-medium text-[#3F322A]"></p>
                </div>
            </div>

            <div class="rounded-xl bg-[#FDF1F3] border border-[#E58B9C]/40 p-4 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-stone-500">Tanggal Kunjungan</span>
                    <span id="detail_res_tanggal" class="font-bold text-[#3F322A]"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-stone-500">Jam Sesi (30 Menit)</span>
                    <span id="detail_res_sesi" class="font-bold text-[#3F322A]"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-stone-500">Jumlah Tamu</span>
                    <span id="detail_res_tamu" class="font-bold text-[#3F322A]"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-stone-500">Harga per Tamu</span>
                    <span id="detail_res_satuan" class="font-semibold text-[#3F322A]"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-stone-500">Metode Pembayaran</span>
                    <span class="font-semibold text-[#3F322A]">Di Tempat</span>
                </div>
                <div class="pt-2 border-t border-[#E58B9C]/35 flex items-center justify-between text-base">
                    <span class="font-bold text-[#3F322A]">Total Harga</span>
                    <span id="detail_res_total" class="font-extrabold text-[#E58B9C]"></span>
                </div>
            </div>
        </div>

        <div class="px-6 sm:px-7 py-4 border-t border-stone-300 flex items-center justify-between bg-white">
            <form id="detailDeleteResForm" method="POST" data-delete-confirm="Apakah Anda yakin ingin menghapus data reservasi ini?">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg text-xs sm:text-sm font-medium text-red-600 hover:bg-red-50 transition cursor-pointer inline-flex items-center gap-1.5"
                >
                    <i class="fa-regular fa-trash-can"></i> Hapus
                </button>
            </form>
            <button
                type="button"
                onclick="closeReservationDetailModal()"
                class="px-5 py-2 rounded-lg border border-stone-400 bg-white text-[#3F322A] text-xs sm:text-sm font-medium hover:bg-stone-100 transition cursor-pointer"
            >
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const csrfToken = "{{ csrf_token() }}";
    const currentStatusFilter = "{{ $status }}";

    function applyToggleButtonStyle(btn, status) {
        btn.setAttribute('data-status', status);
        if (status === 'sudah') {
            btn.textContent = 'Sudah';
            btn.title = 'Klik untuk ubah menjadi Belum';
            btn.classList.remove('bg-[#D9D5D2]', 'hover:bg-[#C7C1BD]', 'text-[#3F322A]');
            btn.classList.add('bg-[#94BCC1]', 'hover:bg-[#7FA9AE]', 'text-white');
        } else {
            btn.textContent = 'Belum';
            btn.title = 'Klik untuk tandai Sudah Konfirmasi';
            btn.classList.remove('bg-[#94BCC1]', 'hover:bg-[#7FA9AE]', 'text-white');
            btn.classList.add('bg-[#D9D5D2]', 'hover:bg-[#C7C1BD]', 'text-[#3F322A]');
        }
    }

    async function toggleReservationStatus(btn) {
        if (btn.disabled) return;

        const url = btn.getAttribute('data-url');
        const prevStatus = btn.getAttribute('data-status') || 'belum';
        const optimisticStatus = prevStatus === 'sudah' ? 'belum' : 'sudah';
        const row = btn.closest('tr');

        btn.disabled = true;
        applyToggleButtonStyle(btn, optimisticStatus);

        try {
            const response = await fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                throw new Error('Gagal memperbarui status');
            }

            const data = await response.json();
            const finalStatus = data.status_konfirmasi || optimisticStatus;
            applyToggleButtonStyle(btn, finalStatus);

            if (row) {
                const detailBtn = row.querySelector('button[data-kode]');
                if (detailBtn) {
                    detailBtn.setAttribute('data-status', finalStatus === 'sudah' ? 'Sudah Terkonfirmasi' : 'Belum Dikonfirmasi');
                }

                if ((currentStatusFilter === 'sudah' && finalStatus !== 'sudah') ||
                    (currentStatusFilter === 'belum' && finalStatus !== 'belum')) {
                    row.style.transition = 'opacity 180ms ease';
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 190);
                }
            }
        } catch (err) {

            applyToggleButtonStyle(btn, prevStatus);
            console.error(err);
        } finally {
            btn.disabled = false;
        }
    }

    function openReservationDetailModal(btn) {
        const kode = btn.getAttribute('data-kode');
        document.getElementById('detail_res_kode').textContent = kode;
        document.getElementById('detail_res_status').textContent = btn.getAttribute('data-status');
        document.getElementById('detail_res_nama').textContent = btn.getAttribute('data-nama');
        document.getElementById('detail_res_email').textContent = btn.getAttribute('data-email');
        document.getElementById('detail_res_telp').textContent = btn.getAttribute('data-telp');
        document.getElementById('detail_res_tanggal').textContent = btn.getAttribute('data-tanggal');
        document.getElementById('detail_res_sesi').textContent = btn.getAttribute('data-sesi');
        document.getElementById('detail_res_tamu').textContent = btn.getAttribute('data-tamu');
        document.getElementById('detail_res_satuan').textContent = btn.getAttribute('data-satuan');
        document.getElementById('detail_res_total').textContent = btn.getAttribute('data-total');

        const delForm = document.getElementById('detailDeleteResForm');
        if (delForm) {
            delForm.action = btn.getAttribute('data-delete-action');
            delForm.setAttribute('data-delete-confirm', `Apakah Anda yakin ingin menghapus data reservasi ${kode}?`);
        }

        document.getElementById('detailReservationModal').classList.remove('hidden');
    }

    function closeReservationDetailModal() {
        document.getElementById('detailReservationModal').classList.add('hidden');
    }

    const detailResModal = document.getElementById('detailReservationModal');
    if (detailResModal) {
        detailResModal.addEventListener('click', function (e) {
            if (e.target === detailResModal) closeReservationDetailModal();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeReservationDetailModal();
    });
</script>
@endsection

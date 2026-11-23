@extends('layouts.app')

@section('title', 'Reservasi - Pilih Tanggal & Waktu | Cat House')

@section('content')
<section class="bg-white py-10 sm:py-14">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-0 items-start">

            <!-- ===================================================
                 LEFT COLUMN: PILIH TANGGAL (Custom Calendar)
                 =================================================== -->
            <div class="lg:col-span-5 lg:pr-10 lg:border-r lg:border-[#8C7E76]/70">
                <div class="flex items-center gap-3 mb-5">
                    <span class="text-[#3F322A] text-2xl">
                        <i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <h1 class="font-literata text-[26px] sm:text-[28px] font-medium text-[#3F322A] leading-tight">
                        Pilih Tanggal
                    </h1>
                </div>

                <!-- Calendar Card -->
                <div class="bg-white rounded-[20px] border border-[#9E9590] p-5 sm:p-6 shadow-[0_2px_8px_rgba(63,50,42,0.05)]">
                    <!-- Month & Year Header + Navigation -->
                    <div class="flex items-center justify-between mb-5">
                        <h2 id="calendarMonthLabel" class="font-literata text-[22px] sm:text-[24px] font-normal text-[#3F322A]">
                            <!-- Filled by JS -->
                        </h2>
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                id="prevMonthBtn"
                                aria-label="Bulan sebelumnya"
                                class="w-8 h-8 rounded-full flex items-center justify-center text-[#3F322A] hover:bg-[#FFDAE1]/60 transition cursor-pointer"
                            >
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <button
                                type="button"
                                id="nextMonthBtn"
                                aria-label="Bulan berikutnya"
                                class="w-8 h-8 rounded-full flex items-center justify-center text-[#3F322A] hover:bg-[#FFDAE1]/60 transition cursor-pointer"
                            >
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Day Names (Mo - Su) -->
                    <div class="grid grid-cols-7 text-center text-xs font-bold text-[#3F322A] mb-2">
                        <span>Mo</span>
                        <span>Tu</span>
                        <span>We</span>
                        <span>Th</span>
                        <span>Fr</span>
                        <span>Sa</span>
                        <span>Su</span>
                    </div>

                    <!-- Calendar Date Grid -->
                    <div id="calendarGrid" class="grid grid-cols-7 border-t border-l border-[#9E9590]">
                        <!-- Filled by JS -->
                    </div>
                </div>

                <!-- Compact Pricing & Duration Info -->
                <div class="mt-5 rounded-2xl bg-[#FFF5F7] border border-[#E58B9C]/35 px-4 py-3.5 text-xs text-[#3F322A] space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[#5C4D44]">Weekday (Senin – Jumat)</span>
                        <span class="font-semibold">Rp {{ number_format($hargaWeekday, 0, ',', '.') }} / tamu</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#5C4D44]">Weekend (Sabtu – Minggu)</span>
                        <span class="font-semibold text-[#D77487]">Rp {{ number_format($hargaWeekend, 0, ',', '.') }} / tamu</span>
                    </div>
                    <div class="flex items-center justify-between pt-1 border-t border-[#E58B9C]/25">
                        <span class="text-[#5C4D44]">Durasi per Sesi</span>
                        <span class="font-semibold">{{ $durasiMenit }} Menit</span>
                    </div>
                </div>
            </div>

            <!-- ===================================================
                 RIGHT COLUMN: PILIH WAKTU (30-Minute Session Slots)
                 =================================================== -->
            <div class="lg:col-span-7 lg:pl-12">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                    <div class="flex items-center gap-3">
                        <span class="text-[#3F322A] text-2xl">
                            <i class="fa-regular fa-clock"></i>
                        </span>
                        <h2 class="font-literata text-[26px] sm:text-[28px] font-medium text-[#3F322A] leading-tight">
                            Pilih Waktu
                        </h2>
                    </div>

                    <span id="selectedDayRateBadge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FFDAE1] text-[#3F322A]">
                        <!-- Filled by JS -->
                    </span>
                </div>

                <p id="selectedDateSummary" class="text-xs sm:text-sm text-[#5C4D44] mb-6">
                    <!-- Filled by JS -->
                </p>

                <!-- Time Slots Grid -->
                <div id="timeSlotsGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-5">
                    <!-- Filled by JS -->
                </div>

                <!-- Empty / Passed Notice -->
                <div id="noSlotsNotice" class="hidden mt-4 p-4 rounded-2xl bg-[#FFF5F7] border border-[#E58B9C]/40 text-xs sm:text-sm text-[#5C4D44] text-center">
                    <i class="fa-regular fa-calendar-xmark text-[#E58B9C] mr-1.5"></i>
                    Semua sesi pada tanggal ini sudah lewat atau penuh. Silakan pilih tanggal lain di kalender.
                </div>

                <!-- Validation Notice -->
                <p id="selectSlotWarning" class="hidden mt-4 text-xs sm:text-sm font-medium text-red-600 text-center">
                    Silakan pilih salah satu waktu sesi terlebih dahulu sebelum melanjutkan.
                </p>

                <!-- Step 1 -> Step 2 Form -->
                <form id="proceedDetailForm" action="{{ route('reservasi.detail') }}" method="GET" class="mt-8">
                    <input type="hidden" name="tanggal" id="selectedDateInput" value="{{ $selectedDate }}">
                    <input type="hidden" name="sesi" id="selectedSessionInput" value="{{ $preselectedSessionId }}">

                    <button
                        type="submit"
                        id="proceedDetailBtn"
                        class="w-full py-3.5 px-6 rounded-xl bg-[#E58B9C] hover:bg-[#D77487] text-white font-medium text-base transition-all duration-200 shadow-xs cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Lanjut Ke Detail
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

@include('partials.guest-lock-overlay')
@endsection

@section('scripts')
<script>
    (function () {
        const availabilityUrl = "{{ route('reservasi.availability') }}";
        const todayStr = "{{ now()->format('Y-m-d') }}";
        const initialData = @json($initialData);

        let selectedDate = "{{ $selectedDate }}";
        let selectedSessionId = "{{ $preselectedSessionId }}" ? Number("{{ $preselectedSessionId }}") : null;
        let currentSlots = initialData.slots || [];

        const initialParts = selectedDate.split('-').map(Number);
        let viewYear = initialParts[0];
        let viewMonth = initialParts[1] - 1; // 0-indexed

        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        const dayNamesId = [
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];

        const monthLabelEl = document.getElementById('calendarMonthLabel');
        const calendarGridEl = document.getElementById('calendarGrid');
        const timeSlotsGridEl = document.getElementById('timeSlotsGrid');
        const noSlotsNoticeEl = document.getElementById('noSlotsNotice');
        const selectSlotWarningEl = document.getElementById('selectSlotWarning');
        const selectedDateSummaryEl = document.getElementById('selectedDateSummary');
        const selectedDayRateBadgeEl = document.getElementById('selectedDayRateBadge');
        const selectedDateInputEl = document.getElementById('selectedDateInput');
        const selectedSessionInputEl = document.getElementById('selectedSessionInput');
        const proceedForm = document.getElementById('proceedDetailForm');
        const prevMonthBtn = document.getElementById('prevMonthBtn');
        const nextMonthBtn = document.getElementById('nextMonthBtn');

        function pad2(n) {
            return String(n).padStart(2, '0');
        }

        function formatIsoDate(year, monthIndex, day) {
            return `${year}-${pad2(monthIndex + 1)}-${pad2(day)}`;
        }

        function formatDateIndonesia(isoStr) {
            const [y, m, d] = isoStr.split('-').map(Number);
            const dt = new Date(y, m - 1, d);
            return `${dayNamesId[dt.getDay()]}, ${d} ${monthNames[m - 1]} ${y}`;
        }

        function renderCalendar() {
            monthLabelEl.textContent = `${monthNames[viewMonth]} ${viewYear}`;
            calendarGridEl.innerHTML = '';

            const firstDayOfMonth = new Date(viewYear, viewMonth, 1);
            // Convert JS getDay() (0=Sun..6=Sat) -> Monday-first index (0=Mon..6=Sun)
            const startOffset = (firstDayOfMonth.getDay() + 6) % 7;
            const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(viewYear, viewMonth, 0).getDate();

            const totalCells = Math.ceil((startOffset + daysInMonth) / 7) * 7;

            for (let cellIndex = 0; cellIndex < totalCells; cellIndex++) {
                let cellYear = viewYear;
                let cellMonth = viewMonth;
                let cellDay;
                let isOtherMonth = false;

                if (cellIndex < startOffset) {
                    isOtherMonth = true;
                    cellDay = daysInPrevMonth - startOffset + cellIndex + 1;
                    cellMonth = viewMonth - 1;
                    if (cellMonth < 0) {
                        cellMonth = 11;
                        cellYear -= 1;
                    }
                } else if (cellIndex >= startOffset + daysInMonth) {
                    isOtherMonth = true;
                    cellDay = cellIndex - (startOffset + daysInMonth) + 1;
                    cellMonth = viewMonth + 1;
                    if (cellMonth > 11) {
                        cellMonth = 0;
                        cellYear += 1;
                    }
                } else {
                    cellDay = cellIndex - startOffset + 1;
                }

                const cellIso = formatIsoDate(cellYear, cellMonth, cellDay);
                const isPast = cellIso < todayStr;
                const isSelected = cellIso === selectedDate;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = cellDay;
                btn.dataset.date = cellIso;

                let baseClasses = 'aspect-square border-r border-b border-[#9E9590] flex items-center justify-center text-xs sm:text-[13px] transition-colors select-none ';

                if (isSelected) {
                    baseClasses += 'bg-[#E58B9C] text-white font-semibold cursor-pointer';
                } else if (isPast) {
                    baseClasses += isOtherMonth
                        ? 'bg-[#FFDAE1]/55 text-[#3F322A]/35 cursor-not-allowed'
                        : 'bg-stone-50 text-stone-300 cursor-not-allowed';
                } else if (isOtherMonth) {
                    baseClasses += 'bg-[#FFDAE1] text-[#3F322A]/85 hover:bg-[#F5C5CF] cursor-pointer';
                } else {
                    baseClasses += 'bg-white text-[#3F322A] hover:bg-[#FFF0F3] cursor-pointer';
                }

                btn.className = baseClasses;

                if (isPast) {
                    btn.disabled = true;
                } else {
                    btn.addEventListener('click', function () {
                        selectDate(cellIso, cellYear, cellMonth);
                    });
                }

                calendarGridEl.appendChild(btn);
            }
        }

        function renderHeaderInfo(data) {
            const labelDayType = data.is_weekend ? 'Weekend' : 'Weekday';
            const formattedPrice = 'Rp ' + Number(data.harga_per_tamu).toLocaleString('id-ID');
            selectedDayRateBadgeEl.textContent = `${labelDayType} • ${formattedPrice} / tamu`;

            let summaryText = `${formatDateIndonesia(data.tanggal)} • 1 Sesi ${data.durasi_menit} Menit`;
            if (data.is_friday) {
                summaryText += ' • Khusus Jumat mulai pukul 13.00 WITA';
            }
            selectedDateSummaryEl.textContent = summaryText;
        }

        function renderSlots(data) {
            currentSlots = data.slots || [];
            timeSlotsGridEl.innerHTML = '';
            renderHeaderInfo(data);

            // Reset selectedSessionId if no longer valid/available
            const stillValid = currentSlots.some(s => s.id === selectedSessionId && s.available);
            if (!stillValid) {
                selectedSessionId = null;
                selectedSessionInputEl.value = '';
            }

            let availableCount = 0;

            currentSlots.forEach(slot => {
                if (slot.available) {
                    availableCount++;
                }

                const isSelected = slot.id === selectedSessionId && slot.available;

                const card = document.createElement('button');
                card.type = 'button';
                card.dataset.sessionId = slot.id;

                let cardClasses = 'rounded-[20px] px-4 py-5 flex flex-col items-center justify-center text-center transition-all duration-150 ';

                if (!slot.available) {
                    cardClasses += 'border border-stone-200 bg-stone-50 opacity-55 cursor-not-allowed';
                    card.disabled = true;
                } else if (isSelected) {
                    cardClasses += 'border-2 border-[#E58B9C] bg-[#FFF5F7] shadow-sm ring-2 ring-[#E58B9C]/25 cursor-pointer';
                } else {
                    cardClasses += 'border border-[#B5ADA8] bg-white hover:border-[#E58B9C] hover:bg-[#FFF9FA] hover:shadow-xs cursor-pointer';
                }

                card.className = cardClasses;

                let pillText = `${slot.remaining} tersisa`;
                let pillClass = 'bg-[#E58B9C] text-white';

                if (slot.is_past) {
                    pillText = 'Sudah lewat';
                    pillClass = 'bg-stone-300 text-stone-600';
                } else if (slot.is_full) {
                    pillText = 'Penuh';
                    pillClass = 'bg-stone-400 text-white';
                }

                card.innerHTML = `
                    <span class="text-2xl sm:text-[26px] font-bold text-[#3F322A] tracking-tight leading-none">
                        ${slot.display_time}
                    </span>
                    <span class="text-[11px] text-[#7A6B62] mt-1 mb-2.5">
                        ${slot.jam_sesi.replace(/:/g, '.')}
                    </span>
                    <span class="inline-block px-4 py-1 rounded-full text-xs font-medium ${pillClass}">
                        ${pillText}
                    </span>
                `;

                if (slot.available) {
                    card.addEventListener('click', function () {
                        selectedSessionId = slot.id;
                        selectedSessionInputEl.value = slot.id;
                        selectSlotWarningEl.classList.add('hidden');
                        renderSlots(data);
                    });
                }

                timeSlotsGridEl.appendChild(card);
            });

            if (availableCount === 0) {
                noSlotsNoticeEl.classList.remove('hidden');
            } else {
                noSlotsNoticeEl.classList.add('hidden');
            }
        }

        async function selectDate(isoDate, targetYear, targetMonth) {
            selectedDate = isoDate;
            selectedDateInputEl.value = isoDate;
            selectedSessionId = null;
            selectedSessionInputEl.value = '';
            selectSlotWarningEl.classList.add('hidden');

            if (typeof targetYear === 'number' && typeof targetMonth === 'number') {
                viewYear = targetYear;
                viewMonth = targetMonth;
            }

            renderCalendar();

            // Subtle loading indicator on slots
            timeSlotsGridEl.classList.add('opacity-50', 'pointer-events-none');
            try {
                const response = await fetch(`${availabilityUrl}?tanggal=${encodeURIComponent(isoDate)}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (response.ok) {
                    const data = await response.json();
                    renderSlots(data);
                }
            } catch (err) {
                console.error('Gagal memuat jadwal:', err);
            } finally {
                timeSlotsGridEl.classList.remove('opacity-50', 'pointer-events-none');
            }
        }

        prevMonthBtn.addEventListener('click', function () {
            viewMonth -= 1;
            if (viewMonth < 0) {
                viewMonth = 11;
                viewYear -= 1;
            }
            renderCalendar();
        });

        nextMonthBtn.addEventListener('click', function () {
            viewMonth += 1;
            if (viewMonth > 11) {
                viewMonth = 0;
                viewYear += 1;
            }
            renderCalendar();
        });

        proceedForm.addEventListener('submit', function (e) {
            if (!selectedDateInputEl.value || !selectedSessionInputEl.value) {
                e.preventDefault();
                selectSlotWarningEl.classList.remove('hidden');
                selectSlotWarningEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        // Initial render
        renderCalendar();
        renderSlots(initialData);
    })();
</script>
@endsection

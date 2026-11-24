<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public const HARGA_WEEKDAY = 25000;
    public const HARGA_WEEKEND = 30000;
    public const DURASI_SESI_MENIT = 30;

    public static function getHargaPerTamu(string $tanggal): int
    {
        return Carbon::parse($tanggal)->isWeekend()
            ? self::HARGA_WEEKEND
            : self::HARGA_WEEKDAY;
    }

    public static function extractStartTime(string $jamSesi): string
    {
        if (preg_match('/(\d{1,2})[:.](\d{2})/', $jamSesi, $matches)) {
            return str_pad($matches[1], 2, '0', STR_PAD_LEFT) . ':' . $matches[2];
        }

        return '08:00';
    }

    private function buildAvailabilityForDate(string $tanggal): array
    {
        $date = Carbon::parse($tanggal)->startOfDay();
        $today = now()->startOfDay();
        $isToday = $date->isSameDay($today);
        $isPastDate = $date->lessThan($today);
        $isFriday = $date->isFriday();
        $isWeekend = $date->isWeekend();
        $hargaPerTamu = $isWeekend ? self::HARGA_WEEKEND : self::HARGA_WEEKDAY;

        $sessions = Session::orderBy('id')->get()->sortBy(function ($s) {
            return self::extractStartTime($s->jam_sesi);
        })->values();

        $bookedBySession = Reservation::where('tanggal_reservasi', $date->format('Y-m-d'))
            ->selectRaw('id_sesi, SUM(jumlah_tamu) as total_booked')
            ->groupBy('id_sesi')
            ->pluck('total_booked', 'id_sesi');

        $slots = [];
        foreach ($sessions as $session) {
            $startTime = self::extractStartTime($session->jam_sesi);
            [$hour, $minute] = array_map('intval', explode(':', $startTime));

            if ($isFriday && ($hour * 60 + $minute) < (13 * 60)) {
                continue;
            }

            $booked = (int) ($bookedBySession[$session->id] ?? 0);
            $remaining = max(0, (int) $session->token_sesi - $booked);

            $sessionDateTime = Carbon::parse($date->format('Y-m-d') . ' ' . $startTime . ':00');
            $isPastTime = $isPastDate || ($isToday && $sessionDateTime->lessThanOrEqualTo(now()));

            $slots[] = [
                'id' => $session->id,
                'jam_sesi' => $session->jam_sesi,
                'start_time' => $startTime,
                'display_time' => str_replace(':', '.', $startTime),
                'token_sesi' => (int) $session->token_sesi,
                'booked' => $booked,
                'remaining' => $remaining,
                'is_past' => $isPastTime,
                'is_full' => $remaining <= 0,
                'available' => !$isPastTime && $remaining > 0,
            ];
        }

        return [
            'tanggal' => $date->format('Y-m-d'),
            'is_weekend' => $isWeekend,
            'is_friday' => $isFriday,
            'harga_per_tamu' => $hargaPerTamu,
            'durasi_menit' => self::DURASI_SESI_MENIT,
            'slots' => $slots,
        ];
    }

    public function create(Request $request)
    {
        if (!Auth::check()) {
            $request->session()->put('url.intended', route('reservasi.create'));
        }

        $requestedDate = $request->query('tanggal');
        $todayStr = now()->format('Y-m-d');

        $selectedDate = $todayStr;
        if ($requestedDate && preg_match('/^\d{4}-\d{2}-\d{2}$/', $requestedDate)) {
            try {
                $parsed = Carbon::parse($requestedDate);
                if ($parsed->greaterThanOrEqualTo(now()->startOfDay())) {
                    $selectedDate = $parsed->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $selectedDate = $todayStr;
            }
        }

        $initialData = $this->buildAvailabilityForDate($selectedDate);

        if (!$requestedDate && $selectedDate === $todayStr) {
            $hasAvailableToday = collect($initialData['slots'])->contains('available', true);
            if (!$hasAvailableToday) {
                $selectedDate = now()->addDay()->format('Y-m-d');
                $initialData = $this->buildAvailabilityForDate($selectedDate);
            }
        }

        $preselectedSessionId = $request->query('sesi');

        return view('reservations.create', [
            'selectedDate' => $selectedDate,
            'initialData' => $initialData,
            'preselectedSessionId' => $preselectedSessionId,
            'hargaWeekday' => self::HARGA_WEEKDAY,
            'hargaWeekend' => self::HARGA_WEEKEND,
            'durasiMenit' => self::DURASI_SESI_MENIT,
        ]);
    }

    public function availability(Request $request)
    {
        $tanggal = $request->query('tanggal', now()->format('Y-m-d'));

        try {
            $parsed = Carbon::parse($tanggal)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Format tanggal tidak valid.'], 422);
        }

        return response()->json($this->buildAvailabilityForDate($parsed));
    }

    public function detail(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan masuk ke akun Anda terlebih dahulu untuk melanjutkan reservasi.');
        }

        $tanggal = $request->query('tanggal');
        $sesiId = $request->query('sesi');

        if (!$tanggal || !$sesiId) {
            return redirect()->route('reservasi.create')
                ->with('error', 'Silakan pilih tanggal dan waktu kunjungan terlebih dahulu.');
        }

        try {
            $date = Carbon::parse($tanggal)->startOfDay();
        } catch (\Exception $e) {
            return redirect()->route('reservasi.create')
                ->with('error', 'Tanggal reservasi tidak valid.');
        }

        if ($date->lessThan(now()->startOfDay())) {
            return redirect()->route('reservasi.create')
                ->with('error', 'Tanggal reservasi tidak boleh tanggal yang sudah lewat.');
        }

        $session = Session::find($sesiId);
        if (!$session) {
            return redirect()->route('reservasi.create', ['tanggal' => $date->format('Y-m-d')])
                ->with('error', 'Sesi kunjungan tidak ditemukan.');
        }

        $startTime = self::extractStartTime($session->jam_sesi);
        [$hour, $minute] = array_map('intval', explode(':', $startTime));

        if ($date->isFriday() && ($hour * 60 + $minute) < (13 * 60)) {
            return redirect()->route('reservasi.create', ['tanggal' => $date->format('Y-m-d')])
                ->with('error', 'Pada hari Jumat, jam operasional Cat House dimulai pukul 13.00 WITA.');
        }

        $reservationDateTime = Carbon::parse($date->format('Y-m-d') . ' ' . $startTime . ':00');
        if ($reservationDateTime->lessThanOrEqualTo(now())) {
            return redirect()->route('reservasi.create', ['tanggal' => $date->format('Y-m-d')])
                ->with('error', 'Sesi yang dipilih sudah lewat. Silakan pilih sesi lain.');
        }

        $existingGuests = (int) Reservation::where('id_sesi', $session->id)
            ->where('tanggal_reservasi', $date->format('Y-m-d'))
            ->sum('jumlah_tamu');

        $remainingQuota = max(0, (int) $session->token_sesi - $existingGuests);
        if ($remainingQuota <= 0) {
            return redirect()->route('reservasi.create', ['tanggal' => $date->format('Y-m-d')])
                ->with('error', 'Maaf, kuota untuk sesi tersebut sudah penuh. Silakan pilih sesi lain.');
        }

        $isWeekend = $date->isWeekend();
        $hargaPerTamu = $isWeekend ? self::HARGA_WEEKEND : self::HARGA_WEEKDAY;
        $maxGuestsAllowed = min(10, $remainingQuota);
        $displayTime = str_replace(':', '.', $startTime);

        return view('reservations.detail', [
            'selectedDate' => $date->format('Y-m-d'),
            'selectedDateFormatted' => $date->locale('id')->translatedFormat('l, d F Y'),
            'session' => $session,
            'displayTime' => $displayTime,
            'remainingQuota' => $remainingQuota,
            'maxGuestsAllowed' => $maxGuestsAllowed,
            'hargaPerTamu' => $hargaPerTamu,
            'isWeekend' => $isWeekend,
            'durasiMenit' => self::DURASI_SESI_MENIT,
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sesi login Anda telah berakhir.');
        }

        $validated = $request->validate([
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'id_sesi' => 'required|exists:sessions,id',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'no_telp' => 'required|string|max:30',
            'jumlah_tamu' => 'required|integer|min:1|max:10',
            'setuju_syarat' => 'accepted',
        ], [
            'tanggal_reservasi.required' => 'Pilih tanggal reservasi terlebih dahulu.',
            'tanggal_reservasi.after_or_equal' => 'Tanggal reservasi tidak boleh tanggal yang sudah lewat.',
            'id_sesi.required' => 'Pilih sesi jam kunjungan.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_telp.required' => 'Nomor HP wajib diisi.',
            'jumlah_tamu.required' => 'Pilih jumlah tamu terlebih dahulu.',
            'jumlah_tamu.min' => 'Jumlah tamu minimal 1 orang.',
            'jumlah_tamu.max' => 'Jumlah tamu maksimal 10 orang per reservasi.',
            'setuju_syarat.accepted' => 'Anda harus menyetujui syarat dan ketentuan terlebih dahulu.',
        ]);

        $session = Session::findOrFail($validated['id_sesi']);
        $date = Carbon::parse($validated['tanggal_reservasi'])->startOfDay();
        $startTime = self::extractStartTime($session->jam_sesi);
        $waktu = $startTime . ':00';
        [$hour, $minute] = array_map('intval', explode(':', $startTime));

        if ($date->isFriday() && ($hour * 60 + $minute) < (13 * 60)) {
            return redirect()->route('reservasi.create', ['tanggal' => $date->format('Y-m-d')])
                ->with('error', 'Pada hari Jumat, jam operasional dimulai pukul 13.00 WITA.');
        }

        $reservationDateTime = Carbon::parse($validated['tanggal_reservasi'] . ' ' . $waktu);
        if ($reservationDateTime->lessThanOrEqualTo(now())) {
            return redirect()->route('reservasi.create', ['tanggal' => $date->format('Y-m-d')])
                ->with('error', "Maaf, sesi {$session->jam_sesi} pada tanggal {$validated['tanggal_reservasi']} sudah lewat. Silakan pilih sesi jam berikutnya atau tanggal lain.");
        }

        $hargaPerTamu = self::getHargaPerTamu($validated['tanggal_reservasi']);
        $totalHarga = $validated['jumlah_tamu'] * $hargaPerTamu;

        try {
            $reservation = DB::transaction(function () use ($validated, $session, $waktu, $totalHarga) {
                // Lock the session and existing reservations to prevent race conditions & overbooking
                $currentSession = Session::lockForUpdate()->findOrFail($session->id);
                $existingGuests = (int) Reservation::where('id_sesi', $currentSession->id)
                    ->where('tanggal_reservasi', $validated['tanggal_reservasi'])
                    ->lockForUpdate()
                    ->sum('jumlah_tamu');

                if (($existingGuests + $validated['jumlah_tamu']) > $currentSession->token_sesi) {
                    $remaining = max(0, $currentSession->token_sesi - $existingGuests);
                    throw new \DomainException("Maaf, kuota untuk sesi {$currentSession->jam_sesi} pada tanggal {$validated['tanggal_reservasi']} hanya tersisa {$remaining} orang.");
                }

                return Reservation::create([
                    'id_users' => Auth::id(),
                    'id_sesi' => $currentSession->id,
                    'nama_pemesan' => $validated['nama_lengkap'],
                    'email_pemesan' => $validated['email'],
                    'no_telp_pemesan' => $validated['no_telp'],
                    'jumlah_tamu' => $validated['jumlah_tamu'],
                    'total_harga' => $totalHarga,
                    'tanggal_reservasi' => $validated['tanggal_reservasi'],
                    'waktu_reservasi' => $waktu,
                    'status_konfirmasi' => 'belum',
                ]);
            });

            return redirect()->route('reservasi.show', $reservation->id)
                ->with('success', 'Reservasi berhasil dibuat!');
        } catch (\DomainException $e) {
            return back()->withInput()->withErrors([
                'jumlah_tamu' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memproses reservasi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk melihat tiket reservasi.');
        }

        $reservation = Reservation::with(['user', 'session'])->findOrFail($id);

        if (Auth::user()->role !== 'admin' && $reservation->id_users !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke tiket reservasi ini.');
        }

        $jumlahTamu = max(1, (int) ($reservation->jumlah_tamu ?? 1));
        $hargaSatuan = $reservation->total_harga > 0
            ? (int) round($reservation->total_harga / $jumlahTamu)
            : self::getHargaPerTamu($reservation->tanggal_reservasi);
        $isWeekend = Carbon::parse($reservation->tanggal_reservasi)->isWeekend();

        return view('reservations.show', [
            'reservation' => $reservation,
            'hargaSatuan' => $hargaSatuan,
            'isWeekend' => $isWeekend,
            'durasiMenit' => self::DURASI_SESI_MENIT,
        ]);
    }

    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $reservations = Reservation::with(['session'])
            ->where('id_users', Auth::id())
            ->orderByDesc('tanggal_reservasi')
            ->orderByDesc('id')
            ->get();

        return view('reservations.history', compact('reservations'));
    }
}

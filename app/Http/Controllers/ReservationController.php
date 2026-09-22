<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    const HARGA_PER_TAMU = 35000; // Rp 35.000 per orang

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan masuk ke akun Anda terlebih dahulu untuk melakukan reservasi.');
        }

        $sessions = Session::orderBy('id')->get();
        $hargaPerTamu = self::HARGA_PER_TAMU;

        return view('reservations.create', compact('sessions', 'hargaPerTamu'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sesi login Anda telah berakhir.');
        }

        $validated = $request->validate([
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'id_sesi' => 'required|exists:sessions,id',
            'jumlah_tamu' => 'required|integer|min:1|max:10',
            'metode_pembayaran' => 'required|in:qris,bank',
        ], [
            'tanggal_reservasi.required' => 'Pilih tanggal reservasi terlebih dahulu.',
            'tanggal_reservasi.after_or_equal' => 'Tanggal reservasi tidak boleh tanggal yang sudah lewat.',
            'id_sesi.required' => 'Pilih sesi jam kunjungan.',
            'jumlah_tamu.required' => 'Tentukan jumlah pengunjung / tamu.',
            'jumlah_tamu.min' => 'Jumlah tamu minimal 1 orang.',
            'jumlah_tamu.max' => 'Jumlah tamu maksimal 10 orang per reservasi.',
            'metode_pembayaran.required' => 'Pilih metode pembayaran (QRIS atau Bank Transfer).',
        ]);

        $session = Session::findOrFail($validated['id_sesi']);

        // Check booked guests for this date and session
        $existingGuests = Reservation::where('id_sesi', $session->id)
            ->where('tanggal_reservasi', $validated['tanggal_reservasi'])
            ->with('payment')
            ->get()
            ->sum(fn($r) => $r->payment ? $r->payment->jumlah_tamu : 0);

        if (($existingGuests + $validated['jumlah_tamu']) > $session->token_sesi) {
            $remaining = max(0, $session->token_sesi - $existingGuests);
            return back()->withInput()->withErrors([
                'id_sesi' => "Maaf, kuota untuk sesi {$session->jam_sesi} pada tanggal {$validated['tanggal_reservasi']} hanya tersisa {$remaining} orang.",
            ]);
        }

        $totalHarga = $validated['jumlah_tamu'] * self::HARGA_PER_TAMU;

        // Parse starting time for waktu_reservasi
        $waktu = '10:00:00';
        if (preg_match('/(\d{1,2}:\d{2})/', $session->jam_sesi, $matches)) {
            $waktu = strlen($matches[1]) == 5 ? $matches[1] . ':00' : '0' . $matches[1] . ':00';
        }

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'id_user' => Auth::id(),
                'jumlah_tamu' => $validated['jumlah_tamu'],
                'total_harga' => $totalHarga,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'tanggal_pembayaran' => now(),
            ]);

            $reservation = Reservation::create([
                'id_payments' => $payment->id,
                'id_users' => Auth::id(),
                'id_sesi' => $session->id,
                'tanggal_reservasi' => $validated['tanggal_reservasi'],
                'waktu_reservasi' => $waktu,
            ]);

            DB::commit();

            return redirect()->route('reservasi.show', $reservation->id)
                ->with('success', 'Reservasi berhasil dibuat! Silakan selesaikan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memproses reservasi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $reservation = Reservation::with(['payment', 'user', 'session'])->findOrFail($id);

        if (Auth::user()->role !== 'admin' && $reservation->id_users !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke tiket reservasi ini.');
        }

        return view('reservations.show', compact('reservation'));
    }

    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $reservations = Reservation::with(['payment', 'session'])
            ->where('id_users', Auth::id())
            ->orderByDesc('tanggal_reservasi')
            ->orderByDesc('id')
            ->get();

        return view('reservations.history', compact('reservations'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'semua');

        $query = Reservation::with(['user', 'session']);

        if ($status === 'sudah') {
            $query->where('status_konfirmasi', 'sudah');
        } elseif ($status === 'belum') {
            $query->where(function ($q) {
                $q->where('status_konfirmasi', 'belum')
                  ->orWhereNull('status_konfirmasi');
            });
        }

        if ($search !== '') {
            $digitsOnly = ltrim(preg_replace('/\D/', '', $search), '0');
            $query->where(function ($q) use ($search, $digitsOnly) {
                if ($digitsOnly !== '') {
                    $q->where('id', (int) $digitsOnly)
                      ->orWhereRaw('CAST(id AS CHAR) LIKE ?', ["%{$digitsOnly}%"]);
                }

                $q->orWhere('nama_pemesan', 'like', "%{$search}%")
                  ->orWhere('email_pemesan', 'like', "%{$search}%")
                  ->orWhere('no_telp_pemesan', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('no_telp', 'like', "%{$search}%");
                  });
            });
        }

        $reservations = $query->orderByDesc('tanggal_reservasi')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.reservations.index', compact('reservations', 'search', 'status'));
    }

    public function toggleKonfirmasi(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $nextStatus = ($reservation->status_konfirmasi === 'sudah') ? 'belum' : 'sudah';
        $reservation->update(['status_konfirmasi' => $nextStatus]);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'id' => $reservation->id,
                'status_konfirmasi' => $nextStatus,
            ]);
        }

        return back();
    }

    public function show($id)
    {
        $reservation = Reservation::with(['user', 'session'])->findOrFail($id);

        return view('admin.reservations.show', compact('reservation'));
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index');
    }
}

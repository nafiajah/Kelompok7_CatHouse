<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date');
        $query = Reservation::with(['user', 'session']);

        if ($date) {
            $query->where('tanggal_reservasi', $date);
        }

        $reservations = $query->orderByDesc('tanggal_reservasi')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.reservations.index', compact('reservations', 'date'));
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

        return redirect()->route('admin.reservations.index')->with('success', 'Data reservasi berhasil dihapus.');
    }
}

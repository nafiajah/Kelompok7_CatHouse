<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date');
        $query = Reservation::with(['user', 'payment', 'session']);

        if ($date) {
            $query->where('tanggal_reservasi', $date);
        }

        $reservations = $query->orderByDesc('tanggal_reservasi')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.reservations.index', compact('reservations', 'date'));
    }

    public function payments(Request $request)
    {
        $method = $request->query('metode');
        $query = Payment::with(['user', 'reservation']);

        if ($method) {
            $query->where('metode_pembayaran', $method);
        }

        $payments = $query->orderByDesc('tanggal_pembayaran')->paginate(15)->withQueryString();
        $totalRevenue = Payment::sum('total_harga');
        $totalQris = Payment::where('metode_pembayaran', 'qris')->sum('total_harga');
        $totalBank = Payment::where('metode_pembayaran', 'bank')->sum('total_harga');

        return view('admin.payments.index', compact('payments', 'method', 'totalRevenue', 'totalQris', 'totalBank'));
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // When deleting reservation, the payment can also be deleted if cascade
        if ($reservation->payment) {
            $reservation->payment->delete();
        } else {
            $reservation->delete();
        }

        return redirect()->route('admin.reservations.index')->with('success', 'Data reservasi berhasil dihapus.');
    }
}

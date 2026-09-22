<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKucing;
use App\Models\Variant;
use App\Models\Session;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Feedback;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCats = DataKucing::count();
        $totalVariants = Variant::count();
        $totalSessions = Session::count();
        $totalReservations = Reservation::count();
        $totalRevenue = Payment::sum('total_harga');
        $totalUsers = User::where('role', 'user')->count();
        $pendingFeedbacks = Feedback::where('status_tampil', 'tidak')->count();

        $recentReservations = Reservation::with(['user', 'payment', 'session'])
            ->latest('id')
            ->take(5)
            ->get();

        $recentFeedbacks = Feedback::with('user')
            ->latest('id')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCats',
            'totalVariants',
            'totalSessions',
            'totalReservations',
            'totalRevenue',
            'totalUsers',
            'pendingFeedbacks',
            'recentReservations',
            'recentFeedbacks'
        ));
    }
}

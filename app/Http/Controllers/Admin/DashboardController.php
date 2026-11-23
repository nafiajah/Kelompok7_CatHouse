<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKucing;
use App\Models\Feedback;
use App\Models\Reservation;
use App\Models\Session;
use App\Models\User;
use App\Models\Variant;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCats = DataKucing::count();
        $totalVariants = Variant::count();
        $totalSessions = Session::count();
        $totalReservations = Reservation::count();
        $totalPemasukan = (int) Reservation::where('status_konfirmasi', 'sudah')->sum('total_harga');
        $totalFeedbacks = Feedback::count();
        $totalUsers = User::where('role', 'user')->count();
        $pendingFeedbacks = Feedback::where('status_tampil', 'tidak')->count();

        $recentReservations = Reservation::with(['user', 'session'])
            ->latest('id')
            ->take(30)
            ->get();

        $recentFeedbacks = Feedback::with('user')
            ->latest('id')
            ->take(30)
            ->get();

        return view('admin.dashboard', compact(
            'totalCats',
            'totalVariants',
            'totalSessions',
            'totalReservations',
            'totalPemasukan',
            'totalFeedbacks',
            'totalUsers',
            'pendingFeedbacks',
            'recentReservations',
            'recentFeedbacks'
        ));
    }
}

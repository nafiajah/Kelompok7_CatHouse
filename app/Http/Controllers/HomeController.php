<?php

namespace App\Http\Controllers;

use App\Models\DataKucing;
use App\Models\Variant;
use App\Models\Session;
use App\Models\Feedback;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $selectedVariant = $request->query('variant');

        $catsQuery = DataKucing::with('variant');
        if ($selectedVariant) {
            $catsQuery->where('id_variant', $selectedVariant);
        }
        $cats = $catsQuery->get();

        $variants = Variant::withCount('dataKucing')->get();
        $sessions = Session::orderBy('id')->get();
        $feedbacks = Feedback::with('user')
            ->where('status_tampil', 'tampil')
            ->orderByDesc('tanggal_saran')
            ->take(6)
            ->get();

        return view('home', compact('cats', 'variants', 'sessions', 'feedbacks', 'selectedVariant'));
    }
}

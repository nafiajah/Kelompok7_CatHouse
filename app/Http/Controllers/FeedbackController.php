<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan masuk ke akun Anda untuk memberikan ulasan.');
        }

        return view('feedbacks.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'bintang' => 'required|integer|min:1|max:5',
            'teks_saran' => 'required|string|min:5|max:1000',
        ], [
            'bintang.required' => 'Silakan pilih rating bintang 1 sampai 5.',
            'bintang.min' => 'Rating bintang minimal 1.',
            'bintang.max' => 'Rating bintang maksimal 5.',
            'teks_saran.required' => 'Pesan ulasan atau saran wajib diisi.',
            'teks_saran.min' => 'Ulasan minimal 5 karakter.',
        ]);

        Feedback::create([
            'id_user' => Auth::id(),
            'tanggal_saran' => now(),
            'teks_saran' => $validated['teks_saran'],
            'bintang' => $validated['bintang'],
            'status_tampil' => 'tidak', // Menunggu moderasi admin
        ]);

        return redirect()->route('home')->with('success', 'Terima kasih atas ulasan dan saran Anda! Ulasan akan ditinjau oleh pengelola kafe.');
    }
}

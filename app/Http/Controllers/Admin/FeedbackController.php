<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Feedback::with('user');

        if ($status) {
            $query->where('status_tampil', $status);
        }

        $feedbacks = $query->orderByDesc('tanggal_saran')->paginate(15)->withQueryString();

        return view('admin.feedbacks.index', compact('feedbacks', 'status'));
    }

    public function toggleStatus($id)
    {
        $feedback = Feedback::findOrFail($id);
        $newStatus = $feedback->status_tampil === 'tampil' ? 'tidak' : 'tampil';
        $feedback->update(['status_tampil' => $newStatus]);

        $message = $newStatus === 'tampil' 
            ? 'Ulasan berhasil dipublikasikan ke halaman utama!' 
            : 'Ulasan berhasil disembunyikan dari halaman utama.';

        return back()->with('success', $message);
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return back()->with('success', 'Ulasan feedback berhasil dihapus.');
    }
}

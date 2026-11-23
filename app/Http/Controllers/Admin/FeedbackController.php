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

        if (in_array($status, ['tampil', 'tidak'], true)) {
            $query->where('status_tampil', $status);
        }

        $feedbacks = $query->orderByDesc('tanggal_saran')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.feedbacks.index', compact('feedbacks', 'status'));
    }

    public function toggleStatus(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $requestedStatus = $request->input('status_tampil');
        if (in_array($requestedStatus, ['tampil', 'tidak'], true)) {
            $newStatus = $requestedStatus;
        } else {
            $newStatus = $feedback->status_tampil === 'tampil' ? 'tidak' : 'tampil';
        }

        $feedback->update(['status_tampil' => $newStatus]);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'id' => $feedback->id,
                'status_tampil' => $newStatus,
            ]);
        }

        return back();
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return back();
    }
}

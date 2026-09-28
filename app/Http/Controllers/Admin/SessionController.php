<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::withCount('reservations')->orderBy('id')->get();
        return view('admin.sessions.index', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jam_sesi' => 'required|string|max:20|unique:sessions,jam_sesi',
            'token_sesi' => 'required|integer|min:1|max:100',
        ], [
            'jam_sesi.required' => 'Jam sesi wajib diisi (contoh: 10:00 - 11:30).',
            'jam_sesi.unique' => 'Jam sesi ini sudah ada.',
            'token_sesi.required' => 'Kuota token pengunjung wajib ditentukan.',
            'token_sesi.min' => 'Kuota token minimal 1 orang.',
        ]);

        Session::create($validated);

        return redirect()->route('admin.sessions.index')->with('success', 'Sesi kunjungan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $session = Session::findOrFail($id);

        $validated = $request->validate([
            'jam_sesi' => 'required|string|max:20|unique:sessions,jam_sesi,' . $session->id,
            'token_sesi' => 'required|integer|min:1|max:100',
        ], [
            'jam_sesi.required' => 'Jam sesi wajib diisi.',
            'jam_sesi.unique' => 'Jam sesi ini sudah ada.',
            'token_sesi.required' => 'Kuota token pengunjung wajib ditentukan.',
        ]);

        $session->update($validated);

        return redirect()->route('admin.sessions.index')->with('success', 'Sesi kunjungan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $session = Session::findOrFail($id);
        $session->delete();

        return redirect()->route('admin.sessions.index')->with('success', 'Sesi kunjungan berhasil dihapus.');
    }
}

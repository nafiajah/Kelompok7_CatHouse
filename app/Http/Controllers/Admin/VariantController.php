<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index()
    {
        $variants = Variant::withCount('dataKucing')->orderBy('jenis')->get();
        return view('admin.variants.index', compact('variants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:50|unique:variants,jenis',
        ], [
            'jenis.required' => 'Nama jenis varian wajib diisi.',
            'jenis.unique' => 'Jenis varian ini sudah ada.',
        ]);

        Variant::create($validated);

        return redirect()->route('admin.variants.index')->with('success', 'Varian jenis kucing berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $variant = Variant::findOrFail($id);

        $validated = $request->validate([
            'jenis' => 'required|string|max:50|unique:variants,jenis,' . $variant->id,
        ], [
            'jenis.required' => 'Nama jenis varian wajib diisi.',
            'jenis.unique' => 'Jenis varian ini sudah ada.',
        ]);

        $variant->update($validated);

        return redirect()->route('admin.variants.index')->with('success', 'Varian jenis kucing berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $variant = Variant::withCount('dataKucing')->findOrFail($id);

        if ($variant->data_kucing_count > 0) {
            return back()->with('error', "Tidak dapat menghapus varian '{$variant->jenis}' karena masih memiliki {$variant->data_kucing_count} data kucing.");
        }

        $variant->delete();

        return redirect()->route('admin.variants.index')->with('success', 'Varian jenis kucing berhasil dihapus.');
    }
}

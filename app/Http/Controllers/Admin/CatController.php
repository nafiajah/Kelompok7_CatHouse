<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataKucing;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = DataKucing::with('variant');

        if ($search) {
            $query->where('nama_kucing', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        $cats = $query->orderBy('nama_kucing')->paginate(10)->withQueryString();

        return view('admin.cats.index', compact('cats', 'search'));
    }

    public function create()
    {
        $variants = Variant::orderBy('jenis')->get();
        return view('admin.cats.create', compact('variants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kucing' => 'required|string|max:50|unique:data_kucing,nama_kucing',
            'id_variant' => 'required|exists:variants,id',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'nama_kucing.required' => 'Nama kucing wajib diisi.',
            'nama_kucing.unique' => 'Nama kucing sudah ada.',
            'id_variant.required' => 'Varian jenis kucing wajib dipilih.',
            'deskripsi.required' => 'Deskripsi kucing wajib diisi.',
            'foto.required' => 'Foto kucing wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 3MB.',
        ]);

        $fotoName = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/cats');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $fotoName);
        }

        DataKucing::create([
            'nama_kucing' => $validated['nama_kucing'],
            'id_variant' => $validated['id_variant'],
            'deskripsi' => $validated['deskripsi'],
            'foto' => $fotoName,
        ]);

        return redirect()->route('admin.kucing.index')->with('success', 'Data kucing berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $cat = DataKucing::findOrFail($id);
        $variants = Variant::orderBy('jenis')->get();
        return view('admin.cats.edit', compact('cat', 'variants'));
    }

    public function update(Request $request, $id)
    {
        $cat = DataKucing::findOrFail($id);

        $validated = $request->validate([
            'nama_kucing' => 'required|string|max:50|unique:data_kucing,nama_kucing,' . $cat->id,
            'id_variant' => 'required|exists:variants,id',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'nama_kucing.required' => 'Nama kucing wajib diisi.',
            'nama_kucing.unique' => 'Nama kucing sudah ada.',
            'id_variant.required' => 'Varian jenis kucing wajib dipilih.',
            'deskripsi.required' => 'Deskripsi kucing wajib diisi.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 3MB.',
        ]);

        $fotoName = $cat->foto;
        if ($request->hasFile('foto')) {
            // Delete old file if exists in uploads/cats
            if ($cat->foto && File::exists(public_path('uploads/cats/' . $cat->foto))) {
                File::delete(public_path('uploads/cats/' . $cat->foto));
            }

            $file = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/cats');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $fotoName);
        }

        $cat->update([
            'nama_kucing' => $validated['nama_kucing'],
            'id_variant' => $validated['id_variant'],
            'deskripsi' => $validated['deskripsi'],
            'foto' => $fotoName,
        ]);

        return redirect()->route('admin.kucing.index')->with('success', 'Data kucing berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $cat = DataKucing::findOrFail($id);

        if ($cat->foto && File::exists(public_path('uploads/cats/' . $cat->foto))) {
            File::delete(public_path('uploads/cats/' . $cat->foto));
        }

        $cat->delete();

        return redirect()->route('admin.kucing.index')->with('success', 'Data kucing berhasil dihapus.');
    }
}

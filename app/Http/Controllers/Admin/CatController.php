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
            $query->where(function ($q) use ($search) {
                $q->where('nama_kucing', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $cats = $query->orderByDesc('id')->paginate(10)->withQueryString();
        $variants = Variant::orderBy('jenis')->get();

        return view('admin.cats.index', compact('cats', 'variants', 'search'));
    }

    public function create()
    {
        $variants = Variant::orderBy('jenis')->get();
        return view('admin.cats.create', compact('variants'));
    }

    private function handleFileUpload($file, $oldFoto = null): string
    {
        $destination = public_path('uploads/cats');
        $isWritable = false;

        try {
            if (!File::isDirectory($destination)) {
                @File::makeDirectory($destination, 0755, true, true);
            }
            $isWritable = is_writable($destination);
        } catch (\Throwable $e) {
            $isWritable = false;
        }

        if ($isWritable) {
            if ($oldFoto && !str_starts_with($oldFoto, 'data:') && File::exists($destination . '/' . $oldFoto)) {
                @File::delete($destination . '/' . $oldFoto);
            }
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destination, $filename);
            return $filename;
        }

        // Serverless fallback (Vercel / read-only filesystem):
        // Store as Base64 Data URI directly in the database column
        $mime = $file->getMimeType() ?: 'image/jpeg';
        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
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
            $fotoName = $this->handleFileUpload($request->file('foto'));
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
            $fotoName = $this->handleFileUpload($request->file('foto'), $cat->foto);
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

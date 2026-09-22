<?php

namespace App\Http\Controllers;

use App\Models\DataKucing;
use App\Models\Variant;
use Illuminate\Http\Request;

class CatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $variantId = $request->query('variant');

        $query = DataKucing::with('variant');

        if ($search) {
            $query->where('nama_kucing', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        if ($variantId) {
            $query->where('id_variant', $variantId);
        }

        $cats = $query->orderBy('nama_kucing')->paginate(9)->withQueryString();
        $variants = Variant::withCount('dataKucing')->get();

        return view('cats.index', compact('cats', 'variants', 'search', 'variantId'));
    }

    public function show($id)
    {
        $cat = DataKucing::with('variant')->findOrFail($id);
        return response()->json($cat);
    }
}

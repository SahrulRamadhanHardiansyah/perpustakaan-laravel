<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Category;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $jenis = Jenis::all();

        $bukuQuery = Buku::with('jenis');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $bukuQuery->where(function ($query) use ($keyword) {
                $query->where('judul', 'like', '%' . $keyword . '%')
                    ->orWhere('author', 'like', '%' . $keyword . '%')
                    ->orWhere('barcode', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('jenis')) {
            $bukuQuery->where('jenis_id', $request->jenis);
        }

        $buku = $bukuQuery->latest()->paginate(10);
        
        return view('admin.buku', [
            'buku' => $buku,
            'jenis' => $jenis
        ]);
    }

    public function show(Buku $buku)
    {
        return view('admin.buku-show', ['buku' => $buku]);
    }

   public function search(Request $request)
    {
        $term = $request->input('term');

        $buku = Buku::where('stok', '>', 0) 
                    ->where(function ($query) use ($term) {
                        $query->where('judul', 'LIKE', '%' . $term . '%')
                                ->orWhere('author', 'LIKE', '%' . $term . '%')
                                ->orWhere('barcode', 'LIKE', '%' . $term . '%');
                    })
                    ->select('id', 'judul as text')
                    ->get();

        return response()->json($buku);
    }

    public function searchVisual(Request $request)
    {
        $query = Buku::where('stok', '>', 0);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', '%' . $keyword . '%')
                ->orWhere('author', 'like', '%' . $keyword . '%')
                ->orWhere('barcode', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_id', $request->jenis);
        }

        $buku = $query->take(12)->get(); 

        return view('admin.partials._book_selection_cards', ['bukuList' => $buku]);
    }

    public function add()
    {
        $jenis = Jenis::all();
        return view('admin.buku-add', ['jenis' => $jenis]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:buku',
            'author' => 'required|string|max:255',
            'jenis_id' => 'required|exists:jenis,id',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        try {
            DB::beginTransaction();
            $gambar = null;
            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar')->store('gambar-buku', 'public');
            }

            $barcode = date('Ymd') . '-' . Str::random(6);

            $bukuData = $request->validated();
            $bukuData['gambar'] = $gambar;
            $bukuData['barcode'] = $barcode;

            Buku::create($bukuData);

            DB::commit();
            return redirect()->route('admin.buku.index')->with('status', 'Buku berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal menambah buku: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambah buku.')->withInput();
        }
    }

    public function edit(Buku $buku)
    {
        $jenis = Jenis::all();
        return view('admin.buku-edit', ['buku' => $buku, 'jenis' => $jenis]);
    }

    public function update(Request $request, $slug)
    {
        $buku = Buku::where('slug', $slug)->firstOrFail();

        if ($request->has('generate_barcode')) {
            $buku->barcode = date('Ymd') . '-' . Str::random(6);
            $buku->save();
            return redirect()->back()->with('status', 'Barcode baru berhasil dibuat!');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:buku,judul,' . $buku->id,
            'author' => 'required|string|max:255',
            'jenis_id' => 'required|exists:jenis,id',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $buku->gambar;
        if ($request->file('gambar')) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('gambar')->store('gambar-buku', 'public');
        }

        $buku->update([
            'judul' => $validated['judul'],
            'author' => $validated['author'],
            'jenis_id' => $validated['jenis_id'],
            'stok' => $validated['stok'],
            'kondisi' => $validated['kondisi'],
            'gambar' => $path,
        ]);

        return redirect()->route('admin.buku.index')->with('status', 'Buku berhasil diperbarui');
    }

    public function delete(Buku $buku)
    {
        return view('admin.buku-delete', ['buku' => $buku]);
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('admin.buku.index')->with('status', 'Buku berhasil dihapus');
    }

    public function deleted()
    {
        $bukuDihapus = Buku::onlyTrashed()->get();
        return view('admin.deleted-buku', ['bukuDihapus' => $bukuDihapus]);
    }

    public function restore(Buku $buku)
    {
        $buku->restore();
        return redirect()->route('admin.buku.deleted')->with('status', 'Buku berhasil dipulihkan');
    }
}

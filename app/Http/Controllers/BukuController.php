<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Category;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('jenis')->get();
        return view('admin.buku', ['buku' => $buku]);
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
            'jenis_id' => 'required|exists:jenis,id',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $path = null;
        if ($request->file('gambar')) {
            $path = $request->file('gambar')->store('gambar-buku', 'public');
        }

        Buku::create([
            'judul' => $validated['judul'],
            'jenis_id' => $validated['jenis_id'],
            'stok' => $validated['stok'],
            'kondisi' => $validated['kondisi'],
            'gambar' => $path,
        ]);

        return redirect('/admin/buku')->with('status', 'Buku berhasil ditambahkan');
    }

    public function edit($slug)
    {
        $buku = Buku::where('slug', $slug)->firstOrFail();
        $jenis = Jenis::all();
        return view('admin.buku-edit', ['buku' => $buku, 'jenis' => $jenis]);
    }

    public function update(Request $request, $slug)
    {
        $buku = Buku::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:buku,judul,' . $buku->id,
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
            'jenis_id' => $validated['jenis_id'],
            'stok' => $validated['stok'],
            'kondisi' => $validated['kondisi'],
            'gambar' => $path,
        ]);

        return redirect('/admin/buku')->with('status', 'Buku berhasil diperbarui');
    }

    public function delete($slug)
    {
        $buku = Buku::where('slug', $slug)->firstOrFail();
        return view('admin.buku-delete', ['buku' => $buku]);
    }


    public function destroy($slug)
    {
        $buku = Buku::where('slug', $slug)->firstOrFail();
        $buku->delete();

        return redirect()->route('admin.buku.index')->with('status', 'Buku berhasil dihapus');
    }

    public function deleted()
    {
        $bukuDihapus = Buku::onlyTrashed()->get();
        return view('admin.deleted-buku', ['bukuDihapus' => $bukuDihapus]);
    }

    public function restore($slug)
    {
        $buku = Buku::withTrashed()->where('slug', $slug)->firstOrFail();
        $buku->restore();

        return redirect()->route('admin.buku.deleted')->with('status', 'Buku berhasil dipulihkan');
    }
}

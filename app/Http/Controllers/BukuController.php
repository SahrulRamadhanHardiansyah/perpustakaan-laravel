<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Category;
use App\Models\Jenis;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('admin.buku', ['buku' => $buku]);
    }

    public function add()
    {
        $jenis = Jenis::all();
        return view('admin.buku-add', ['jenis' => $jenis]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => ['required', 'max:255'],
        ]);

        $newName = null;

        if($request->hasFile('gambar')) {
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $newName = $request->judul.'-'.now()->timestamp.'.'.$extension;
            $request->file('gambar')->storeAs('gambar', $newName);
        }
        
        $request['gambar'] = $newName;
        $buku = Buku::create($request->all());
        $buku->jenis()->sync($request->jenis);
        return redirect('admin.buku')->with('status', 'Buku berhasil ditambahkan');
    }

    public function edit($slug)
    {
        $buku = Buku::where('slug', $slug)->first();
        $jenis = Jenis::all();
        return view('admin.buku-edit', ['buku' => $buku, 'jenis' => $jenis]);
    }

    public function update(Request $request, $slug)
    {
        if($request->hasFile('gambar')) {
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $newName = $request->judul.'-'.now()->timestamp.'.'.$extension;
            $request->file('gambar')->storeAs('gambar', $newName);
            $request['gambar'] = $newName;
        }

        $buku = Buku::where('slug', $slug)->first();
        $buku->slug = null;
        $buku->update($request->all());

        if($request->jenis) {
            $buku->jenis()->sync($request->jenis);
        }

        return redirect('admin.buku')->with('status', 'Buku berhasil diperbarui');
    }

    public function delete($slug)
    {
        $buku = Buku::where('slug', $slug)->first();
        return view('admin.buku-delete', ['buku' => $buku]);
    }


    public function destroy($slug)
    {
        $buku = Buku::where('slug', $slug)->first();
        $buku->delete();
        return redirect('admin.buku')->with('status', 'Buku berhasil dihapus');
    }

    public function deleted()
    {
        $bukuDihapus = Buku::onlyTrashed()->get();
        return view('admin.buku-deleted', ['bukuDihapus' => $bukuDihapus]);
    }

    public function restore($slug)
    {
        $buku = Buku::withTrashed()->where('slug', $slug)->first();
        $buku->restore();
        return redirect('admin.buku')->with('status', 'Buku berhasil dipulihkan');
    }
}

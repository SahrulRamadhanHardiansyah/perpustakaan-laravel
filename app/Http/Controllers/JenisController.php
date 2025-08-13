<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();
        return view('admin.jenis', ['jenis' => $jenis]);
    }

    public function add()
    {
        return view('admin.jenis-add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:jenis,name',
        ]);

        Jenis::create($validated);
        return redirect('/admin/jenis')->with('status', 'Jenis berhasil ditambahkan!');
    }

    public function edit($slug)
    {
        $jenis = Jenis::where('slug', $slug)->firstOrFail();
        return view('admin.jenis-edit', ['jenis' => $jenis]);
    }

    public function update(Request $request, $slug)
    {
        $jenis = Jenis::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('jenis')->ignore($jenis->id),
            ],
        ]);

        $jenis->update($validated);
        return redirect('/admin/jenis')->with('status', 'Jenis berhasil diperbarui!');
    }

    public function delete($slug)
    {
        $jenis = Jenis::where('slug', $slug)->firstOrFail();
        return view('admin.jenis-delete', ['jenis' => $jenis]);
    }

    public function destroy($slug)
    {
        $jenis = Jenis::where('slug', $slug)->firstOrFail();
        $jenis->delete();
        return redirect()->route('admin.jenis.index')->with('status', 'Jenis berhasil dihapus');
    }

    public function deleted()
    {
        $jenis = Jenis::onlyTrashed()->get();
        return view('admin.deleted-jenis', ['deletedJenis' => $jenis]);
    }

    public function restore($slug)
    {
        $jenis = Jenis::withTrashed()->where('slug', $slug)->firstOrFail();
        $jenis->restore();
        return redirect()->route('admin.jenis.index')->with('status', 'Jenis berhasil dipulihkan!');
    }
}

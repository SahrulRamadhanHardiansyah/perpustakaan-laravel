<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();
        return view('jenis', ['jenis' => $jenis]);
    }

    public function add()
    {
        return view('jenis-add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'unique:categories', 'max:100'],
        ]);

        $jenis = Jenis::create($request->all());
        return redirect('jenis')->with('status', 'Jenis Added Successfully!');
    }

    public function edit($slug)
    {
        $jenis = Jenis::where('slug', $slug)->first();
        return view('admin.jenis-edit', ['jenis' => $jenis]);
    }

    public function update(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'unique:categories', 'max:100'],
        ]);

        $jenis = Jenis::where('slug', $slug)->first();
        $jenis->slug = null;
        $jenis->update($request->all());
        return redirect('admin.jenis')->with('status', 'Jenis Edited Successfully!');
    }

    public function delete($slug)
    {
        $jenis = Jenis::where('slug', $slug)->first();
        return view('admin.jenis-delete', ['jenis' => $jenis]);
    }

    public function destroy($slug)
    {
        $jenis = Jenis::where('slug', $slug)->first();
        $jenis->delete();
        return redirect('admin.jenis')->with('status', 'Jenis Deleted Successfully!');
    }

    public function deleted()
    {
        $jenis = Jenis::onlyTrashed()->get();
        return view('admin.jenis-deleted', ['deletedJenis' => $jenis]);
    }

    public function restore($slug)
    {
        $jenis = Jenis::withTrashed()->where('slug', $slug)->first();
        $jenis->restore();
        return redirect('admin.jenis')->with('status', 'Jenis Restored Successfully!');
    }
}

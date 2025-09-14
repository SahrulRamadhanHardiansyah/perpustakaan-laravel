<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function index()
    {
        return view('admin.barcode.search');
    }

    public function search(Request $request)
    {
        $request->validate(['barcode' => 'required|string']);

        $buku = Buku::where('barcode', $request->barcode)->first();

        if ($buku) {
            return redirect()->route('admin.buku.show', $buku->slug);
        }

        return redirect()->route('admin.barcode.search.index')
                         ->with('error', 'Buku dengan barcode tersebut tidak ditemukan.');
    }
}
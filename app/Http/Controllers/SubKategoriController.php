<?php

namespace App\Http\Controllers;

use App\Models\SubKategori;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        $subKategoris = SubKategori::with('kategori')->latest()->paginate(10);
        $kategoriList = Kategori::all();
        return view('sub-kategori.index', compact('subKategoris', 'kategoriList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $kategoriList = Kategori::all();
        return view('sub-kategori.partials.modal-create', compact('kategoriList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_sub_kategori' => 'required|max:100',
            'batas_harga' => 'required'
        ]);

        $batasHarga = (int) str_replace('.', '', $request->batas_harga);

        SubKategori::create([
            'kategori_id' => $request->kategori_id,
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'batas_harga' => $batasHarga,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('sub-kategori.index')->with('success', 'Sub Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategoriList = Kategori::all();
        return view('sub_kategori.edit', compact('sub_kategori', 'kategoriList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubKategori $sub_kategori)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_sub_kategori' => 'required|max:100',
            'batas_harga' => 'required'
        ]);

        $batasHarga = (int) str_replace('.', '', $request->batas_harga);

        $sub_kategori->update([
            'kategori_id' => $request->kategori_id,
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'batas_harga' => $batasHarga
        ]);

        return redirect()->route('sub-kategori.index')->with('success', 'Sub Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubKategori $sub_kategori)
    {
        $sub_kategori->delete();
        return redirect()->route('sub-kategori.index')->with('success', 'Sub Kategori berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::orderBy('created_at', 'desc')->paginate(10); // 👈 penting!
        return view('kategori.index', compact('kategoris'));
    }

    public function datatable()
    {
        $query = Kategori::with(['creator', 'updater']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('creator', fn($row) => optional($row->creator)->name ?? '-')
            ->addColumn('updater', fn($row) => optional($row->updater)->name ?? '-')
            ->addColumn('aksi', function ($row) {
                $edit = "<a href='#' onclick='openEditModal(" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ")' class='text-blue-400 hover:underline'>✏️</a>";
                $delete = "<form action='" . route('kategori.destroy', $row->id) . "' method='POST' class='inline' onsubmit='return confirm(\"Yakin hapus?\")'>
                " . csrf_field() . method_field('DELETE') . "
                <button type='submit' class='text-red-400 hover:underline ml-2'>🗑️</button>
              </form>";
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:10|unique:kategoris,kode_kategori',
            'nama_kategori' => 'required|string|max:100',
        ]);

        Kategori::create([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'kode_kategori' => 'required|string|max:10|unique:kategoris,kode_kategori,' . $kategori->id,
            'nama_kategori' => 'required|string|max:100',
        ]);

        $kategori->update([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

}

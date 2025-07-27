<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with(['kategori', 'subKategori', 'creator'])->latest()->get();
        return view('transaksi-barang.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();
        $users = User::all(); // kalau mau bisa pilih user juga

        return view('transaksi-barang.create', compact('kategoris', 'subKategoris', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'sub_kategori_id' => 'required|exists:sub_kategoris,id',
            'asal_barang' => 'required|string',
            'nomor_surat' => 'nullable|string',
            'lampiran' => 'nullable|string',
            'detail_barang.nama_barang' => 'required|array',
            'detail_barang.nama_barang.*' => 'required|string',
            'detail_barang.harga' => 'required|array',
            'detail_barang.harga.*' => 'required|string', 
            'detail_barang.jumlah' => 'required|array',
            'detail_barang.jumlah.*' => 'required|numeric',
            'detail_barang.satuan' => 'required|array',
            'detail_barang.satuan.*' => 'required|string',
            'detail_barang.total' => 'required|array',
            'detail_barang.total.*' => 'required|string',
        ]);


        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'kategori_id' => $request->kategori_id,
            'sub_kategori_id' => $request->sub_kategori_id,
            'asal_barang' => $request->asal_barang,
            'nomor_surat' => $request->nomor_surat,
            'lampiran' => $request->lampiran,
            'created_by' => auth()->id(),
        ]);

        $count = count($request->detail_barang['nama_barang']);
        for ($i = 0; $i < $count; $i++) {
            $transaksi->detailTransaksis()->create([
                'nama_barang' => $request->detail_barang['nama_barang'][$i],
                'harga' => str_replace('.', '', $request->detail_barang['harga'][$i]),
                'jumlah' => $request->detail_barang['jumlah'][$i],
                'satuan' => $request->detail_barang['satuan'][$i],
                'total' => str_replace('.', '', $request->detail_barang['total'][$i]),
                'tgl_expired' => $request->detail_barang['tgl_expired'][$i] ?? null,
            ]);
        }

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $kategoris = Kategori::all();
        $subKategoris = SubKategori::all();
        $users = User::all();

        // pastikan relasi detailTransaksis ada
        $transaksi->load('detailTransaksis');

        return view('transaksis.edit', compact('transaksi', 'kategoris', 'subKategoris', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'operator' => 'required|exists:users,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'sub_kategori_id' => 'required|exists:sub_kategoris,id',
            'asal_barang' => 'required|string',
            'nomor_surat' => 'nullable|string',
            'lampiran' => 'nullable|string',
            'detail.*.id' => 'nullable|exists:detail_transaksis,id',
            'detail.*.nama_barang' => 'required|string',
            'detail.*.harga' => 'required|numeric',
            'detail.*.jumlah' => 'required|numeric',
            'detail.*.satuan' => 'required|string',
            'detail.*.total' => 'required|numeric',
        ]);

        $transaksi->update([
            'user_id' => $request->operator,
            'kategori_id' => $request->kategori_id,
            'sub_kategori_id' => $request->sub_kategori_id,
            'asal_barang' => $request->asal_barang,
            'nomor_surat' => $request->nomor_surat,
            'lampiran' => $request->lampiran,
        ]);

        // Hapus detail yang tidak ada di request (jika dihapus oleh user)
        $existingIds = collect($request->detail)->pluck('id')->filter();
        $transaksi->detailTransaksis()->whereNotIn('id', $existingIds)->delete();

        foreach ($request->detail as $item) {
            if (!empty($item['id'])) {
                // Update existing detail
                $transaksi->detailTransaksis()->where('id', $item['id'])->update([
                    'nama_barang' => $item['nama_barang'],
                    'harga' => $item['harga'],
                    'jumlah' => $item['jumlah'],
                    'satuan' => $item['satuan'],
                    'total' => $item['total'],
                    'tgl_expired' => $item['tgl_expired'] ?? null,
                ]);
            } else {
                // Tambahkan detail baru
                $transaksi->detailTransaksis()->create([
                    'nama_barang' => $item['nama_barang'],
                    'harga' => $item['harga'],
                    'jumlah' => $item['jumlah'],
                    'satuan' => $item['satuan'],
                    'total' => $item['total'],
                    'tgl_expired' => $item['tgl_expired'] ?? null,
                ]);
            }
        }

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->detailTransaksis()->delete();
        $transaksi->delete();

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}

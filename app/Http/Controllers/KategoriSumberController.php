<?php

namespace App\Http\Controllers;

use App\Models\KategoriSumber;
use Illuminate\Http\Request;

class KategoriSumberController extends Controller
{
    public function index(Request $request)
    {
        // Logika untuk menampilkan daftar kategori sumber
        // Misalnya, mengambil data dari model KategoriSumber
        $kategoriSumbers = KategoriSumber::all();

        return view('kategori_sumber.index', compact('kategoriSumbers'));
    }

    public function add()
    {
        // Logika untuk menampilkan form tambah kategori sumber
        return view('kategori_sumber.add');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        // Simpan kategori sumber baru
        KategoriSumber::create($validated);

        return redirect()->route('kategori_sumber.index')->with('success', 'Kategori Sumber berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit kategori sumber
        $kategoriSumber = KategoriSumber::findOrFail($id);
        return view('kategori_sumber.edit', compact('kategoriSumber'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        // Update kategori sumber
        $kategoriSumber = KategoriSumber::findOrFail($id);
        $kategoriSumber->update($validated);

        return redirect()->route('kategori_sumber.index')->with('success', 'Kategori Sumber berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Logika untuk menghapus kategori sumber
        $kategoriSumber = KategoriSumber::findOrFail($id);
        $kategoriSumber->delete();

        return redirect()->route('kategori_sumber.index')->with('success', 'Kategori Sumber berhasil dihapus.');
    }
}

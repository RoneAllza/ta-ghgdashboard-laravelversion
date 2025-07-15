<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    //
    public function index(){
        $perusahaans = Perusahaan::first();
        return view('perusahaan.index', compact('perusahaans'));
    }

    public function edit($id){
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, $id){
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update($request->all());
        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil diperbarui.');
    }
}

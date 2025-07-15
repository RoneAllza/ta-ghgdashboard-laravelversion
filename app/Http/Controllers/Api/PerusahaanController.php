<?php

namespace App\Http\Controllers\Api;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PerusahaanResource;

class PerusahaanController extends Controller
{
    public function index(){
        // $perusahaan = Perusahaan::with(['sumber_emisis'])->latest()->paginate(15);
        $perusahaan = Perusahaan::all();
        return PerusahaanResource::collection($perusahaan);
    }

    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kab_kota' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $perusahaan->update($validated);

        return new PerusahaanResource($perusahaan);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KategoriEmisiResource;
use App\Http\Resources\SumberEmisiResource;
use App\Models\FuelProperties;
use App\Models\KategoriSumber;
use App\Models\SumberEmisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SumberEmisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $sumberEmisis = SumberEmisi::with('fuel_properties')->latest()->paginate(15);
        if (!$sumberEmisis) {
            return response()->json([
                'success' => false,
                'message' => 'Sensor not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Sensor detail',
            'data' => new SumberEmisiResource($sumberEmisis)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sumber' => 'required|string|max:255',
            'kategori_sumber_id' => 'required|exists:kategori_sumbers,id',
            // 'tipe_sumber' => 'required|in:kendaraan,alat_berat,boiler,lainnya',
            'frekuensi_hari' => 'required|integer|min:1',
            'kapasitas_output' => 'nullable|numeric|min:0.001',
            'unit' => 'required|in:ton,liter',
            'durasi_pemakaian' => 'required|numeric|min:0.001',
            'fuel_properties_id' => 'required|exists:fuel_properties,id',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Unprocessable Entity
        }

        $kategori = KategoriSumber::findOrFail($request->kategori_sumber_id);

        $fuel = FuelProperties::findOrFail($request->fuel_properties_id);

        // dd($fuel->toArray());
        $emissionFactors = json_encode([
            "co2" => $fuel->co2_factor,
            "ch4" => $fuel->ch4_factor,
            "n2o" => $fuel->n2o_factor,
        ]);

        $filename = null;
        if ($request->hasFile('dokumentasi')) {
            $filename = $request->file('dokumentasi')->store('public/sumber_emisi');
            $filename = basename($filename); // Ambil nama filenya saja
        };

        $sumberEmisi = SumberEmisi::create([
            'sumber' => $request->sumber,
            'category_code' => $kategori,
            'fuel_properties_id' => $fuel->id,
            'kapasitas_output' => $request->kapasitas_output,
            'durasi_pemakaian' => $request->durasi_pemakaian,
            'frekuensi_hari' => $request->frekuensi_hari,
            'unit' => $request->unit,
            'emission_factors' => $emissionFactors,
            'dokumentasi' => $filename,
        ]);

        return (new SumberEmisiResource($sumberEmisi->load('fuel_properties')))
                ->response()
                ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $sumberEmisi = SumberEmisi::with('fuel_properties')->find($id);
        if (!$sumberEmisi) {
            return response()->json([
                'success' => false,
                'message' => 'Sensor not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Sensor detail',
            'data' => new SumberEmisiResource($sumberEmisi)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sumber = SumberEmisi::find($id);
        if(!$sumber){
            return response()->json([
                'success' => false,
                'message' => 'Sumber Emisi not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'sumber' => 'nullable|string|max:255',
            'kategori_sumber_id' => 'nullable|exists:kategori_sumbers,id',
            // 'tipe_sumber' => 'nullable|string|max:255',
            'frekuensi_hari' => 'nullable|integer|min:1',
            'kapasitas_output' => 'nullable|numeric|min:0.001',
            'unit' => 'nullable|string|max:255',
            'durasi_pemakaian' => 'nullable|numeric|min:0.001',
            'fuel_properties_id' => 'nullable|exists:fuel_properties,id',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $sumber->update($request->only([
            'sumber', 'kategori_sumber_id', 'tipe_sumber', 'frekuensi_hari',
            'kapasitas_output', 'unit', 'durasi_pemakaian', 'fuel_properties_id'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Sumber Emisi updated successfully',
            'data' => new SumberEmisiResource($sumber->load('fuel_properties'))
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sumber = SumberEmisi::find($id);
        if (!$sumber) {
            return response()->json([
                'success' => false,
                'message' => 'Sumber Emisi not found',
            ], 404);
        }
        $sumber->delete();
        return response()->json([
            'success' => true,
            'message' => 'Sumber Emisi deleted successfully',
        ], 200);
    }
}

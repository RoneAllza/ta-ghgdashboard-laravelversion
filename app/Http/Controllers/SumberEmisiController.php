<?php

namespace App\Http\Controllers;

use App\Exports\SumberEmisiExport;
use App\Models\FuelProperties;
use App\Models\KategoriSumber;
use App\Models\SumberEmisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\Facades\Excel;

class SumberEmisiController extends Controller
{
    // melihat isi sumber emisi
    public function index(Request $request)
    {
        $searchEmisi = $request->input('search_emisi');
        $searchFuel = $request->input('search_fuel');
        $searchKategori = $request->input('search_kategori');

        $sumberEmisiQuery = SumberEmisi::query();
        $fuelPropertiesQuery = FuelProperties::query();
        // $kategoriSumbers = KategoriSumber::all();
        $kategoriSumbersQuery = KategoriSumber::query();

        if ($searchEmisi) {
            $sumberEmisiQuery->where('sumber', 'like', "%$searchEmisi%")
                ->orWhere('tipe_sumber', 'like', "%$searchEmisi%")
                ->orWhere('kapasitas_output', 'like', "%$searchEmisi%")
                ->orWhere('unit', 'like', "%$searchEmisi%")
                ;
        }
        if ($searchFuel) {
            $fuelPropertiesQuery->where('fuel_type', 'like', "%$searchFuel%")
                ->orWhere('conversion_factor', 'like', "%$searchFuel%")
                ;
        }

        if ($searchKategori) {
            $kategoriSumbersQuery->where('nama', 'like', "%$searchKategori%")
                ->orWhere('kode', 'like', "%$searchKategori%")
                ->orWhere('deskripsi', 'like', "%$searchKategori%");
        }

        $fuelProperties = $fuelPropertiesQuery->paginate(5, ['*'], 'fuel_page');
        $sumberEmisis = $sumberEmisiQuery->paginate(5, ['*'], 'emisi_page');
        $kategoriSumbers = $kategoriSumbersQuery->paginate(5, ['*'], 'kategori_page');

        // Jika AJAX dan hanya ingin tabel fuel properties
        if ($request->ajax() && $request->has('fuel_only')) {
            // Render hanya bagian tabel fuel properties dari blade utama
            $view = view('sumber_emisi.index', [
                'sumberEmisis' => $sumberEmisis,
                'fuelProperties' => $fuelProperties,
                // 'kategoriSumbers' => $kategoriSumbers,
                'onlyFuelTable' => true
            ])->renderSections();
            return response()->json(['html' => $view['fuel_table']]);
        } elseif ($request->ajax() && $request->has('kategori_only')) {
            // Render hanya bagian tabel fuel properties dari blade utama
            $view = view('sumber_emisi.index', [
                'sumberEmisis' => $sumberEmisis,
                // 'fuelProperties' => $fuelProperties,
                'kategoriSumbers' => $kategoriSumbers,
                'onlyFuelTable' => true
            ])->renderSections();
            return response()->json(['html' => $view['kategori_table']]);
        }
        return view('sumber_emisi.index', compact('sumberEmisis', 'fuelProperties', 'kategoriSumbers'));
    }

    public function create()
    {

        $fuelProperties = FuelProperties::all();
        $kategoriSumbers = KategoriSumber::all();
        return view('sumber_emisi.add', compact('fuelProperties', 'kategoriSumbers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sumber' => 'required',
            'kategori_sumber_id' => 'required|exists:kategori_sumbers,id',
            // 'tipe_sumber' => 'required', // tidak perlu validasi ini
            'frekuensi_hari' => 'required|integer|min:1',
            'kapasitas_output' => 'nullable|numeric|min:0.001',
            'unit' => 'required|in:ton,liter',
            'durasi_pemakaian' => 'required|numeric|min:0.001',
            'fuel_properties_id' => 'required|exists:fuel_properties,id',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $kategori = KategoriSumber::findOrFail($request->kategori_sumber_id);
        $fuel = FuelProperties::findOrFail($request->fuel_properties_id);

        $emissionFactors = json_encode([
            "co2" => $fuel->co2_factor,
            "ch4" => $fuel->ch4_factor,
            "n2o" => $fuel->n2o_factor,
        ]);

        $filename = null;
        if ($request->hasFile('dokumentasi')) {
            $file = $request->file('dokumentasi');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sumber_emisi/'), $filename);
        }

        $emisi = SumberEmisi::create([
            'sumber' => $validated['sumber'],
            'tipe_sumber' => $kategori->nama, // otomatis dari kategori
            'category_code' => $kategori->kode,
            'kategori_sumber_id' => $kategori->id,
            'fuel_properties_id' => $fuel->id,
            'kapasitas_output' => $request->kapasitas_output,
            'durasi_pemakaian' => $validated['durasi_pemakaian'],
            'frekuensi_hari' => $validated['frekuensi_hari'],
            'unit' => $validated['unit'],
            'emission_factors' => $emissionFactors,
            'dokumentasi' => $filename,
        ]);

        // Redirect sesuai role
        $user = auth()->user();
        if ($user && $user->role === 'teknisi') {
            return redirect()->route('teknisi_emisis.index')->with('success', 'Sumber Emisi berhasil ditambahkan.');
        }
        return redirect()->route('emisi.index')->with('success', 'Sumber Emisi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sumberEmisi = SumberEmisi::findOrFail($id);
        $fuelProperties = FuelProperties::all();
        $kategoriSumbers = KategoriSumber::all();
        // $tipeSumberOptions = [
        //     'kendaraan' => 'Kendaraan',
        //     'alat_berat' => 'Alat Berat',
        //     'boiler' => 'Boiler',
        //     'lainnya' => 'Lainnya',
        //     'genset' => 'Genset',
        //     'dryer' => 'Dryer',
        //     'ventilasi' => 'Ventilasi Tambang',
        // ];
        return view('sumber_emisi.edit', compact('sumberEmisi', 'fuelProperties', 'kategoriSumbers'));
    }

    public function show($id){
        $sumberEmisi = SumberEmisi::findOrFail($id);
        // dd($sumberEmisi);
        return view('sumber_emisi.show', compact('sumberEmisi'));
    }

    public function destroy($id){
        $sumberEmisi = SumberEmisi::findOrFail($id);
        $sumberEmisi->delete();
        return redirect()->route('emisi.index')->with('success', 'Sumber Emisi berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $sumberEmisi = SumberEmisi::findOrFail($id);

        $validated = $request->validate([
            'sumber' => 'required',
            'kategori_sumber_id' => 'required|exists:kategori_sumbers,id',
            // 'tipe_sumber' => 'required', // tidak perlu validasi ini
            'frekuensi_hari' => 'required|integer|min:1',
            'kapasitas_output' => 'nullable|numeric|min:0.001',
            'unit' => 'required|in:ton,liter',
            'durasi_pemakaian' => 'required|numeric|min:0.001',
            'fuel_properties_id' => 'required|exists:fuel_properties,id',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $kategori = KategoriSumber::findOrFail($request->kategori_sumber_id);
        $fuel = FuelProperties::findOrFail($request->fuel_properties_id);
        $emissionFactors = json_encode([
            "co2" => $fuel->co2_factor,
            "ch4" => $fuel->ch4_factor,
            "n2o" => $fuel->n2o_factor,
        ]);

        // Handle file upload
        if ($request->hasFile('dokumentasi')) {
            if ($sumberEmisi->dokumentasi && file_exists(public_path('uploads/sumber_emisi/' . $sumberEmisi->dokumentasi))) {
                unlink(public_path('uploads/sumber_emisi/' . $sumberEmisi->dokumentasi));
            }
            $file = $request->file('dokumentasi');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/sumber_emisi/'), $filename);
            $sumberEmisi->dokumentasi = $filename;
        }

        $sumberEmisi->sumber = $validated['sumber'];
        $sumberEmisi->tipe_sumber = $kategori->nama; // otomatis dari kategori
        $sumberEmisi->category_code = $kategori->kode;
        $sumberEmisi->kategori_sumber_id = $kategori->id;
        $sumberEmisi->fuel_properties_id = $fuel->id;
        $sumberEmisi->kapasitas_output = $request->kapasitas_output;
        $sumberEmisi->durasi_pemakaian = $validated['durasi_pemakaian'];
        $sumberEmisi->frekuensi_hari = $validated['frekuensi_hari'];
        $sumberEmisi->unit = $validated['unit'];
        $sumberEmisi->emission_factors = $emissionFactors;

        $sumberEmisi->save();

        $user = auth()->user();
        if ($user && $user->role === 'teknisi') {
            return redirect()->route('teknisi_emisis.index')->with('success', 'Sumber Emisi berhasil diupdate.');
        }
        return redirect()->route('emisis.index')->with('success', 'Sumber Emisi berhasil diupdate.');
    }

    public function export(){
        return Excel::download(new SumberEmisiExport, 'sumber_emisi.xlsx');
    }
    public function test(){
        $fuel_properties_id = 1;
        $fuel = FuelProperties::findOrFail($fuel_properties_id);

        $sumber_emisi = SumberEmisi::where('fuel_properties_id', $fuel_properties_id)->first();
        $emissionFactors = [
            'co2' => $fuel->co2_factor,
            'ch4' => $fuel->ch4_factor,
            'n2o' => $fuel->n2o_factor,
        ];
        // dd(json_encode($sumber_emisi) );
        dd(SumberEmisi::latest()->first());
    }


}

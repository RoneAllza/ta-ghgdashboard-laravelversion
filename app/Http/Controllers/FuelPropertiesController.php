<?php

namespace App\Http\Controllers;

use App\Models\FuelProperties;
use Illuminate\Http\Request;

class FuelPropertiesController extends Controller
{
    //
    public function index()
    {
        // Use pagination for fuel properties
        $fuelProps = FuelProperties::paginate(5); // 5 per page, adjust as needed
        // Jika request AJAX, kembalikan partial view
        // if (request()->ajax()) {
        //     return view('fuel_props._table', ['fuelProperties' => $fuelProps])->render();
        // }
        return view('fuel_props.index', compact('fuelProps'));
    }

    public function addFuelProps(){
        // Logika untuk menampilkan form tambah properti bahan bakar
        return view('fuel_props.add');
    }

    public function store(Request $request)
    {
        // Logika untuk menyimpan properti bahan bakar
        $validated = $request->validate([
            'fuel_type' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'conversion_factor' => 'required|numeric|min:0',
            'co2_factor' => 'required|numeric|min:0',
            'ch4_factor' => 'required|numeric|min:0',
            'n2o_factor' => 'required|numeric|min:0',
        ]);

        FuelProperties::create($validated);
        return redirect()->route('fuel_props.index')->with('success', 'Fuel property added successfully.');
    }
    public function editFuelProps($id){
        // Logika untuk menampilkan form edit properti bahan bakar
        $fuelProp = FuelProperties::findOrFail($id);
        return view('fuel_props.edit', compact('fuelProp'));
    }

    public function update(Request $request, $id)
    {
        // Logika untuk memperbarui properti bahan bakar
        $fuelProp = FuelProperties::findOrFail($id);
        $fuelProp->update($request->all());
        return redirect()->route('emisi.index')->with('success', 'Fuel property updated successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Maintenances;
use App\Models\Sensor;
use Illuminate\Http\Request;

class MaintenancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenance_sensor = Maintenances::with('sensor')->get();
        return view('maintenances.index', compact('maintenance_sensor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add()
    {
        //
        $sensors = Sensor::all();
        return view('maintenances.add', compact('sensors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'nama_alat' => 'required|string|max:255',
            'jenis_maintenance' => 'required|string|max:255',
            'jenis_alat' => 'required|string|max:255',
            // 'teknisi' => 'required|string|max:255', // diisi otomatis saat kerjakan
            // 'keterangan' => 'nullable|string|max:500', // diisi saat selesai
        ]);

        $maintenance = Maintenances::create([
            'sensor_id' => $validate['sensor_id'],
            'nama_alat' => $validate['nama_alat'],
            'jenis_maintenance' => $validate['jenis_maintenance'],
            'jenis_alat' => $validate['jenis_alat'],
            'status' => 'waiting',
        ]);
        return redirect()->route('maintenance.index')->with('success', 'Berhasil membuat record Maintenance');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $maintenance = Maintenances::with('sensor')->findOrFail($id);
        return view('maintenances.show', compact('maintenance'));
    }

    /**
     * Kerjakan maintenance (teknisi)
     */
    public function kerjakan($id)
    {
        $maintenance = Maintenances::findOrFail($id);
        if ($maintenance->status === 'waiting') {
            $maintenance->waktu_mulai = now();
            $maintenance->status = 'in_progress';
            $maintenance->teknisi = auth()->user()->name; // Set teknisi sesuai user login
            $maintenance->save();
        }
        return redirect()->back()->with('success', 'Maintenance dimulai.');
    }

    /**
     * Selesaikan maintenance (teknisi)
     */
    public function selesai(Request $request, $id)
    {
        $maintenance = Maintenances::findOrFail($id);
        if ($maintenance->status === 'in_progress') {
            $maintenance->waktu_selesai = now();
            $maintenance->status = 'selesai';
            if ($request->has('keterangan')) {
                $maintenance->keterangan = $request->input('keterangan');
            }
            $maintenance->save();
        }
        return redirect()->back()->with('success', 'Maintenance selesai.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenances $maintenances)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenances $maintenances)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenances $maintenances)
    {
        //
    }
}

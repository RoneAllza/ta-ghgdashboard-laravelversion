<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Exports\SensorExport;
use App\Models\ThingspeakChannel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use App\Notifications\SensorAdded;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all sensors from the database
        $sensors = Sensor::all();
        // $channels = ThingspeakChannel::all();
        // return view('sensor.index', compact('sensors', 'channels'));
        return view('sensor.index', compact('sensors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new sensor
        // $channels = ThingspeakChannel::all();
        // return view('sensor.create', compact('channels'));
        return view('sensor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        // $request->validate([
        //     'sensor_id' => 'required|string|max:255',
        //     'sensor_type' => 'required|string|max:255',
        //     'latitude' => 'required|numeric',
        //     'longitude' => 'required|numeric',
        // ]);
        $validated = $request->validate([
            'field' => 'required|string|max:255',
            'sensor_name' => 'required|string|max:255',
            'parameter_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        // Create a new sensor instance
        $sensor = Sensor::create([
            // 'thingspeak_channel_id' => $validated['thingspeak_channel_id'],
            'field' => $validated['field'],
            'sensor_name' => $validated['sensor_name'],
            'parameter_name' => $validated['parameter_name'],
            'unit' => $validated['unit'],
            'description' => $validated['description'] ?? null, // Optional description
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        // Kirim notifikasi ke semua user (atau sesuaikan target user)
        foreach (User::all() as $user) {
            $user->notify(new SensorAdded($sensor));
        }

        // Tambahkan pemanggilan command perhitungan otomatis
        // Artisan::call('app:generate-fuel-combustion-activity');

        return redirect()->route('sensors.index')->with('success', 'Sensor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensor $sensor)
    {
        //  Return the view with the sensor data
        return view('sensors.show', compact('sensor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sensor = Sensor::findOrFail($id);
        $sensorOptions = [
            'field1' => 'Field 1 - Kecepatan Angin (m/s)',
            'field2' => 'Field 2 - Suhu (°C)',
            'field3' => 'Field 3 - Kelembaban (%)',
            'field4' => 'Field 4 - Tekanan (hPa)',
            'field5' => 'Field 5 - Kualitas Udara (AQI)',
            'field6' => 'Field 6 - CO2 (ppm)',
            'field7' => 'Field 7 - CH4 (ppm)',
            'field8' => 'Field 8 - N2O (ppm)',
            'field9' => 'Field 9 - PM2.5 (µg/m³)',
            'field10' => 'Field 10 - PM10 (µg/m³)',
        ];
        return view('sensor.edit', compact('sensor', 'sensorOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info('Update sensor called', ['user' => auth()->user(), 'request' => $request->all()]);
        $sensor = Sensor::findOrFail($id);

        $rules = [
            'field' => 'sometimes|string|max:255',
            'sensor_name' => 'sometimes|string|max:255',
            'parameter_name' => 'sometimes|string|max:255',
            'unit' => 'sometimes|string|max:50',
            'description' => 'nullable|string|max:255',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
        ];

        $validated = $request->validate($rules);

        $sensor->update($validated);

        return redirect()->route('sensors.index')->with('success', 'Sensor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the sensor by ID
        $sensor = Sensor::findOrFail($id);
        // Delete the sensor from the database
        $sensor->delete();
        // Redirect to the sensors index page with a success message
        return redirect()->route('sensors.index')->with('success', 'Sensor deleted successfully.');
    }

    public function export(){
        return Excel::download(new SensorExport, 'sensor.xlsx');
    }
}

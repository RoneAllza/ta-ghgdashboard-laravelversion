<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\ReportExportTahunanMultiSheet;
use App\Models\SensorEntry;
use App\Models\Perusahaan;
use App\Models\Report;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

class ReportController extends Controller
{
    // public function index(Request $request)
    public function index()
    {
        // $periodType = $request->get('period_type', 'harian');
        // $reports = Report::query();
        // if ($periodType === 'harian') {
        //     $reports = $reports->whereDate('updated_at', now()->toDateString());
        // } elseif ($periodType === 'bulanan') {
        //     $reports = $reports->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year);
        // } elseif ($periodType === 'tahunan') {
        //     $reports = $reports->whereYear('updated_at', now()->year);
        // }
        // $reports = $reports->get();
        // dd($reports);
        // $total_emission = $this->calculateTotalEmission();
        // return view('reports.index', compact('reports', 'total_emission', 'periodType'));
        $reports = Report::all();
        return view('reports.index', compact('reports'));
    }

    public function create(){
        // nama sensor
        $nama_sensor = SensorEntry::where('sensor_id', 'sensor_gas_01')
                        ->whereNotNull('sensor_id')
                        ->avg('sensor_id');
                        // ->first();
                        
        $total_ch4 = SensorEntry::where('sensor_id', 'sensor_gas_01')
                        ->whereNotNull('ch4_value')
                        ->avg('ch4_value');

        // Hitung total CO2 setahun
        $total_co2 = SensorEntry::where('sensor_id', 'sensor_gas_01')
                        ->whereNotNull('co2_value')
                        ->avg('co2_value');

        $perusahaan = Perusahaan::all();
        return view('reports.create', compact('nama_sensor', 'total_ch4', 'total_co2', 'perusahaan'));
        // dd($perusahaan);
    }

    public function show($id){
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    public function store(Request $request){
        // dd('test');

        $perusahaan = Perusahaan::all();
        $mqtt_data = SensorEntry::where('sensor_id', $request->id)->first();
        $report = new Report;
        $request->validate([
            'total_ch4' => 'required|numeric',
            'total_co2' => 'required|numeric',
            'komentar' => 'nullable|string',
            'status' => 'required|in:draft,diproses,diteruskan,diterima,dikembalikan',
        ]);

        $report->total_ch4 = $request->total_ch4;
        $report->total_co2 = $request->total_co2;
        $report->komentar = $request->komentar;
        $report->status = $request->status;
        $report->perusahaan_id = $request->perusahaan_id;
        // $report->sensor_id = $mqtt_data->id;
        $report->save();

        return redirect('/report');
    }
    
    
    public function calculateTotalEmission(){
        $total_emission = 0;
        $data = SensorEntry::all();
        foreach ($data as $item) {
            $total_emission += $item->CH4 * 0.000001 + $item->CH2 * 0.000001;
        }
        return response()->json(['total_emission' => $total_emission]);
    }

    public function export(Request $request)
    {
        $periodType = $request->get('period_type', 'harian');
        $tanggal = $request->get('tanggal');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        if($periodType === 'tahunan'){
            return Excel::download(new ReportExportTahunanMultiSheet($tahun), 'report_'. $tahun .'.xlsx');
        } else if($periodType === 'bulanan'){
            return Excel::download(new ReportExport($periodType, $tanggal, $bulan, $tahun), 'report_' . $bulan .'.xlsx');

        }
        return Excel::download(new ReportExport($periodType, $tanggal, $bulan, $tahun), 'report.xlsx');
    }

    public function accept(Report $report){
        $report->update(['status'=>"disetujui"]);
        return redirect('/report')->with('success', 'Laporan diterima');
    }

    // Fungsi untuk generate laporan dari frontend
    public function generate(Request $request)
    {
        $periodType = $request->input('period_type', 'bulanan');
        $perusahaanId = $request->input('perusahaan_id');
        $date = $request->input('date', now()->toDateString());

        // Format periode sesuai periodType
        if ($periodType === 'harian') {
            $periode = date('Y-m-d', strtotime($date));
        } elseif ($periodType === 'bulanan') {
            $periode = date('Y-m', strtotime($date));
        } else {
            $periode = date('Y', strtotime($date));
        }

        // Jalankan command GenerateGHGReport secara programatik
        Artisan::call('app:generate-ghg-report', [
            '--periode' => $periode,
            '--perusahaan_id' => $perusahaanId
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil digenerate!');
    }
}

<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell, WithTitle
{
    protected $periodType;
    protected $tanggal;
    protected $bulan;
    protected $tahun;

    public function __construct($periodType = 'harian', $tanggal = null, $bulan = null, $tahun = null)
    {
        $this->periodType = $periodType;
        $this->tanggal = $tanggal;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = Report::with(['perusahaan', 'sumber_emisi', 'sensor'])
            ->where('period_type', $this->periodType);

        if ($this->periodType === 'harian' && $this->tahun) {
            $query->whereYear('period_date', $this->tahun);
        } elseif ($this->periodType === 'bulanan' && $this->tahun) {
            $query->whereYear('period_date', $this->tahun);
        } elseif ($this->periodType === 'tahunan' && $this->tahun) {
            $query->whereYear('period_date', $this->tahun);
        }

        return $query->get();
    }


    public function headings(): array
    {
        return [
            'ID',
            'Nama Laporan',
            'Tipe Periode',
            'Tanggal Periode',
            'Kode Kategori',
            'Total CO2',
            'Total CH4',
            'Total N2O',
            'Total PM2.5',
            'Total PM10',
            'Rata-rata CO2',
            'Rata-rata CH4',
            'Rata-rata N2O',
            'Rata-rata PM2.5',
            'Rata-rata PM10',
            'Komentar',
            'Perusahaan',
            'Sumber Emisi',
            'Sensor',
            'Status',
            'Terakhir Diperbarui'
        ];
    }

    public function map($report): array
    {
        return [
            $report->id,
            $report->report_name,
            $report->period_type,
            $report->period_date,
            $report->category_code,
            $report->total_co2,
            $report->total_ch4,
            $report->total_n2o,
            $report->total_pm25,
            $report->total_pm10,
            $report->avg_co2,
            $report->avg_ch4,
            $report->avg_n2o,
            $report->avg_pm25,
            $report->avg_pm10,
            $report->komentar,
            $report->perusahaan?->nama ?? '-',
            $report->sumber_emisi?->sumber ?? '-',
            $report->sensor?->sensor_name ?? '-',
            ucfirst($report->status ?? '-'),
            optional($report->updated_at)->format('Y-m-d H:i:s'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $firstReport = $this->collection()->first();
                $perusahaan = $firstReport?->perusahaan;
                $sheet = $event->sheet->getDelegate();

                if ($perusahaan) {
                    $identitas = [
                        'Nama'         => $perusahaan->nama,
                        'Alamat'       => $perusahaan->alamat,
                        'Provinsi'     => $perusahaan->provinsi,
                        'Kab/Kota'     => $perusahaan->kab_kota,
                        'Kecamatan'    => $perusahaan->kecamatan,
                        'Kelurahan'    => $perusahaan->kelurahan,
                        'No. Telp'     => $perusahaan->no_telp,
                        'Kode Pos'     => $perusahaan->kode_pos,
                        'Tipe Periode' => $this->periodType,
                        'Tanggal'      => match ($this->periodType) {
                            'harian'  => $this->tanggal,
                            'bulanan' => $this->bulan,
                            'tahunan' => $this->tahun,
                            default   => '-'
                        },
                    ];

                    $row = 1;
                    foreach ($identitas as $label => $value) {
                        $sheet->setCellValue('A' . $row, $label);
                        $sheet->setCellValue('B' . $row, $value);
                        $row++;
                    }
                }
            }
        ];
    }

    public function startCell(): string
    {
        return 'A12';
    }

    public function title(): string
    {
        return ucfirst($this->periodType);
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportExportTahunanMultiSheet implements WithMultipleSheets
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function sheets(): array
    {
        return [
            new ReportExport('tahunan', null, null, $this->tahun),
            new ReportExport('bulanan', null, null, $this->tahun),
            new ReportExport('harian', null, null, $this->tahun),
            new SumberEmisiExport(),
            new SensorExport(),
        ];
    }
}

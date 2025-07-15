<?php

namespace App\Exports;

use App\Models\Sensor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SensorExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return Sensor::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Sensor',
            'Field',
            'Parameter',
            'Satuan',
            'Latitude',
            'Longitude',
        ];
    }

    public function map($sensor): array
    {
        return [
            $sensor->id,
            $sensor->sensor_name,
            $sensor->field,
            $sensor->parameter_name,
            $sensor->unit,
            $sensor->latitude,
            $sensor->longitude,
        ];
    }

    public function title(): string
    {
        return 'Sensor';
    }
}

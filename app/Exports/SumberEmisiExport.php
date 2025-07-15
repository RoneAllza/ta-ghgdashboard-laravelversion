<?php

namespace App\Exports;

use App\Models\SumberEmisi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SumberEmisiExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return SumberEmisi::with('fuel_properties')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Sumber',
            'Tipe Sumber',
            'Kapasitas Output',
            'Frekuensi Hari',
            'Unit',
            'Faktor Konsumsi',
            'Durasi Pemakaian',
            'Emission CO2',
            'Emission CH4',
            'Emission N2O',
            'Dokumentasi',
            'ID Fuel Properties'
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->sumber,
            $item->tipe_sumber,
            $item->kapasitas_output,
            $item->frekuensi_hari,
            $item->unit,
            $item->faktor_konsumsi,
            $item->durasi_pemakaian,
            $item->emission_factors['co2'] ?? '-',
            $item->emission_factors['ch4'] ?? '-',
            $item->emission_factors['n2o'] ?? '-',
            $item->dokumentasi,
            $item->fuel_properties_id ?? '-',
        ];
    }

    public function title(): string
    {
        return 'Sumber Emisi';
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_sumbers')->insert([
            [
                'nama' => "Genset",
                'kode' => "1A1",
                'deskripsi' => "Genset yang digunakan untuk sumber daya listrik cadangan",
            ],
            [
                'nama' => "Boiler",
                'kode' => "1A1",
                'deskripsi' => "Genset yang digunakan untuk sumber daya listrik cadangan",
            ],
            [
                'nama' => "Alat Berat",
                'kode' => "1A2",
                'deskripsi' => "Alat berat yang digunakan dalam konstruksi dan pertambangan",
            ],
            [
                'nama' => "Kendaraan",
                'kode' => "1A2",
                'deskripsi' => "Kendaraan untuk keperluan operasional dan transportasi",
            ],
            [
                'nama' => "Ventilasi",
                'kode' => "1B2",
                'deskripsi' => "Sistem ventilasi yang digunakan untuk sirkulasi udara",
            ],

        ]);
    }
}

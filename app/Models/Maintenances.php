<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenances extends Model
{
    protected $fillable = [
        'sensor_id',
        'nama_alat',
        'jenis_maintenance',
        'jenis_alat',
        'waktu_mulai',
        'waktu_selesai',
        'teknisi',
        'keterangan',
        'status',
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}

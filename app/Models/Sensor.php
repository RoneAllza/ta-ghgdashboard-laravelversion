<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $fillable = [
        'sensor_name',
        'field',
        'parameter_name',
        'unit',
        'latitude',
        'longitude',
    ];
    // protected $casts = [
    //     'installation_date' => 'date:Y-m-d'
    // ];
    
    // public function thingspeakChannel()
    // {
    //     return $this->belongsTo(ThingspeakChannel::class);
    // }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function maintenances()
    {
        return $this->hasMany(Maintenances::class);
    }
}

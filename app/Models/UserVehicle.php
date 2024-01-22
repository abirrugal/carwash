<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function vehicle_name()
    {
        return $this->belongsTo(VehicleName::class);
    }
}

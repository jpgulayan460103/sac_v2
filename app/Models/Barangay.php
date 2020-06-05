<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $fillable = [
        'barangay_name',
        'barangay_psgc',
        'province_name',
        'province_psgc',
        'city_name',
        'city_psgc',
        'district',
        'subdistrict',
    ];
}

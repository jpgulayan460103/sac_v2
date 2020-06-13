<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HouseholdHead;
use App\Models\Barangay;
use DB;

class ReportController extends Controller
{
    public function encoding(Type $var = null)
    {
        $barangay = Barangay::query();
        $barangay->join('household_heads', 'barangays.id', '=', 'household_heads.barangay_id');
        $barangay->select(DB::raw('count(household_heads.id) as total_encoded'), 'barangays.id', 'barangays.barangay_name', 'barangays.city_name', 'barangays.province_name');
        $barangay->groupBy("barangays.id");
        $barangay->orderBy("barangays.barangay_name");
        return [
            'encoded' => $barangay->get()
        ];
    }
}

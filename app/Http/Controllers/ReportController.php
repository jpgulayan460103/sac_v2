<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HouseholdHead;
use App\Models\Barangay;
use DB;

class ReportController extends Controller
{
    public function encodingBarangay(Type $var = null)
    {
        $barangay = Barangay::query();
        $barangay->join('household_heads', 'barangays.id', '=', 'household_heads.barangay_id');
        $barangay->select(
            DB::raw('count(household_heads.id) as total_encoded'),
            DB::raw('sum(case when household_heads.sap_type = "REGULAR" OR household_heads.sap_type is null then 1 else 0 end) total_regular'),
            DB::raw('sum(case when household_heads.sap_type = "LEFTOUT" then 1 else 0 end) total_leftout'),
            'barangays.id', 'barangays.barangay_name', 'barangays.city_name', 'barangays.province_name');
        $barangay->groupBy("barangays.id");
        $barangay->orderBy("barangays.province_name");
        $barangay->orderBy("barangays.city_name");
        $barangay->orderBy("barangays.barangay_name");
        return [
            'encoded' => $barangay->get()
        ];
    }

    public function encodingProvince(Type $var = null)
    {
        $barangay = Barangay::query();
        $barangay->join('household_heads', 'barangays.id', '=', 'household_heads.barangay_id');
        $barangay->select(
            DB::raw('count(household_heads.id) as total_encoded'),
            DB::raw('sum(case when household_heads.sap_type = "REGULAR" OR household_heads.sap_type is null then 1 else 0 end) total_regular'),
            DB::raw('sum(case when household_heads.sap_type = "LEFTOUT" then 1 else 0 end) total_leftout'),
            'barangays.id', 'barangays.province_name');
        $barangay->groupBy("barangays.province_name");
        $barangay->orderBy("barangays.province_name");
        return [
            'encoded' => $barangay->get()
        ];
    }

    public function encodingCity(Type $var = null)
    {
        $barangay = Barangay::query();
        $barangay->join('household_heads', 'barangays.id', '=', 'household_heads.barangay_id');
        $barangay->select(
            DB::raw('count(household_heads.id) as total_encoded'),
            DB::raw('sum(case when household_heads.sap_type = "REGULAR" OR household_heads.sap_type is null then 1 else 0 end) total_regular'),
            DB::raw('sum(case when household_heads.sap_type = "LEFTOUT" then 1 else 0 end) total_leftout'),
            'barangays.id', 'barangays.city_name', 'barangays.province_name');
        $barangay->groupBy("barangays.city_name");
        $barangay->orderBy("barangays.province_name");
        $barangay->orderBy("barangays.city_name");
        return [
            'encoded' => $barangay->get()
        ];
    }
}

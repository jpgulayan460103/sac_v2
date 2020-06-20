<?php

use Illuminate\Database\Seeder;
use App\Models\Barangay;

class UpdateDavaoCityProvince extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Barangay::where('city_name', 'DAVAO CITY')->update([
            'province_name' => 'DAVAO DEL SUR (DAVAO CITY)'
        ]);
    }
}

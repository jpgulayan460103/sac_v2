<?php

use Illuminate\Database\Seeder;
use App\Models\Barangay;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode($this->json(), true);
        foreach ($json as $key => $psgc_data) {
            $insert_data['province_name'] = $psgc_data[0];
            $insert_data['province_psgc'] = $psgc_data[1];
            $insert_data['city_name'] = $psgc_data[2];
            $insert_data['city_psgc'] = $psgc_data[3];
            $insert_data['barangay_name'] = $psgc_data[4];
            $insert_data['barangay_psgc'] = $psgc_data[5];
            $insert_data['district'] = $psgc_data[6];
            $insert_data['subdistrict'] = $psgc_data[7];
            $psgc = Barangay::create($insert_data);
            echo "created barangay: $psgc->psgc - $psgc->barangay_name \n";
        }
    }

    public function json()
    {
        $json = file_get_contents("public/psgc.json");
        return $json;
    }
}

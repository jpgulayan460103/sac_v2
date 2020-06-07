<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class BarangayTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($table)
    {
        return [
            'id' => $table->id,
            'barangay_name' => $table->barangay_name,
            'barangay_psgc' => $table->barangay_psgc,
            'province_name' => $table->province_name,
            'province_psgc' => $table->province_psgc,
            'city_name' => $table->city_name,
            'city_psgc' => $table->city_psgc,
            'district' => $table->district,
            'subdistrict' => $table->subdistrict,
        ];
    }
}

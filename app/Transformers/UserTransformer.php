<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transformers\BarangayTransformer;

class UserTransformer extends TransformerAbstract
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
        'barangay'
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
            'name' => $table->name,
            'username' => $table->username,
            'confirmed' => $table->confirmed,
            'role' => $table->role,
            'position' => $table->position,
            'first_name' => $table->first_name,
            'middle_name' => $table->middle_name,
            'last_name' => $table->last_name,
            'barangay_id' => $table->barangay_id,
        ];
    }

    public function includeBarangay($table)
    {
        if($table->barangay){
            return $this->item($table->barangay, new BarangayTransformer);
        }
    }
}

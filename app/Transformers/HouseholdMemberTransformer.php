<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class HouseholdMemberTransformer extends TransformerAbstract
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
            'household_head_id' => $table->household_head_id,
            'first_name' => $table->first_name,
            'middle_name' => $table->middle_name,
            'last_name' => $table->last_name,
            'ext_name' => $table->ext_name,
            'relasyon_sa_punong_pamilya' => $table->relasyon_sa_punong_pamilya,
            'kasarian' => $table->kasarian,
            'kapanganakan' => $table->kapanganakan,
            'trabaho' => $table->trabaho,
            'pinagtratrabahuhang_lugar' => $table->pinagtratrabahuhang_lugar,
            'sektor' => $table->sektor,
            'kondisyon_ng_kalusugan' => $table->kondisyon_ng_kalusugan,
        ];
    }
}

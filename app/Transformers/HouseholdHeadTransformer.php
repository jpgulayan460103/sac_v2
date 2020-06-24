<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transformers\HouseholdMemberTransformer;
use App\Transformers\BarangayTransformer;
use App\Transformers\UserTransformer;

class HouseholdHeadTransformer extends TransformerAbstract
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
        'barangay',
        'members',
        'user',
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
            'barangay_id' => (integer)$table->barangay_id,
            'first_name' => $table->first_name,
            'middle_name' => $table->middle_name,
            'last_name' => $table->last_name,
            'ext_name' => $table->ext_name,
            'kasarian' => $table->kasarian,
            'tirahan' => $table->tirahan,
            'kalye' => $table->kalye,
            'uri_ng_id' => $table->uri_ng_id,
            'numero_ng_id' => $table->numero_ng_id,
            'kapanganakan' => $table->kapanganakan->toDateString(),
            'trabaho' => $table->trabaho,
            'buwanang_kita' => $table->buwanang_kita,
            'cellphone_number' => $table->cellphone_number,
            'pinagtratrabahuhang_lugar' => $table->pinagtratrabahuhang_lugar,
            'sektor' => $table->sektor,
            'kondisyon_ng_kalusugan' => $table->kondisyon_ng_kalusugan,
            'bene_uct' => $table->bene_uct,
            'bene_4ps' => $table->bene_4ps,
            'katutubo' => $table->katutubo,
            'katutubo_name' => $table->katutubo_name,
            'bene_others' => $table->bene_others,
            'others_name' => $table->others_name,
            'petsa_ng_pagrehistro' => $table->petsa_ng_pagrehistro->toDateString(),
            'pangalan_ng_punong_barangay' => $table->pangalan_ng_punong_barangay,
            'pangalan_ng_lswdo' => $table->pangalan_ng_lswdo,
            'barcode_number' => $table->barcode_number,
            'sac_number' => $table->sac_number,
            'remarks' => $table->remarks,
            'sap_type' => $table->sap_type,
            'allow_delete' => $table->created_at->format("m-d-Y") == \Carbon\Carbon::now()->format("m-d-Y"),
            'created_at' => $table->created_at,
        ];
    }

    public function includeBarangay($table)
    {
        if($table->barangay){
            return $this->item($table->barangay, new BarangayTransformer);
        }
    }
    public function includeUser($table)
    {
        if($table->user){
            return $this->item($table->user, new UserTransformer);
        }
    }
    public function includeMembers($table)
    {
        if($table->members){
            return $this->collection($table->members, new HouseholdMemberTransformer);
        }
    }
}

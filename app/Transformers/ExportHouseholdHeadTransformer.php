<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class ExportHouseholdHeadTransformer extends TransformerAbstract
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
    public function transform($data)
    {
        return [
            'H',
            $data['barcode_number'],
            $data['last_name'],
            $data['first_name'],
            $data['middle_name'],
            $data['ext_name'],
            '1 - Puno ng Pamilya',
            Carbon::parse($data['kapanganakan'])->format('m/d/Y'),
            $data['kasarian'],
            $data['trabaho'],
            $data['sektor'],
            $data['kondisyon_ng_kalusugan'],
            $data['barangay']['barangay_psgc'],
            $data['tirahan'],
            $data['kalye'],
            $data['uri_ng_id'],
            $data['numero_ng_id'],
            $data['buwanang_kita'],
            $data['cellphone_number'],
            $data['pinagtratrabahuhang_lugar'],
            $data['bene_uct'],
            $data['bene_4ps'],
            $data['katutubo'],
            convertToDash($data['katutubo_name']),
            $data['bene_others'],
            convertToDash($data['others_name']),
            Carbon::parse($data['petsa_ng_pagrehistro'])->format('m/d/Y'),
            $data['pangalan_ng_punong_barangay'],
            $data['pangalan_ng_lswdo'],
            str_pad($data['sac_number'],8,"0",STR_PAD_LEFT),
            $data['remarks'],
            Carbon::parse($data['created_at'])->format('m/d/Y'),
            $data['user']['username'],
        ];
    }
}

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
            removeFirstCharDash($data['last_name']),
            removeFirstCharDash($data['first_name']),
            removeFirstCharDash($data['middle_name']),
            removeFirstCharDash($data['ext_name']),
            '1 - Puno ng Pamilya',
            Carbon::parse($data['kapanganakan'])->toDateString(),
            $data['kasarian'],
            removeFirstCharDash($data['trabaho']),
            $data['sektor'],
            $data['kondisyon_ng_kalusugan'],
            $data['barangay']['barangay_psgc'],
            removeFirstCharDash($data['tirahan']),
            removeFirstCharDash($data['kalye']),
            $data['uri_ng_id'],
            removeFirstCharDash($data['numero_ng_id']),
            removeFirstCharDash($data['buwanang_kita']),
            removeFirstCharDash($data['cellphone_number']),
            removeFirstCharDash($data['pinagtratrabahuhang_lugar']),
            $data['bene_uct'],
            $data['bene_4ps'],
            $data['katutubo'],
            ($data['katutubo_name'] != null ? $data['katutubo_name'] : "-"),
            $data['bene_others'],
            convertToDash($data['others_name']),
            Carbon::parse($data['petsa_ng_pagrehistro'])->toDateString(),
            removeFirstCharDash($data['pangalan_ng_punong_barangay']),
            removeFirstCharDash($data['pangalan_ng_lswdo']),
            str_pad($data['sac_number'],8,"0",STR_PAD_LEFT),
            removeFirstCharDash($data['remarks']),
            Carbon::parse($data['created_at'])->toDateString(),
            $data['user']['name'],
        ];
    }
}

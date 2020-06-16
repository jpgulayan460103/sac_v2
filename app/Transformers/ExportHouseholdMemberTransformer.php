<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class ExportHouseholdMemberTransformer extends TransformerAbstract
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
            'M',
            $data['barcode_number'],
            removeFirstCharDash($data['last_name']),
            removeFirstCharDash($data['first_name']),
            removeFirstCharDash($data['middle_name']),
            removeFirstCharDash($data['ext_name']),
            $data['relasyon_sa_punong_pamilya'],
            Carbon::parse($data['kapanganakan'])->format('m/d/Y'),
            $data['kasarian'],
            removeFirstCharDash($data['trabaho']),
            $data['sektor'],
            $data['kondisyon_ng_kalusugan'],
            $data['barangay_psgc'],
            "-",
            "-",
            "-",
            "-",
            0,
            "-",
            ($data['trabaho'] != "-" ? $data['city_name']:"-"),
            "-",
            "-",
            "-",
            "-",
            "-",
            "-",
            Carbon::parse($data['petsa_ng_pagrehistro'])->format('m/d/Y'),
            removeFirstCharDash($data['pangalan_ng_punong_barangay']),
            removeFirstCharDash($data['pangalan_ng_lswdo']),
            str_pad($data['sac_number'],8,"0",STR_PAD_LEFT),
            removeFirstCharDash($data['remarks']),
            Carbon::parse($data['created_at'])->format('m/d/Y'),
            $data['username'],
        ];
    }
}

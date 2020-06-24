<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HouseholdHead extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'kapanganakan',
        'petsa_ng_pagrehistro',
    ];
    protected $fillable = [
        'barangay_id',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'kasarian',
        'tirahan',
        'kalye',
        'uri_ng_id',
        'numero_ng_id',
        'kapanganakan',
        'trabaho',
        'buwanang_kita',
        'cellphone_number',
        'pinagtratrabahuhang_lugar',
        'sektor',
        'kondisyon_ng_kalusugan',
        'bene_uct',
        'bene_4ps',
        'katutubo',
        'katutubo_name',
        'bene_others',
        'others_name',
        'petsa_ng_pagrehistro',
        'pangalan_ng_punong_barangay',
        'pangalan_ng_lswdo',
        'barcode_number',
        'sac_number',
        'remarks',
        'sap_type',
    ];

    public function members()
    {
        return $this->hasMany('App\Models\HouseholdMember');
    }

    public function barangay()
    {
        return $this->belongsTo('App\Models\Barangay');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function setKapanganakanAttribute($value)
    {
        $this->attributes['kapanganakan'] = Carbon::parse($value);
    }
    public function setPetsaNgPagrehistroAttribute($value)
    {
        $this->attributes['petsa_ng_pagrehistro'] = Carbon::parse($value);
    }
}

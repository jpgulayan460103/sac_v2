<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HouseholdHead extends Model
{
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
        'sac_number',
        'remarks',
    ];

    public function members()
    {
        return $this->hasMany('App\Models\HouseholdMember');
    }

    public function barangay()
    {
        return $this->belongsTo('App\Models\Barangay');
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

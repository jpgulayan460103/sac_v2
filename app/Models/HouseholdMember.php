<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HouseholdMember extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'kapanganakan',
    ];
    protected $fillable = [
        'household_head_id',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'relasyon_sa_punong_pamilya',
        'kasarian',
        'kapanganakan',
        'trabaho',
        'pinagtratrabahuhang_lugar',
        'sektor',
        'kondisyon_ng_kalusugan',
    ];

    public function head()
    {
        return $this->belongsTo('App\Models\HouseholdHead');
    }

    public function setKapanganakanAttribute($value)
    {
        $this->attributes['kapanganakan'] = Carbon::parse($value);
    }
}

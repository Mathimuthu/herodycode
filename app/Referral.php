<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = [
        'user_id', 
        'referral_code', 
        'root_parent_code',
        'referral_count',
        'is_evaluated'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(CampaignDescription::class,'campaign_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $table = 'referrals';

    protected $fillable = [
        'referral_code',
        'campaign_id',
        'user_id',
        'referral_status',
        'is_evaluated'
    ];
        public $timestamps = true;

    public function campaign()
    {
        return $this->belongsTo(CampaignDescription::class,'campaign_id');
    }

public function user()
{
    return $this->belongsTo(User::class);
}

}

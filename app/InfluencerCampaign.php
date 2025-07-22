<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfluencerCampaign extends Model
{
    protected $table = 'influencer_campaign';

    protected $fillable = [
        'title',
        'employe_id',
        'description',
        'upload',
        'youtube',
        'instagram',
        'twitter',
        'linkedin',
        'collab_type',
    ];
    
   public function profiles()
{
    return $this->hasMany(InfluencerProfile::class, 'influencer_campaign_id');
}


}

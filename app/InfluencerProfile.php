<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfluencerProfile extends Model
{
    protected $table = 'influencer_profiles';

    protected $fillable = [
        'influencer_campaign_id',
        'manager_id',
        'link',
        'follower',
        'platform',
        'engagement',
        'collaboration_type',
        'city',
        'gender',
        'past_work',
        'content_status',
        'upload_file'
    ];
    
    public function campaign()
    {
        return $this->belongsTo(InfluencerCampaign::class, 'influencer_campaign_id');
    }

}


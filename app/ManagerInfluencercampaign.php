<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagerInfluencercampaign extends Model
{
    protected $table = 'manager_influencercampaign';

    protected $fillable = [
       'influencer_campaign_id',
       'status',
       'updated_by'
    ];

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'updated_by');
    }

}

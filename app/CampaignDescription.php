<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignDescription extends Model
{
    protected $fillable = [
        'task_name',
        'description',
        'sample_screenshot',
        'youtube_link',
        'employer_id',
        'gig_id',
    ];
    public function questions()
    {
        return $this->hasMany('App\CamQuestion', 'campaign_id');
    }
    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

}

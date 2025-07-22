<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignDescription extends Model
{
    protected $fillable = [
        'task_name',
        'description',
        'upload_link',
        'sample_screenshot',
        'youtube_link',
        'employer_id',
        'gig_id',
        'referral_status',
    ];
    public function questions()
    {
        return $this->hasMany('App\CamQuestion', 'campaign_id');
    }

    public function referrals()
{
    return $this->hasMany(Referral::class, 'campaign_id');
}
public function employer()
{
    return $this->belongsTo(User::class, 'employer_id'); // or the correct model if it's not User
}
public function employers()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }






}

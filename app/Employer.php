<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer extends Authenticatable
{
    use Notifiable,SoftDeletes;
    protected $guard = 'employers';
    protected $table = 'employers';
    public function projects()
    {
        return $this->hasMany('App\Project', 'user');
    }
    public function gigs()
    {
        return $this->hasMany('App\Gig', 'user_id');
    }
      public function questions()
    {
        return $this->hasMany('App\CamQuestion', 'employee_id');
    }
    
   public function campaigns()
{
    return $this->hasMany(CampaignDescription::class, 'employer_id', 'id');
}
public function getProfilePhotoUrlAttribute()
{
    return asset('assets/employer/profile_images/' . $this->profile_photo);
}
    
}

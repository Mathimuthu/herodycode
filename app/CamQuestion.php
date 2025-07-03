<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CamQuestion extends Model
{
    protected $fillable = ['text', 'type', 'required','referral_code','employee_id','campaign_id'];

    public function choices()
    {
        return $this->hasMany(Choice::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    
    // Helper method to check if question type has choices
    public function hasChoices()
    {
        return in_array($this->type, ['choice', 'checkbox', 'dropdown']);
    }
    public function employee()
{
    return $this->belongsTo('App\Employee');
}
public function campaign()
{
    return $this->belongsTo('App\CampaignDescription', 'campaign_id');
}
}

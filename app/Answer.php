<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['question_id', 'response', 'file_path','referral_code'];

    public function question()
    {
        return $this->belongsTo(CamQuestion::class);
    }
}

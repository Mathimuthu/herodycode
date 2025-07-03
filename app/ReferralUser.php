<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralUser extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'referral_code'];

}

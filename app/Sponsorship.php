<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{

    protected $fillable = [
        'full_name',
        'college_name',
        'city',
        'contact_number',
        'email',
        'is_club_member',
        'club_name',
        'position',
        'has_upcoming_event',
        'event_name',
        'event_category',
        'expected_attendance',
        'event_date',
        'expected_sponsorship',
    ];
}


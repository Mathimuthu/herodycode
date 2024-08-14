<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'email',
        'phone',
    ];

    public function gigs()
    {
        return $this->hasMany(Gig::class, 'employee_id');
    }

    public function pending(){
        return $this->hasMany(PendingGig::class,'employee_id');
    }

    public function internships(){
        return $this->hasMany(Internship::class,'employee_id');
    }
    public function pendinginternships(){
        return $this->hasMany(PendingInternship::class,'employee_id');
    }
}

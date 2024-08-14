<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $table = 'internship';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'title',
        'status',
        'description',
        'category',
        'start_date',
        'end_date',
        'duration',
        'stipend',
        'benefits',
        'place',
        'count',
        'skills',
        'proofs',
        'employee_id', 
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}

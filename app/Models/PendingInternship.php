<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingInternship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
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
        'employee_id'
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingGig extends Model
{
    use HasFactory;

    protected $table = 'pending_gigs';

    protected $fillable = [
        'name', 
        'brand_name', 
        'about', 
        'amount_per_user', 
        'employee_id', 
        'link_description', 
        'link_locator'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

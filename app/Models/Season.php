<?php

namespace App\Models;

use App\Models\CoOperative\CoUser;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'name',
        'manager_id',
        'Start_Date',
        'End_Date',
        'status',
    ];

    public function manager()
    {
        return $this->belongsTo(CoUser ::class, 'manager_id');
    }
}

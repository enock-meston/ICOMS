<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    //
    protected $fillable = [
        'committee_name',
        'committee_type',
        'start_date',
        'end_date',
        'status'
    ];
}

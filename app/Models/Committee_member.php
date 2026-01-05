<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Committee_member extends Model
{
    //
    protected $fillable = [
        'committee_id',
        'user_id',
        'role_in_committee',
        'start_date',
        'end_date',
        'status'
    ];
}

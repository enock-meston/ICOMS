<?php

namespace App\Models;

use App\Models\CoOperative\CoUser;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    //
    protected $fillable = [
        'meeting_type',
        'date',
        'location',
        'called_by',
        'minutes_file',
    ];

    public function caller()
    {
        return $this->belongsTo(CoUser::class, 'called_by');
    }
}

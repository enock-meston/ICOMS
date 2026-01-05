<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    //
    protected $fillable = [
        'meeting_id',
        'title',
        'description',
        'responsible_user_id',
        'due_date',
        'status',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}

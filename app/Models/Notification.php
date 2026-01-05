<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $fillable = [
        'user_id','message','channel',
        'related_entity','related_id',
        'sent_date','read_status'
    ];
}

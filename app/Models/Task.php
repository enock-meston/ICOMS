<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = [
        'title','description','assigned_to','created_by',
        'related_decision_id','related_plan_id',
        'priority','start_date','due_date','status'
    ];
}

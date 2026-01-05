<?php

namespace App\Models;

use App\Models\CoOperative\CoUser;
use Illuminate\Database\Eloquent\Model;

class FieldActivity extends Model
{
    //fillable
    protected $fillable = [
        'plan_id',
        'activity_type',
        'planned_date',
        'actual_date',
        'officer_user_id',
        'status',
    ];

    public function plan()
    {
        return $this->belongsTo(ProductionPlan::class, 'plan_id');
    }

    public function officer()
    {
        return $this->belongsTo(CoUser::class, 'officer_user_id');
    }
}

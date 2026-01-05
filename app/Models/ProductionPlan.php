<?php

namespace App\Models;

use App\Models\CoOperative\CoUser;
use Illuminate\Database\Eloquent\Model;

class ProductionPlan extends Model
{
    protected $fillable = [
        'group_id',
        'season_id',
        'planned_area_ha',
        'planned_yield_tons',
        'planned_inputs_cost',
        'status',
        'created_by',
        'approved_by_manager',
        'approval_date',
    ];


    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function creator()
    {
        return $this->belongsTo(CoUser::class, 'created_by');
    }

    public function approvedByManager()
    {
        return $this->belongsTo(CoUser::class, 'approved_by_manager');
    }
}

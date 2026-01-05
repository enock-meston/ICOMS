<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procurement_plan extends Model
{
    //
    protected $fillable = [
        'fiscal_year',
        'prepared_by',
        'approved_by_manager',
        'approved_by_board',
        'approval_date',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(ProcurementItem::class, 'plan_id');
    }

    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }
}

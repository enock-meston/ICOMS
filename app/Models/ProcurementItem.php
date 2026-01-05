<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementItem extends Model
{
    protected $fillable = [
        'plan_id',
        'department_id',
        'description',
        'quantity',
        'unit_of_measure',
        'estimated_unit_cost',
        'estimated_total_cost',
        'procurement_method',
        'priority',
        'planned_tender_date',
        'status'
    ];

    public function plan()
    {
        return $this->belongsTo(Procurement_plan ::class, 'plan_id');
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class, 'item_id');
    }
}


?>

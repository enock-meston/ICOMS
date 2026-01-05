<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //
    protected $fillable = [
        'tender_id',
        'supplier_id',
        'contract_no',
        'description',
        'contract_amount',
        'start_date',
        'end_date',
        'signed_by_manager',
        'signed_at',
        'status'
    ];

    protected $dates = ['signed_at', 'start_date', 'end_date'];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Deliverie ::class);
    }
}

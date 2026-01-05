<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier_payments extends Model
{
    //
     protected $fillable = [
        'contract_id',
        'delivery_id',
        'supplier_id',
        'amount',
        'payment_date',
        'channel',
        'approved_by_manager',
        'status'
    ];

    protected $dates = ['payment_date'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Deliverie ::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

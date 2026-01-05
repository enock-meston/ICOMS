<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compost_usage extends Model
{
    //
     protected $fillable = [
        'compost_id',
        'member_id',
        'qty_used_kg',
        'price_per_kg',
        'total_amount',
        'payment_type',
        'status'
    ];

    public function compost()
    {
        return $this->belongsTo(Compost_group_production ::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}

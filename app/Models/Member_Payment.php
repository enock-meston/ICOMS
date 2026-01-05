<?php

namespace App\Models;

use App\Models\CoOperative\CoUser;
use Illuminate\Database\Eloquent\Model;

class Member_Payment extends Model
{
    //
    protected $fillable = [
    'member_id',
    'delivery_id',
    'amount',
    'payment_Date',
    'payment',
    'manager_id',
    'status',
];

 public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function manager()
    {
        return $this->belongsTo(CoUser::class, 'manager_id');
    }

}

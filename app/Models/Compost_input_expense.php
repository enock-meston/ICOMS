<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compost_input_expense extends Model
{
    //
    protected $fillable = [
        'compost_id',
        'expense_type',
        'amount',
        'provided_by',
        'date'
    ];
    public function compost()
    {
        return $this->belongsTo(Compost_group_production ::class, 'compost_id');
    }
}

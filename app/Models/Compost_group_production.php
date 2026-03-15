<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compost_group_production extends Model
{
    //
     protected $fillable = [
        'group_id',
        'season_id',
        'material_type',
        'production_start',
        'production_end',
        'qty_produced_kg',
        'estimated_value',
        'status'
    ];

     public function group()
    {
        return $this->belongsTo(Group ::class, 'group_id');
    }

     public function season()
    {
        return $this->belongsTo(Season ::class, 'season_id');
    }
}

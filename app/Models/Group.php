<?php

namespace App\Models;

use App\Models\CoOperative\CoUser;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $fillable = [
        'name',
        'manager_id',
        'Sector',
        'cell',
        'village',
        'status',
    ];

    public function manager()
    {
        return $this->belongsTo(CoUser ::class, 'manager_id');
    }

}

<?php

namespace App\Models\department;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //fillable fields
    protected $fillable = [
        'name',
        'description',
    ];
}

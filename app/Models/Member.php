<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $fillable = [
        'member_code',
        'names',
        'phone',
        'gender',
        'group_id',
        'national_ID',
        'joinDate',
        'Shares',
        'status',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}

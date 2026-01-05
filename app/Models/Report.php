<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
     protected $fillable = [
        'report_type','period_from','period_to',
        'file_path','prepared_by',
        'approved_by_manager','approval_date'
    ];
}

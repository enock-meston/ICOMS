<?php

namespace App\Models;

use App\Models\CoOperative\CoUser;
use Illuminate\Database\Eloquent\Model;

class Input_Allocation extends Model
{
    //
     protected $fillable = [
        'member_id',
        'season_id',
        'Type_',
        'Quantity',
        'Unit_Cost',
        'Total_Value',
        'Issue_Date',
        'Approved_By_Manager',
        'Approval_Date',
        'Status',
     ];

     public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function manager()
    {
        return $this->belongsTo(CoUser::class, 'manager_id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}

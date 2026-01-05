<?php

namespace App\Models;

use App\Models\CoOperative\CoUser;
use Illuminate\Database\Eloquent\Model;

class Rice_Delivery extends Model
{
    //
     protected $fillable = [
        'member_id',
        'season_id',
        'Delivery_Date',
        'Quantity_KG',
        'Quality_Grade',
        'Unit_Price',
        'Gross_Value',
        'Loan_Deduction',
        'Other_Deductions',
        'Net_Payable',
        'Created_By',
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

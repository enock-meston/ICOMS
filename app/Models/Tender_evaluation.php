<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender_evaluation extends Model
{
    //
     protected $fillable = [
        'tender_id',
        'committee_id',
        'evaluation_date',
        'report_file',
        'recommended_supplier_id',
        'recommended_amount',
        'approved_by_manager',
        'approved_by_board',
        'status'
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}

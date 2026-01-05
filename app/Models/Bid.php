<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = [
        'tender_id',
        'supplier_id',
        'bid_amount',
        'technical_score',
        'financial_score',
        'overall_score',
        'evaluation_result',
        'recommendation',
        'submitted_at'
    ];

    protected $dates = ['submitted_at'];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}


?>

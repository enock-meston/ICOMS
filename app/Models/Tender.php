<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $fillable = [
        'item_id',
        'tender_ref_no',
        'title',
        'procurement_method',
        'publish_date',
        'closing_date',
        'status',
        'created_by',
        'approved_by_manager',
        'notice_file'
    ];

    public function item()
    {
        return $this->belongsTo(ProcurementItem::class, 'item_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function evaluation()
    {
        return $this->hasOne(Tender_evaluation ::class);
    }
}

?>

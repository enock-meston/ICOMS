<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliverie extends Model
{
    //
     protected $fillable = [
        'contract_id',
        'delivery_date',
        'delivery_description',
        'quantity_received',
        'value_received',
        'receiving_committee_id',
        'grn_no',
        'conformity_status',
        'remarks'
    ];

    protected $dates = ['delivery_date'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function receivingCommittee()
    {
        return $this->belongsTo(Committee::class, 'receiving_committee_id');
    }
}

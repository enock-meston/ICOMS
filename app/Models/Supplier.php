<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_name',
        'tin',
        'address',
        'phone',
        'email',
        'bank_name',
        'bank_account'
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}


?>

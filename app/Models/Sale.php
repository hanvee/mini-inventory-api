<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'date',
        'customer_id',
        'subtotal'
    ];

    protected $primaryKey = 'invoice_id';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

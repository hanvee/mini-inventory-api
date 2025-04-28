<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_id',
        'date',
        'customer_id',
        'subtotal'
    ];

    protected $primaryKey = 'invoice_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $with = ['saleItems'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'invoice_id', 'invoice_id');
    }
}

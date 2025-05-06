<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_code',
        'name',
        'category',
        'price',
        'color'
    ];

    protected $primaryKey = 'product_code';
    
    protected $keyType = 'string';

    public $incrementing = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetails extends Model
{
    use HasFactory;
    protected $appends = ['total'];
    public function order()
    {
        return $this->belongsTo(Order::class,'orderNumber');
    }

    public function getTotalAttribute()
    {
        return $this->priceEach*$this->quantityOrdered;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $tableName="orders";
    protected $fillable = [
        'name',
        'address',
        'total_price',
        'status',
        'approved_by'
    ];
    use HasFactory;
    function carts()
    {
        return $this->hasMany(Cart::class);
    }
}

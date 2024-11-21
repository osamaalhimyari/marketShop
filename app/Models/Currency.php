<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Currency extends Model
{
 
    use HasFactory;


    protected $fillable = ['name','code','sign'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function configs()
    {
        return $this->hasMany(Config::class);
    }


   
}

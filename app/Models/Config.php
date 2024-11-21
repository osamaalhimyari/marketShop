<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Config extends Model
{
 
    use HasFactory;


    protected $fillable = ['name','logoPath','description','currency_id'];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


   
}

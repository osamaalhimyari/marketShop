<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use function PHPSTORM_META\map;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'headLine',
        'description',
        'published',
        'price',
        'views',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


   

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function  scopeFiltered(Builder $quary)  {
        $quary
        
        ->when(request('categories'), function (Builder $q)  {
            $q->whereIn('category_id',request('categories'));
        })
        ->when(request('prices'), function(Builder $q)  {
            $q->whereBetween('price',[
                request('prices.from',0),
                request('prices.to', 100000),
            ]);
        });
        
    }
}

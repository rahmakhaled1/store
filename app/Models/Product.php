<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'category_id',
        'description',
        'image',
        'price',
        'slug',
        'store_id'
    ];
    protected static function booted()
    {
        static::addGlobalScope('store',new StoreScope());
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function tags()
    {
        return $this->belongsToMany(
          Tag::class,
          'product_tag',           //pivot table
          'product_id' ,   //fk pivot table current model
            'tag_id',      //fk pivot table related model
            'id',              //pk current model
            'id'               //pk related model
        );
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status','=' ,'active');
    }
    public function getImageUrlAttribute()
    {
        if(!$this->image){
        return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image,['http://','https://'])){
            return $this->image;
        }
        return asset('storage/',$this->image);
    }
    public function getSalePercentAttribute()
    {
        if (!$this->compare_price){
            return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price), 1);
    }

}

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

    protected $appends = [
      'image_url'
    ];

    protected $hidden =['created_at', 'updated_at', 'deleted_at', 'image'];
    protected static function booted()
    {
        static::addGlobalScope('store',new StoreScope());

        static::creating(function (Product $product){
            $product->slug = Str::slug($product->name);
        });
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

    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'],function ($query, $status){
            return $query->where('status', $status) ;
        });

        $builder->when($options['store_id'],function ($builder, $value){
           $builder->where('store_id', $value) ;
        });

        $builder->when($options['category_id'],function ($builder, $value){
            $builder->where('category_id', $value) ;
        });

        $builder->when($options['tag_id'],function ($builder, $value){
            $builder->whereExists(function ($query) use ($value) {
               $query->select(1)
                   ->from('product_tag')
                   ->whereRaw('product_id = products.id')
                   ->where('tag_id', $value);
            });
        });



    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug'
    ];
    public function products()
    {
        return $this->hasMany(Product::class,'category_id','id')  ;
    }
    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id','id')
            ->withDefault(['name'=>'null']);
    }
    public function children()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status','=','active');
    }

    public function scopeFilter(Builder $builder, $filter)
    {
        $builder->when($filter['name'] ?? false ,function ($builder,$value){
            $builder->where('categories.name','LIKE',"%{$value}%");
        });

        $builder->when($filter['status'] ?? false ,function ($builder,$value){
            $builder->where('categories.status','=',$value);
        });

        //if ($filter['name'] ?? false){
        ////$builder->where('name','LIKE',"%{$filter['name']}%");
        //}
        //if ($filter['status'] ?? false){
        //$builder->where('status','=',$filter['status']);
        //}
    }
    public static function rules($id=0)
    {   //unique:categories,name,$id
        return[
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
                'filter:php,laravel,css,html.admin,js'
            ],
            'parent_id'=>['nullable','int','exists:categories,id'],
            'image'=>'image|max:1048576|dimensions:min_width=100,min_height=100',
            'status'=>'required|in:active,archive',
        ];
    }
}

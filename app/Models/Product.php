<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,SoftDeletes,Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $table = 'products';
    protected $guarded = [];
    protected $appends = ['quantity_check','sale_check','price_check'];

    public function getQuantityCheckAttribute()
    {
        return $this->variations()->where('quantity','>',0)->first() ?? 0;
    }

    public function getSaleCheckAttribute()
    {
        return $this->variations()->where('quantity','>',0)->where('sale_price','!=',null)->where('date_on_sale_from','<',Carbon::now())->where('date_on_sale_to','>',Carbon::now())->orderby('sale_price')->first() ?? false;
    }

    public function getPriceCheckAttribute()
    {
        return $this->variations()->orderby('price')->first();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'product_tag');
    }

    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال': 'غیرفعال' ;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function rates()
    {
        return $this->hasMany(ProductRate::class);
    }

    public function scopeFilter($query)
    {
        if(request()->has('attribute'))
        {
             foreach (request()->attribute as $attribute) {
                $query->whereHas('attributes',function($query) use ($attribute){
                    foreach(explode('-',$attribute) as $index => $item)
                    {
                        if ($index==0) {
                            $query->where('value',$item);
                        }else{
                            $query->orWhere('value',$item);
                        }
                    }
                });
            }
        }


        if(request()->has('variation')){
            $query->whereHas('variations',function($query){
                foreach(explode('-',request()->variation) as $index => $variation){
                    if($index == 0){
                        $query->where('value',$variation);
                    }else{
                        $query->orWhere('value',$variation);
                    }
                }
            });
        }

        return $query;
    }
}

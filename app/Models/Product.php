<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Comment;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
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
        return $this->variations()->where('quantity', '>', 0)->first() ?? 0;
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

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('approved',1);
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

        if (request()->has('sortBy')) {
            $sortBy=request()->sortBy;

            switch($sortBy)
            {
                case 'max':
                    $query->orderByDesc(
                        ProductVariation::select('price')->whereColumn('product_variations.product_id','products.id')->orderBy('sale_price','desc')->take(1)
                    );
                    break;
                case 'min':
                    $query->orderBy(ProductVariation::select('price')->whereColumn('product_variations.product_id','products.id')->orderBy('sale_price','asc')->take(1));
                    break;
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                default:
                $query;
                break;
            }



        }

        return $query;
    }

    public function scopeSearch($query)
    {
        $keyword=request()->search;

        if (request()->has('search') && trim($keyword)!='') {
            $query->where('name','LIKE','%'.trim($keyword).'%');
        }

        return $query;
    }

    public function checkUserWishlist($userId)
    {
        return $this->hasMany(Wishlist::class)->where('user_id',$userId)->exists();
    }
}

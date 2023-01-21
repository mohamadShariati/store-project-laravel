<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
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
}

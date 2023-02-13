<?php

namespace App\Models;

use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=[];

    public function categories()
    {
        return $this->belongsToMany(Category::class,'attribute_category');
    }

    public function values()
    {
        return $this->hasMany(ProductAttribute::class)->select('attribute_id','value')->distinct();
    }

    public function variationValues()
    {
        return $this->hasMany(ProductVariation::class)->select('attribute_id','value')->distinct();
    }
}

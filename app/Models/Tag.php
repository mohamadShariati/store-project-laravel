<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='tags';

    protected $guarded=[];


    public function products()
    {
        return $this->belongsToMany(Product::class,'product_tag');
    }
}

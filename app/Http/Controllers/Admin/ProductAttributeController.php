<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;

class ProductAttributeController extends Controller
{
    public function store($attributes,$product)
    {
        foreach($attributes as $key =>  $attribute)
        {
            ProductAttribute::create([
                'attribute_id'=>$key,
                'product_id'=>$product->id,
                'value'=>$attribute
            ]);
        }
    }

    public function update($attributeIds)
    {
        foreach ($attributeIds as $key => $value) {
            $productAttribute=ProductAttribute::findOrFail($key);
            $productAttribute->update([
                'value'=>$value
            ]);
        }
    }

    public function change($attributes,$product)
    {
        ProductAttribute::where('product_id',$product->id)->delete();
        foreach($attributes as $key =>  $attribute)
        {
            ProductAttribute::create([
                'attribute_id'=>$key,
                'product_id'=>$product->id,
                'value'=>$attribute
            ]);
        }
    }


}



<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Facades\Verta as FacadesVerta;
use Hekmatinasser\Verta\Laravel\Verta;
use Hekmatinasser\Verta\Verta as VertaVerta;

class ProductVariationController extends Controller
{
    public function store($variation, $attributeId, $product)
    {


        $counter = count($variation['value']);
        // $category = Category::find($category_id);

        for ($i = 0; $i < $counter; $i++) {
            ProductVariation::create([
                'attribute_id' => $attributeId,
                // 'attribute_id'=>1,
                'product_id' => $product->id,
                'value' => $variation['value'][$i],
                'price' => $variation['price'][$i],
                'quantity' => $variation['quantity'][$i],
                'sku' => $variation['sku'][$i]
            ]);
        }
    }

    public function update($variationIds)
    {

        foreach ($variationIds as $key => $value) {

            $productVariation = ProductVariation::findOrFail($key);


            $productVariation->update([
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'sku' => $value['sku'],
                'sale_price' => $value['sale_price'],
                'date_on_sale_from' => convertShamsiToGregorianDate($value['date_on_sale_from']),
                'date_on_sale_to' => convertShamsiToGregorianDate($value['date_on_sale_to']),
            ]);
        }
    }

    public function change($variation, $attributeId, $product){


        $counter = count($variation['value']);

        ProductVariation::where('product_id',$product->id)->delete();
        for ($i = 0; $i < $counter; $i++) {
            ProductVariation::create([
                'attribute_id' => $attributeId,
                'product_id' => $product->id,
                'value' => $variation['value'][$i],
                'price' => $variation['price'][$i],
                'quantity' => $variation['quantity'][$i],
                'sku' => $variation['sku'][$i]
            ]);
        }
    }
}

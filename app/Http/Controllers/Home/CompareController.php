<?php

namespace App\Http\Controllers\Home;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompareController extends Controller
{

    public function index()
    {
        if (session()->has('compareProduct')) {

            $products=Product::findOrFail(session()->get('compareProduct'));
            return view('home.compare.index',compact('products'));
        }
        alert()->warning('توجه کنید', 'ابتدا باید محصول به لیست مقایسه اضافه کنید');
        return redirect()->back();
    }

    public function add(Product $product)
    {

        if (session()->has('compareProduct')) {
            if (in_array($product->id, session()->get('compareProduct'))) {
                alert()->warning('محصول به لیست مقایسه اضافه شذه است');
                return redirect()->back();
            }
            session()->push('compareProduct', $product->id);
        } else {
            session()->put('compareProduct', [$product->id]);
        }

        alert()->success('محصول با موفقیت به لیست مقایسه اضافه شد ');
        return redirect()->back();
    }

    public function remove($productId)
    {
        if(session()->has('compareProduct'))
        {
            foreach(session()->get('compareProduct') as $key => $item)
            {
                if($item == $productId)
                {
                    session()->pull('compareProduct.'.$key);
                }
            }

            if(session()->get('compareProduct') == [])
            {
                session()->forget('compareProduct');
                return redirect()->route('home.index');
            }


            return redirect()->route('home.compare.index');
        }
        alert()->warning('توجه کنید', 'ابتدا باید محصول به لیست مقایسه اضافه کنید');
        return redirect()->back();
    }
}

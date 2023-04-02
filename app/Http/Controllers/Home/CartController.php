<?php

namespace App\Http\Controllers\Home;

use Cart;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
use Carbon\Carbon;
use Darryldecode\Cart\Cart as CartCart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        if (Cart::isEmpty()) {
            alert()->warning('دقت کنید', 'ابتدا باید محصول به سبد خرید اضافه کنید');
            return redirect()->route('home.index');
        }
        return view('home.cart.index');
    }

    public function add(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qtybutton' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);
        // dd($product);
        $productVariation = ProductVariation::findOrFail(json_decode($request->variation)->id);
        // dd($productVariation);

        if ($request->qtybutton > $productVariation->quantity) {
            alert()->error('دقت کنید', 'تعداد محصول صحیح نمیباشد');
            return redirect()->back();
        }

        $rowId = $product->id . '-' . $productVariation->id;

        if (Cart::get($rowId) == null) {
            Cart::add(array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $productVariation->is_sale ? $productVariation->sale_price : $productVariation->price,
                'quantity' => $request->qtybutton,
                'attributes' => $productVariation->toArray(),
                'associatedModel' => $product
            ));
        } else {
            alert()->warning('دقت کنید', 'محصول از قبل انتخاب شده است');
            return redirect()->back();
        }

        alert()->success('با تشکر', 'محصول به سبد خرید اضافه شد');
        return redirect()->back();
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        alert()->success('با تشکر', 'محصول از سبد خرید شما حذف شد');
        return redirect()->back();
    }

    public function clear()
    {
        Cart::clear();
        alert()->success('با تشکر', 'سبد خرید با موفقیت خالی شد');
        return redirect()->route('home.index');
    }

    public function update(Request $request)
    {

        $request->validate([
            'qtybutton' => 'required',
        ]);

        // dd($request->qtybutton);
        foreach ($request->qtybutton as $rowId => $quantity) {

            $item= Cart::get($rowId);

            if($quantity > $item->attributes->quantity )
            {
                alert()->error('دقت کنید','تعداد وارد شده صحیح نمیباشد');
                return redirect()->back();
            }

            Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                ),
        ));
     }
     return redirect()->back();
    }

    public function checkCoupon(Request $request)
    {

        $request->validate([
            'code'=>'required'
        ]);

        if(!auth()->check())
        {
            alert()->warning('دقت کنید','ابتدا باید در سایت لاگین کنید');
            return redirect()->back();
        }

        $result=checkCoupon($request->code);

        if(array_key_exists('error',$result))
        {
            alert()->warning('دقت کنید',$result['error']);
            return redirect()->back();
        }

        if(array_key_exists('success',$result))
        {
            alert()->success('کوپن تخفبف برای شما فعال شد');
            return redirect()->back();
        }


    }


}

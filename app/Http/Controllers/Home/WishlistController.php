<?php

namespace App\Http\Controllers\Home;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function add(Product $product)
    {
        if(auth()->check())
        {
            if($product->checkUserWishlist(auth()->user()->id))
            {
                alert()->warning('محصول در لیست علاقه مندی شما موجود است');
                return redirect()->back();
            }else{

                Wishlist::create([
                    'user_id'=>auth()->user()->id,
                    'product_id'=>$product->id,
                ]);

                alert()->success('محصول به لیست علاقه مندی ها اضافه شد');
                return redirect()->back();
            }

        }

        alert()->warning('ابتدا باید وارد سایت شوید');
        return redirect()->route('login');
    }

    public function remove(Product $product)
    {
        if(auth()->check())
        {
            $wishlist = Wishlist::where('product_id',$product->id)->where('user_id',auth()->user()->id)->firstOrFail();
            if ($wishlist) {
                Wishlist::where('product_id',$product->id)->where('user_id',auth()->user()->id)->delete();
            }
            alert()->success('محصول از لیست علاقه مندی ها حذف شد');
                return redirect()->back();
        }else
        {
            alert()->warning('ابتدا باید وارد سایت شوید');
            return redirect()->route('login');
        }

    }

    public function userProfileIndex()
    {
        if(auth()->check())
        {
            $wishlist=Wishlist::where('user_id',auth()->user()->id)->get();
        }
        return view('home.users_profile.wishlist',compact('wishlist'));
    }
}

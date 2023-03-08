<?php

namespace App\Http\Controllers\Home;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class ProductController extends Controller
{
    public function show(Product $product)
    {

        return view('home.products.show',compact('product'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductVariationController;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::latest()->paginate(10);
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $brands = Brand::all();
        $categories = Category::where('parent_id', '!=', 0)->get();
        return view('admin.products.create', compact('brands', 'tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'brand_id' => 'required|numeric|exists:brands,id',
            'is_active' => 'required|numeric|in:0,1',
            'tag_ids' => 'required',
            'description' => 'required|string|max:200',
            'primary_image' => 'required|mimes:jpg,jpeg,png,svg',
            'images' => 'required',
            'images.*' => 'required|mimes:jpg,jpeg,png,svg',
            'category_id' => 'required|exists:categories,id',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'required',
            'variation_values' => 'required',
            'variation_values.*.*' => 'required',
            'variation_values.price.*' => 'integer',
            'variation_values.quantity.*' => 'integer',
            'delivery_amount' => 'required|integer',
            'delivery_amount_per_product' => 'nullable|integer',
        ]);

        try {
            // dd($request->all());
            DB::beginTransaction();
            $ProductImageController = new ProductImageController();
            $fileNameImages = $ProductImageController->upload($request->primary_image, $request->images);
            // dd($fileNameImages['fileNamePrimaryImage']);

            $product = Product::create([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'is_active' => $request->is_active,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product,
                'primary_image' => $fileNameImages['fileNamePrimaryImage']
            ]);

            foreach ($fileNameImages['fileNameImages'] as $fileNameImage) {
                ProductImage::create([
                    'image' => $fileNameImage,
                    'product_id' => $product->id,
                ]);
            }


            $ProductAttributeController = new ProductAttributeController;
            $ProductAttributeController->store($request->attribute_ids, $product);




            $category = Category::find($request->category_id);

            $ProductVariationController =new ProductVariationController;
            $ProductVariationController->store($request->variation_values,$category->attributes()->wherePivot('is_variation', 1)->first()->id,$product);

            $product->tags()->attach($request->tag_ids);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error($ex->getMessage().' مشکل در ایجاد محصول ')->persistent('حله');
            return redirect()->back();
        }

        alert()->success('با تشکر', 'محصول  با موفقیت ایجاد شد');

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $productAttributes=$product->attributes()->with('attribute')->get();
        $productVariations=$product->variations;
        // $images=ProductImage::where('product_id',$product->id);
        $images=$product->images;
        return view('admin.products.show',compact('product','productAttributes','images','productVariations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $tags = Tag::all();
        $brands=Brand::all();
        $productAttributes=$product->attributes()->with('attribute')->get();
        $productVariations=$product->variations;
       return view('admin.products.edit',compact('product','brands','tags','productAttributes','productVariations'));
    }


    public function editCategory(Product $product,Request $request)
    {

        $categories = Category::where('parent_id', '!=', 0)->get();

        return view('admin.products.edit-category',compact('product','categories'));
    }


    public function updateCategory(Request $request,Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'required',
            'variation_values' => 'required',
            'variation_values.*.*' => 'required',
            'variation_values.price.*' => 'integer',
            'variation_values.quantity.*' => 'integer',
        ]);

        try {
            $product->update([
                'category_id' => $request->category_id,
            ]);

            $ProductAttributeController = new ProductAttributeController;
            $ProductAttributeController->change($request->attribute_ids, $product);

            $category = Category::find($request->category_id);

            $ProductVariationController =new ProductVariationController;
            $ProductVariationController->change($request->variation_values,$category->attributes()->wherePivot('is_variation', 1)->first()->id,$product);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error($ex->getMessage().' مشکل در ویرایش دسته بندی محصول ')->persistent('حله');
            return redirect()->back();
        }

        alert()->success('با تشکر', 'دسته بندی محصول  با موفقیت ویرایش شد');

        return redirect()->route('admin.products.index');
    }

    /**
     * Update the specified resource in storage.]
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'is_active' => 'required',
            'tag_ids' => 'required',
            'tag_ids.*' => 'integer|exists:tags,id',
            'description' => 'required',
            'attribute_values' => 'required',
            'variation_values' => 'required',
            'variation_values.*.price' => 'required|integer',
            'variation_values.*.quantity' => 'required|integer',
            'variation_values.*.sale_price' => 'nullable|integer',
            'variation_values.*.date_on_sale_from' => 'nullable|date',
            'variation_values.*.date_on_sale_to' => 'nullable|date',
            'delivery_amount' => 'required|integer',
            'delivery_amount_per_product' => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();
            $product ->update([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'is_active' => $request->is_active,
                'description' => $request->description,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product,
            ]);

            $ProductAttributeController = new ProductAttributeController;
            $ProductAttributeController->update($request->attribute_values);

            $ProductVariationController =new ProductVariationController;
            $ProductVariationController->update($request->variation_values);

            $product->tags()->sync($request->tag_ids);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error($ex->getMessage().' مشکل در ویرایش محصول ')->persistent('حله');
            return redirect()->back();
        }

        alert()->success('با تشکر', 'محصول  با موفقیت ویرایش شد');

        return redirect()->route('admin.products.index');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductImageController extends Controller
{

    public function upload($primaryImage, $images)
    {
        $fileNamePrimaryImage = generateFileName($primaryImage->getClientOriginalName());
        $primaryImage->move(public_path('/upload/files/products/images'), $fileNamePrimaryImage);

        $fileNameImages = [];
        foreach ($images as $image) {
            $fileNmaeImage = generateFileName($image->getClientOriginalName());
            $image->move(public_path('/upload/files/products/images'), $fileNmaeImage);
            array_push($fileNameImages, $fileNmaeImage);
        }


        return [
            'fileNamePrimaryImage' => $fileNamePrimaryImage,
            'fileNameImages' => $fileNameImages
        ];
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit-images', compact('product'));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        $image = ProductImage::findOrFail($request->image_id);
        $image->delete();

        alert()->success('تصویر محصول مورد نظر حذف شد', 'با تشکر');
        return redirect()->back();
    }

    public function setPrimary(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        $productImage = ProductImage::findOrFail($request->image_id);
        // dd($product,$image);

        ProductImage::create([
            'image' => $product->primary_image,
            'product_id' => $product->id
        ]);

        $product->update([
            'primary_image' => $productImage->image
        ]);

        $productImage->delete();

        alert()->success('ویرایش تصویر اصلی محصول با موفقیت انجام شد', 'با تشکر');
        return redirect()->back();
    }

    public function add(Request $request, Product $product)
    {


        $request->validate([
            'primary_image' => 'nullable|mimes:jpg,jpeg,png,svg',
            'images.*' => 'nullable|mimes:jpg,jpeg,png,svg',
        ]);
        try {
            DB::beginTransaction();

            if ($request->primary_image == null && $request->images == null) {
                return redirect()->back()->withErrors(['ERR' => 'تصویر یا تصاویر باید انتخاب شوند']);
            }

            if ($request->has('primary_image')) {
                $fileNamePrimaryImage = generateFileName($request->primary_image->getClientOriginalName());
                $request->primary_image->move(public_path('/upload/files/products/images'), $fileNamePrimaryImage);

                $product->update([
                    'primary_image' => $fileNamePrimaryImage
                ]);
            }

            if ($request->has('images')) {

                foreach ($request->images as $image) {
                    $fileNmaeImage = generateFileName($image->getClientOriginalName());
                    $image->move(public_path('/upload/files/products/images'), $fileNmaeImage);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileNmaeImage
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error($ex->getMessage() . ' مشکل در ویرایش عکس  ')->persistent('حله');
            return redirect()->back();
        }

        alert()->success('تصاویر با موفقیت اضافه شد', 'با تشکر');
        return redirect()->back();
    }
}

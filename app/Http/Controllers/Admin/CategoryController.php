<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $categories = Category::latest()->paginate();
        $attributes = Attribute::all();
        return view('admin.categories.index', compact('attributes', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)->get();
        $attributes = Attribute::all();
        return view('admin.categories.create', compact('categories', 'attributes'));
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
            'name' => 'required|string|max:15',
            'slug' => 'required|string|max:15|unique:categories,slug',
            'attribute_ids' => 'required|exists:attributes,id',
            'parent_id' => 'nullable|numeric',
            'attribute_is_filter_ids' => 'required',
            'description' => 'string|max:150',
            'variation_id' => 'required',
            'icon' => 'nullable|string',
            'is_active' => 'numeric|required'
        ]);

        try {
            DB::beginTransaction();
            $category = Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'parent_id' => $request->parent_id,
                'icon' => $request->icon,
                'is_active' => $request->is_active
            ]);

            foreach($request->attribute_ids as $attributeId)
              {
                  $attribute=Attribute::findOrFail($attributeId);
                  $attribute->categories()->attach($category->id,
              [
                  'is_filter'=>in_array($attributeId,$request->attribute_is_filter_ids) ? 1 : 0,
                  'is_variation'=>$request->variation_id == $attributeId ? 1 : 0
              ]);
              }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error($ex->getMessage().' مشکل در ایجاد دسته بندی')->persistent('حله');
            return redirect()->back();
        }




        alert()->success('با تشکر', 'دسته بندی با موفقیت ایجاد شد');

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::where('parent_id', 0)->get();
        $attributes = Attribute::all();
        return view('admin.categories.edit', compact('category', 'parentCategories','attributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id,
            'parent_id' => 'required',
            'attribute_ids' => 'required',
            'attribute_is_filter_ids' => 'required',
            'variation_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'icon' => $request->icon,
                'description' => $request->description,
            ]);

            $category->attributes()->detach();

            foreach ($request->attribute_ids as $attributeId) {
                $attribute = Attribute::findOrFail($attributeId);
                $attribute->categories()->attach($category->id, [
                    'is_filter' => in_array($attributeId, $request->attribute_is_filter_ids) ? 1 : 0,
                    'is_variation' => $request->variation_id == $attributeId ? 1 : 0
                ]);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ویرایش دسته بندی', $ex->getMessage())->persistent('حله');
            return redirect()->back();
        }

        alert()->success('دسته بندی مورد نظر ویرایش شد', 'باتشکر');
        return redirect()->route('admin.categories.index');
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

    public function getCategoryAttributes(Category $category)
    {
        $attributes = $category->attributes()->wherePivot('is_variation' ,0)->get();
        $variation = $category->attributes()->wherePivot('is_variation' ,1)->first();
        return ['attrubtes' => $attributes , 'variation' => $variation];
    }
}

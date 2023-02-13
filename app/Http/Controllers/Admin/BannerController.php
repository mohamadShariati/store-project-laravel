<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Product;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners=Banner::latest()->paginate(20);
        return view('admin.banners.index',compact('banners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
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
            'title'=>'required|string',
            'priority'=>'required|integer',
            'type'=>'required|string',
            'button_text'=>'required|string',
            'button_link'=>'required',
            'button_icon'=>'required',
            'is_active'=>'required|between:0,1',
            'text'=>'required|string',
            'image' => 'required|mimes:jpg,jpeg,png,svg',
        ]);

        try {
            DB::beginTransaction();
            $fileNameImage = generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path('/upload/files/banners/images/'), $fileNameImage);

            $banner=Banner::create([
                'title'=>$request->title,
                'priority'=>$request->priority,
                'type'=>$request->type,
                'button_text'=>$request->button_text,
                'button_link'=>$request->button_link,
                'button_icon'=>$request->button_icon,
                'is_active'=>$request->is_active,
                'text'=>$request->text,
                'image'=>$fileNameImage
            ]);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error($ex->getMessage().' مشکل در ایجاد بنر ')->persistent('حله');
            return redirect()->back();
        }

        alert()->success('با تشکر', 'بنر  با موفقیت ایجاد شد');

        return redirect()->route('admin.banners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title'=>'required|string',
            'priority'=>'required',
            'type'=>'required|string',
            'button_text'=>'required|string',
            'button_link'=>'required',
            'button_icon'=>'required',
            'is_active'=>'required|between:0,1',
            'text'=>'required|string',
            'image' => 'mimes:jpg,jpeg,png,svg',
        ]);


        $banner->update([
            'title'=>$request->title,
                'priority'=>$request->priority,
                'type'=>$request->type,
                'button_text'=>$request->button_text,
                'button_link'=>$request->button_link,
                'button_icon'=>$request->button_icon,
                'is_active'=>$request->is_active,
                'text'=>$request->text
        ]);

        if($request->has('image'))
        {
            $fileNameImage = generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path('/upload/files/banners/images'), $fileNameImage);

            $banner->update([
                'image'=>$fileNameImage
            ]);
        }

        alert()->success('با تشکر','بنر با موفقیت ویرایش شد');
        return redirect()->route('admin.banners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        alert()->success('بنر با موفقیت حذف شد','با تشکر');
        return redirect()->back();
    }
}

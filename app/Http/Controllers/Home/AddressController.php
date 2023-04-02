<?php

namespace App\Http\Controllers\Home;

use App\Models\City;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces=Province::all();
        $cities=City::all();
        $addresses=UserAddress::where('user_id',auth()->id())->get();
        return view('home.users_profile.addresses',compact('addresses','cities','provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validateWithBag('addressStore',[
            'title'=>'required|string',
            'address'=>'required',
            'postal_code'=>'required',
            'cellphone'=>'required',
            'province_id'=>'required',
            'city_id'=>'required',
        ]);

        UserAddress::create([
            'title'=>$request->title,
            'address'=>$request->address,
            'postal_code'=>$request->postal_code,
            'province_id'=>$request->province_id,
            'city_id'=>$request->city_id,
            'cellphone'=>$request->cellphone,
            'user_id'=>auth()->id(),
        ]);

        alert()->success('با تشکر','آدرس جدید با موفقیت ایجاد شد');
        return redirect()->back();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $userAddress)
    {

        $validator=Validator::make($request->all(),[
            'title'=>'required|string',
            'address'=>'required',
            'postal_code'=>'required',
            'cellphone'=>'required',
            'province_id'=>'required',
            'city_id'=>'required',
        ]);

        if( $validator->fails()){
            $validator->errors()->add('address_id',$userAddress->id);
            return redirect()->back()->withErrors($validator,'addressUpdate')->withInput();
        }

        $userAddress->update([
            'title'=>$request->title,
            'address'=>$request->address,
            'postal_code'=>$request->postal_code,
            'cellphone'=>$request->cellphone,
            'province_id'=>$request->province_id,
            'city_id'=>$request->city_id,
        ]);

        alert()->success('با تشکر','آدرس با موفقیت ویرایش شد');
        return redirect()->back();
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

    public function getProvinceCitiesList(Request $request)
    {
       $cities = City::where('province_id',$request->province_id)->get();
       return $cities;
    }
}

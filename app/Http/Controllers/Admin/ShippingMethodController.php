<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings=ShippingMethod::orderBy('id','DESC')->paginate(20);
        $max_serial=ShippingMethod::max('serial_num');
        return view('admin.'.Route::currentRouteName(),compact('shippings','max_serial'));
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
        $input = $request->all();

        try{
            $validator = Validator::make($input, [
                'title' => 'required|max:200|unique:shipping_methods,title,NULL,id,deleted_at,NULL',
                'description' => 'max:255',
                'cost' => 'required|min:0|max:9999999',
                'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
            ]);
            if ($validator->fails())
            {
                return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
            }

            $input['created_by']=\Auth::user()->id;


            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/brand/',150);
            }

            ShippingMethod::create($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'title' => "required|unique:shipping_methods,title,$id,id,deleted_at,NULL",
            'description' => 'max:255',
            'cost' => 'required|min:0|max:9999999',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $shippingMethod=ShippingMethod::findOrFail($id);
        $input['updated_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/brand/',150);

                if($shippingMethod->icon_photo!=null and file_exists($shippingMethod->icon_photo))
                {
                    unlink($shippingMethod->icon_photo);
                }
            }

            $shippingMethod->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shippingMethod=ShippingMethod::findOrFail($id);
        try{
            $shippingMethod->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}

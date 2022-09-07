<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands=Brand::orderBy('id','DESC')->paginate(200);
        $max_serial=Brand::max('serial_num');
        return view('admin.'.Route::currentRouteName(),compact('brands','max_serial'));
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
        if (is_null($request->link))
        {
            $input['link']= MyHelper::slugify($request->brand_name);
        }


        try{
            $validator = Validator::make($input, [
                'brand_name' => 'required|max:200|unique:brands,brand_name,NULL,id,deleted_at,NULL',
                'link' => 'required|unique:brands,link,NULL,id,deleted_at,NULL',
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

            Brand::create($input);
            return redirect()->back()->with('success','Data Successfully Saved');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'brand_name' => 'required|max:200',
            'link' => "required|unique:brands,link,$id,id,deleted_at,NULL",
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $brand=Brand::findOrFail($id);
        $input['updated_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/brand/',150);

                if($brand->icon_photo!=null and file_exists($brand->icon_photo))
                {
                    unlink($brand->icon_photo);
                }
            }

            $brand->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand=Brand::findOrFail($id);
        try{
            $brand->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}

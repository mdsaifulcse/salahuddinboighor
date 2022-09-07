<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackSizeUnit;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class PackSizeUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizeUnits=PackSizeUnit::orderBy('id','DESC')->paginate(20);
        $max_serial=PackSizeUnit::max('serial_num');
        return view('admin.'.Route::currentRouteName(),compact('sizeUnits','max_serial'));
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
            $input['link']= MyHelper::slugify($request->size);
        }


        $validator = Validator::make($input, [
            'size' => 'required|max:200|unique:pack_size_units,size,NULL,id,deleted_at,NULL',
            'link' => 'required|unique:pack_size_units,link,NULL,id,deleted_at,NULL',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $input['created_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/origin/',150);
            }

            PackSizeUnit::create($input);

            return redirect()->back()->with('success','Data Successfully Save');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PackSizeUnit  $packSizeUnit
     * @return \Illuminate\Http\Response
     */
    public function show(PackSizeUnit $packSizeUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PackSizeUnit  $packSizeUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(PackSizeUnit $packSizeUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PackSizeUnit  $packSizeUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'size' => "required|unique:pack_size_units,size,$id,id,deleted_at,NULL",
            'link' => "required|unique:pack_size_units,link,$id,id,deleted_at,NULL",
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $sizeUnit=PackSizeUnit::findOrFail($id);
        $input['updated_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/tags/',150);

                if($sizeUnit->icon_photo!=null and file_exists($sizeUnit->icon_photo))
                {
                    unlink($sizeUnit->icon_photo);
                }
            }

            $sizeUnit->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PackSizeUnit  $packSizeUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sizeUnit=PackSizeUnit::findOrFail($id);
        try{
            $sizeUnit->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}

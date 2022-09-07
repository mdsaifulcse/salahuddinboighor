<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeightUnit;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class WeightUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weights=WeightUnit::orderBy('id','DESC')->paginate(20);
        $max_serial=WeightUnit::max('serial_num');
        return view('admin.'.Route::currentRouteName(),compact('weights','max_serial'));
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
            $input['link']= MyHelper::slugify($request->weight_unit);
        }


        $validator = Validator::make($input, [
            'weight_unit' => 'required|max:200|unique:weight_units,weight_unit,NULL,id,deleted_at,NULL',
            'link' => 'required|unique:weight_units,link,NULL,id,deleted_at,NULL',
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
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/weight/',150);
            }

            WeightUnit::create($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeightUnit  $weightUnit
     * @return \Illuminate\Http\Response
     */
    public function show(WeightUnit $weightUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WeightUnit  $weightUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(WeightUnit $weightUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeightUnit  $weightUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'weight_unit' => "required|max:200|unique:weight_units,$id,id,deleted_at,NULL",
            'link' => "unique:weight_units,link,$id,id,deleted_at,NULL",
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $weight=WeightUnit::findOrFail($id);
        $input['updated_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/weight/',150);

                if($weight->icon_photo!=null and file_exists($weight->icon_photo))
                {
                    unlink($weight->icon_photo);
                }
            }

            $weight->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeightUnit  $weightUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $weight=WeightUnit::findOrFail($id);
        try{
            $weight->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}

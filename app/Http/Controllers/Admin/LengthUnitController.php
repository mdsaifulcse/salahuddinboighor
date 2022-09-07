<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LengthUnit;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class LengthUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lengths=LengthUnit::orderBy('id','DESC')->paginate(20);
        $max_serial=LengthUnit::max('serial_num');
        return view('admin.'.Route::currentRouteName(),compact('lengths','max_serial'));
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
            $input['link']= MyHelper::slugify($request->length_unit);
        }


        $validator = Validator::make($input, [
            'length_unit' => 'required|max:200|unique:length_units,length_unit,NULL,id,deleted_at,NULL',
            'link' => 'required|unique:length_units,link,NULL,id,deleted_at,NULL',
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

            LengthUnit::create($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LengthUnit  $lengthUnit
     * @return \Illuminate\Http\Response
     */
    public function show(LengthUnit $lengthUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LengthUnit  $lengthUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(LengthUnit $lengthUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LengthUnit  $lengthUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'length_unit' => "required|max:200|unique:length_units,length_unit,$id,id,deleted_at,NULL",
            'link' => "unique:length_units,link,$id,id,deleted_at,NULL",
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }

        try{
            $lengths=LengthUnit::findOrFail($id);
            $input['updated_by']=\Auth::user()->id;
            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/weight/',150);

                if($lengths->icon_photo!=null and file_exists($lengths->icon_photo))
                {
                    unlink($lengths->icon_photo);
                }
            }

            $lengths->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LengthUnit  $lengthUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lengths=LengthUnit::findOrFail($id);
        try{
            $lengths->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}

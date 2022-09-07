<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $data= Setting::first();
       return view('admin.users.setting',compact('data'));

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {

        $validator = Validator::make($request->all(),[
            'company_name' => 'required|max:120',
            'logo' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        DB::beginTransaction();
        try{
            $input=$request->except('_token','_method');

            if ($request->hasFile('logo'))
            {
                $input['logo']=\MyHelper::photoUpload($request->file('logo'),'images/logo/');

                if (!empty($setting) && file_exists($setting->logo))
                {
                    unlink($setting->logo);
                }
            }

            if ($request->hasFile('favicon'))
            {
                $input['favicon']=\MyHelper::photoUpload($request->file('favicon'),'images/favicon/');

                if (!empty($setting) && file_exists($setting->favicon))
                {
                    unlink($setting->favicon);
                }
            }

            $setting->update($input);


            $bug=0;
            DB::commit();

        }catch (\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
        }


        if($bug==0){
            return redirect()->back()->with('success','Data Successfully Updated');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}

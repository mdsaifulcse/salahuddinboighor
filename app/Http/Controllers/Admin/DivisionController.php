<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allData=Division::orderBy('division','ASC')->get();
        $max_serial=Division::max('serial_num');

        return view('admin.divisions.index',compact('allData','max_serial'));
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
            $link = str_replace(' , ', '-', $input['division']);
            $link = str_replace(', ', '-', $link);
            $link = str_replace(' ,', '-', $link);
            $link = str_replace(',', '-', $link);
            $link = str_replace('/', '-', $link);
            $link = rtrim($link, ' ');
            $link = str_replace(' ', '-', $link);
            $link = str_replace('.', '', $link);
            $link = substr($link, 0, 50);
            $link = strtolower($link);
            $input['link'] = $link;
        }

        $validator = Validator::make($input, [
            'division' => 'required',
            'link' => 'required|unique:divisions,link,NULL,id,deleted_at,NULL',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input['created_by']=\Auth::user()->id;

        if ($request->hasFile('icon_photo')) {

            $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/divisions/',120);

        }
        Division::create($input);
        try{
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data Successfully Created');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $data=Division::findOrFail($id);

        $validator = Validator::make($input, [
            'division' => 'required',
            'serial_num' => 'required',
            'link' => "required|unique:divisions,link,$id,id,deleted_at,NULL",
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error','Duplicate or empty record found.');
        }
        $input['updated_by']=\Auth::user()->id;

        if ($request->hasFile('icon_photo')) {
            $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/divisions/',120,100);

            if($data->icon_photo!=null and file_exists($data->icon_photo)){
                unlink($data->icon_photo);
            }
        }

        try{
            $data->update($input);
            $bug=0;
        }catch(\Exception $e){
            $bug = $e->errorInfo[1];
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
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=Division::findOrFail($id);
        try{
//            if($data->icon_photo!=null and file_exists($data->icon_photo)){
//                unlink($data->icon_photo);
//            }
            $data->delete();
            $bug=0;
            $error=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            $error=$e->errorInfo[2];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }elseif($bug==1451){
            return redirect()->back()->with('error','This Data is Used anywhere ! ');

        }
        elseif($bug>0){
            return redirect()->back()->with('error','Some thing error found !');

        }
    }
}

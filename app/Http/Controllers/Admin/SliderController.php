<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use DB,Auth,Validator,MyHelper,Route;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alldata=Slider::orderBy('serial_num','ASC')->paginate(10);
        $max_serial=Slider::max('serial_num')+1;
        return view('admin.slider.index',compact('alldata','max_serial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
public function create()
    {
        $max_serial=Slider::max('serial')+1;
        return view('backend.slider.create',compact('max_serial'));
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
        $validator = Validator::make($input, [
            'caption'=> 'required',
            'image'=> 'required',
            'overview'=> 'nullable',
            'url'=> 'nullable',
            'serial_num'=> 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')){
            //$phpo=$request->file('photo');
            $input['image']=\MyHelper::photoUpload($request->file('image'),'images/slider/');
        }

        try{
            $input['created_by']=Auth::user()->id;
            Slider::create($input);

            $bug=0;
        }catch(Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Slider Successfully Inserted');
        }else{
            return redirect()->back()->with('error',$bug);
        }
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
        $data=Slider::findOrFail($id);

        return view('backend.slider.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'caption'=> 'required',
            'overview'=> 'nullable',
            'url'=> 'nullable',
            'serial_num'=> 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $slider=Slider::findOrFail($id);

        if ($request->hasFile('image')){
            $input['image']=\MyHelper::photoUpload($request->file('image'),'images/slider/');
            if (file_exists($slider->image)){
                unlink($slider->image);
            }
        }

        try{
            $input['updated_by']=Auth::user()->id;
            $slider->update($input);
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Slider Successfully Update');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $input=Slider::findOrFail($id);

        DB::beginTransaction();
        try {

            $input->delete();

//            if (file_exists($input->image)){
//                unlink($input->image);
//            }


            $bug = 0;
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', ' slider Deleted Successfully.');
        }elseif ($bug==1451){
            return redirect()->back()->with('error', 'Sorry this users can not be delete due to used another module');
        }
        else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }
}

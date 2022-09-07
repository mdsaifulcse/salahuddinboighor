<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OurClient;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class OurClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allData=OurClient::orderBy('serial_num','ASC')->paginate(20);
        $max_serial=OurClient::max('serial_num')+1;
        return view('admin.our-client.index',compact('allData','max_serial'));
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
        $validator = Validator::make($input, [
            'name'=> 'required',
            'logo'=> 'required|image|mimes:jpeg,bmp,png|max:2048',
            'serial_num'=> 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('logo')){
            //$phpo=$request->file('photo');
            $input['logo']=\MyHelper::photoUpload($request->file('logo'),'images/client/',400);
        }

        try{
            OurClient::create($input);

            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data Successfully Save');
        }else{
            return redirect()->back()->with('error',$bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OurClient  $ourClient
     * @return \Illuminate\Http\Response
     */
    public function show(OurClient $ourClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OurClient  $ourClient
     * @return \Illuminate\Http\Response
     */
    public function edit(OurClient $ourClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OurClient  $ourClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name'=> 'required',
            'logo'=> 'nullable|image|mimes:jpeg,bmp,png|max:2048',
            'serial_num'=> 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $slider=OurClient::findOrFail($id);

        if ($request->hasFile('logo')){
            $input['logo']=\MyHelper::photoUpload($request->file('logo'),'images/client/',1300);
            if (file_exists($slider->image)){
                unlink($slider->image);
            }
        }

        try{
            $slider->update($input);
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data Successfully Update');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OurClient  $ourClient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=OurClient::findOrFail($id);

        DB::beginTransaction();
        try {

            $data->delete();

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
            return redirect()->back()->with('success', 'Client Data Deleted Successfully.');
        }elseif ($bug==1451){
            return redirect()->back()->with('error', 'Sorry this users can not be delete due to used another module');
        }
        else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }
}

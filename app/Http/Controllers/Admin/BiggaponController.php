<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biggapon;
use App\Models\Slider;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper,Route;

class BiggaponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alldata=Biggapon::orderBy('serial_num','DESC')->paginate(10);
        $max_serial=Biggapon::max('serial_num')+1;
        return view('admin.biggapon.index',compact('alldata','max_serial'));
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
            'place'=> 'required',
            'image'=> 'required|mimes:jpg,jpeg,png,webp,gif,bmp',
            'show_on_page'=> 'nullable',
            'serial_num'=> 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            if ($request->target_url==null){
                $input['target_url']='#';
            }
            if ($request->show_on_page==null){
                $input['show_on_page']=Biggapon::HOME_PAGE;
            }

            if ($request->hasFile('image')){
                //$phpo=$request->file('photo');
                if ($request->place==Biggapon::SIDE)
                {
                    $input['image']=\MyHelper::fileUpload($request->file('image'),'images/biggapon/');
                }else{
                    $input['image']=\MyHelper::fileUpload($request->file('image'),'images/biggapon/');
                }
            }
            if ($request->active_till){
                $input['active_till']=date('Y-m-d',strtotime($request->active_till));
            }

            Biggapon::create($input);

            $bug=0;
        }catch(Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Biggapon Successfully Inserted');
        }else{
            return redirect()->back()->with('error',$bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Biggapon  $biggapon
     * @return \Illuminate\Http\Response
     */
    public function show(Biggapon $biggapon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Biggapon  $biggapon
     * @return \Illuminate\Http\Response
     */
    public function edit(Biggapon $biggapon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Biggapon  $biggapon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'place'=> 'required',
            'image'=> 'nullable|mimes:jpg,jpeg,png,webp,gif,bmp',
            'show_on_page'=> 'nullable',
            'serial_num'=> 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $biggapon=Biggapon::findOrFail($id);


        try{

            if ($request->target_url==null){
                $input['target_url']='#';
            }

            if ($request->target_url==null){
                $input['target_url']='#';
            }

            if ($request->hasFile('image')){

                if ($request->place==Biggapon::SIDE)
                {
                    $input['image']=\MyHelper::fileUpload($request->file('image'),'images/biggapon/');
                }else{
                    $input['image']=\MyHelper::fileUpload($request->file('image'),'images/biggapon/');
                }


                if (file_exists($biggapon->image)){
                    unlink($biggapon->image);
                }
            }


            if ($request->active_till){
                $input['active_till']=date('Y-m-d',strtotime($request->active_till));
            }


            $input['updated_by']=Auth::user()->id;
            $biggapon->update($input);
            $bug=0;
        }catch(Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Biggapon Successfully Update');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Biggapon  $biggapon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=Biggapon::findOrFail($id);

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
            return redirect()->back()->with('success', ' Biggapon Deleted Successfully.');
        }elseif ($bug==1451){
            return redirect()->back()->with('error', 'Sorry this users can not be delete due to used another module');
        }
        else {
            return redirect()->back()->with('error', 'Something Error Found! ' . $bug1);
        }
    }
}
